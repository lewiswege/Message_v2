<?php

namespace App\Messaging\Drivers\Telegram;

use App\Messaging\Drivers\AbstractChannelDriver;
use App\Messaging\DTOs\ChannelCapabilities;
use App\Messaging\DTOs\ChannelResponse;
use App\Messaging\DTOs\InboundMessage;
use App\Messaging\DTOs\Message;
use App\Messaging\DTOs\ValidationResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramDriver extends AbstractChannelDriver
{
    public function send(Message $message): ChannelResponse
    {
        $payload = $this->formatMessage($message);

        $response = Http::post(
            sprintf(
                'https://api.telegram.org/bot%s/sendMessage',
                config('services.telegram.bot_token')
            ),
            $payload
        );

        return new ChannelResponse(
            success: $response->successful(),
            rawResponse: $response->json(),
            providerMessageId: $response->json('result.message_id'),
        );
    }

    public function parseInboundWebhook(Request $request): InboundMessage
    {
        $payload = $request->all();

        $from = $payload['message']['from'];

        $name = trim(
            ($from['first_name'] ?? '') .
            ' ' .
            ($from['last_name'] ?? '')
        );

        return new InboundMessage(
            channelIdentifier: (string) data_get($payload, 'message.chat.id'),
            content: data_get($payload, 'message.text', ''),
            channel: 'telegram',
            provider: 'telegram',

            customerName: $name ?: null,
            customerUsername: $from['username'] ?? null,

            providerMessageId: (string) data_get($payload, 'message.message_id'),
            metadata: $payload,
        );
    }

    public function getChannelIdentifier(): string
    {
        return 'telegram';
    }

    public function getCapabilities(): ChannelCapabilities
    {
        return new ChannelCapabilities(
            supportsImages: true,
            supportsDocuments: true,
            supportsButtons: true,
        );
    }

    public function validateOutbound(Message $message): ValidationResult
    {
        if (blank($message->content)) {
            return ValidationResult::failure([
                'Message content cannot be empty.',
            ]);
        }

        return ValidationResult::success();
    }

    public function formatMessage(Message $message): array
    {
        return [
            'chat_id' => $message->recipient,
            'text' => $message->content,
        ];
    }
}
