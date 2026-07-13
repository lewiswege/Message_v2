<?php

namespace App\Messaging\Services;

use App\Events\MessageCreated;
use App\Messaging\DTOs\BroadcastMessage;
use App\Messaging\DTOs\ChannelResponse;
use App\Messaging\DTOs\InboundMessage;
use App\Messaging\DTOs\Message;
use App\Models\Conversation;
use App\Models\Message as MessageModel;
use Illuminate\Support\Facades\DB;

class MessageService
{
    public function storeInboundMessage(
        Conversation $conversation,
        InboundMessage $message
    ): MessageModel {
        return DB::transaction(function () use ($conversation, $message) {

            $storedMessage = $conversation->messages()->create([
                'direction'          => MessageModel::DIRECTION_INBOUND,
                'channel'            => $message->channel,
                'provider'           => $message->provider,
                'channel_message_id' => $message->providerMessageId,
                'content_type'       => MessageModel::CONTENT_TEXT,
                'content'            => $message->content,
                'metadata'           => $message->metadata,
                'status'             => MessageModel::STATUS_DELIVERED,
                'status_updated_at'  => now(),
            ]);

            $conversation->update([
                'last_message_at'       => now(),
                'last_inbound_channel'  => $message->channel,
                'last_inbound_provider' => $message->provider,
                'unread_count'          => $conversation->unread_count + 1,
            ]);

            event(new MessageCreated(
                new BroadcastMessage(
                    id: $storedMessage->id,
                    conversationId: $storedMessage->conversation_id,
                    direction: $storedMessage->direction,
                    channel: $storedMessage->channel,
                    content: $storedMessage->content,
                    createdAt: $storedMessage->created_at->toISOString(),
                )
            ));

            return $storedMessage;
        });
    }

    public function storeOutboundMessage(
        Conversation $conversation,
        Message $message,
        ChannelResponse $response,
    ): MessageModel {
        return DB::transaction(function () use ($conversation, $message, $response) {

            $storedMessage = $conversation->messages()->create([
                'direction'          => MessageModel::DIRECTION_OUTBOUND,
                'channel'            => $message->channel,
                'provider'           => $message->provider,
                'channel_message_id' => $response->providerMessageId,
                'content_type'       => MessageModel::CONTENT_TEXT,
                'content'            => $message->content,
                'metadata'           => $message->metadata,
                'status'             => $response->success
                    ? MessageModel::STATUS_SENT
                    : MessageModel::STATUS_FAILED,
                'status_updated_at'  => now(),
                'failure_reason'     => $response->success
                    ? null
                    : json_encode($response->rawResponse),
            ]);

            $conversation->update([
                'last_message_at' => now(),
            ]);

            event(new MessageCreated(
                new BroadcastMessage(
                    id: $storedMessage->id,
                    conversationId: $storedMessage->conversation_id,
                    direction: $storedMessage->direction,
                    channel: $storedMessage->channel,
                    content: $storedMessage->content,
                    createdAt: $storedMessage->created_at->toISOString(),
                )
            ));

            return $storedMessage;
        });
    }
}
