<?php

namespace App\Messaging\Drivers;

use App\Messaging\Drivers\Contracts\ChannelDriverInterface;
use App\Messaging\DTOs\ChannelCapabilities;

abstract class AbstractChannelDriver implements ChannelDriverInterface
{
    public function supportsFeature(string $feature): bool
    {
        $capabilities = $this->getCapabilities();

        return match ($feature) {
            'images' => $capabilities->supportsImages,
            'documents' => $capabilities->supportsDocuments,
            'buttons' => $capabilities->supportsButtons,
            default => false,
        };
    }
}
