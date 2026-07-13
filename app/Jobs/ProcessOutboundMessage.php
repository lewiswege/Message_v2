<?php

namespace App\Jobs;

use App\Messaging\Services\ReplyService;
use App\Models\Conversation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessOutboundMessage implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $conversationId,
        public readonly string $recipient,
        public readonly string $content,
        public readonly string $channel,
        public readonly string $provider,
    ) {
    }

    public function handle(ReplyService $replyService): void
    {
        $conversation = Conversation::findOrFail($this->conversationId);

        $replyService->reply(
            conversation: $conversation,
            recipient: $this->recipient,
            content: $this->content,
            channel: $this->channel,
            provider: $this->provider,
        );
    }
}
