<?php

namespace App\Messaging\Drivers\Contracts;

use App\Messaging\DTOs\ChannelCapabilities;
use App\Messaging\DTOs\ChannelResponse;
use App\Messaging\DTOs\InboundMessage;
use App\Messaging\DTOs\Message;
use App\Messaging\DTOs\ValidationResult;
use Illuminate\Http\Request;

interface ChannelDriverInterface
{
    public function send(Message $message): ChannelResponse;

    public function parseInboundWebhook(Request $request): InboundMessage;

    public function getChannelIdentifier(): string;

    public function getCapabilities(): ChannelCapabilities;

    public function supportsFeature(string $feature): bool;

    public function validateOutbound(Message $message): ValidationResult;

    public function formatMessage(Message $message): array;
}
