<?php

namespace App\Messaging\Services;

use App\Messaging\DTOs\Message;
use App\Messaging\Managers\ChannelManager;
use App\Models\Conversation;
use RuntimeException;

class ReplyService
{
    public function __construct(
        private readonly ChannelManager $channelManager,
        private readonly MessageService $messageService,
    ) {
    }

    public function reply(
        Conversation $conversation,
        string $content,
    ): void {

        $conversation->loadMissing([
            'customer.channelIdentifiers',
        ]);

        $identifier = $conversation->customer
            ->channelIdentifiers
            ->firstWhere(
                'channel',
                $conversation->last_inbound_channel,
            );

        if (! $identifier) {
            throw new RuntimeException(
                'Customer has no identifier for this channel.'
            );
        }

        $message = new Message(
            recipient: $identifier->identifier,
            content: $content,
            channel: $conversation->last_inbound_channel,
            provider: $conversation->last_inbound_provider,
        );

        $response = $this->channelManager->send($message);

        $this->messageService->storeOutboundMessage(
            $conversation,
            $message,
            $response,
        );
    }
}
