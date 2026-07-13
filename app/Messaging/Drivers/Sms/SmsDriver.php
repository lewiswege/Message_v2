<?php

namespace App\Messaging\Drivers\Sms;

use App\Messaging\DTOs\ChannelCapabilities;
use App\Messaging\DTOs\ChannelResponse;
use App\Messaging\DTOs\InboundMessage;
use App\Messaging\DTOs\Message;
use App\Messaging\DTOs\ValidationResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Messaging\Drivers\AbstractChannelDriver;
use RuntimeException;

class SmsDriver extends AbstractChannelDriver
{
    public function send(Message $message): ChannelResponse
    {
        $payload = $this->formatMessage($message);

        $response = Http::withBasicAuth(
            config('sms.username'),
            config('sms.password')
        )->post(
            config('sms.url'),
            $payload
        );

        return new ChannelResponse(
            success: $response->successful(),
            providerMessageId: null,
            rawResponse: $response->json() ?? $response->body(),
        );
    }

    public function parseInboundWebhook(Request $request): InboundMessage
    {
        throw new RuntimeException(
            'Inbound SMS is not supported by the configured SMS gateway.'
        );
    }

    public function getChannelIdentifier(): string
    {
        return 'sms';
    }

    public function getCapabilities(): ChannelCapabilities
    {
        return new ChannelCapabilities(
            supportsImages: false,
            supportsDocuments: false,
            supportsButtons: false,
        );
    }

    public function validateOutbound(Message $message): ValidationResult
    {
        return ValidationResult::success();
    }

    public function formatMessage(Message $message): array
    {
        return [
            'provider' => config('sms.provider'),
            'number'   => $message->recipient,
            'content'  => $message->content,
        ];
    }
}
