<?php

namespace App\Messaging\Managers;

use App\Jobs\ProcessOutboundMessage;
use App\Messaging\Drivers\Contracts\ChannelDriverInterface;
use App\Messaging\Services\ConversationService;
use App\Messaging\Services\CustomerService;
use App\Messaging\Services\MessageService;
use App\Messaging\DTOs\Message;
use App\Messaging\DTOs\ChannelResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ChannelManager
{
    /**
     * @param iterable<ChannelDriverInterface> $drivers
     */
    public function __construct(
        private readonly iterable $drivers,
        private readonly CustomerService $customerService,
        private readonly ConversationService $conversationService,
        private readonly MessageService $messageService,
    ) {
    }

    public function handleWebhook(string $channel, Request $request): void
    {
        $driver = $this->driver($channel);
        $message = $driver->parseInboundWebhook($request);
        $customer = $this->customerService->resolveCustomer($message);
        $conversation = $this->conversationService->resolveConversation($customer);
        $this->messageService->storeInboundMessage($conversation, $message);

       ProcessOutboundMessage::dispatch(
            conversationId: $conversation->id,
            recipient: $message->channelIdentifier,
            content: 'This is a testing automated reply.',
            channel: $message->channel,
            provider: $message->provider,
        );
    }

    private function driver(string $channel): ChannelDriverInterface
    {
        foreach ($this->drivers as $driver) {
            if ($driver->getChannelIdentifier() === $channel) {
                return $driver;
            }
        }

        throw new InvalidArgumentException(
            "No driver registered for channel [{$channel}]."
        );
    }

    public function send(Message $message): ChannelResponse
    {
        $driver = $this->driver($message->channel);

        $validation = $driver->validateOutbound($message);

        if (! $validation->valid) {
            throw new \InvalidArgumentException(
                implode(', ', $validation->errors)
            );
        }

        return $driver->send($message);
    }

}
