<?php

namespace App\Events;

use App\Messaging\DTOs\BroadcastMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public readonly BroadcastMessage $message,
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel("conversations.{$this->message->conversationId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.created';
    }

    public function broadcastWith(): array
    {
        return [
            'conversation_id' => $this->message->conversationId,

            'message' => [
                'id' => $this->message->id,
                'direction' => $this->message->direction,
                'channel' => $this->message->channel,
                'content' => $this->message->content,
                'created_at' => $this->message->createdAt,
            ],
        ];
    }
}
