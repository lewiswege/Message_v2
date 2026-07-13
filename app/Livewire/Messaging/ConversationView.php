<?php

namespace App\Livewire\Messaging;

use App\Models\Conversation;
use Livewire\Component;
use App\Messaging\Services\ReplyService;

class ConversationView extends Component
{
    public ?Conversation $conversation = null;
    public string $reply = '';

    public function render()
    {
        return view('livewire.messaging.conversation-view');
    }

    public function send(ReplyService $replyService): void
    {
        if (! $this->conversation) {
            return;
        }

        $content = trim($this->reply);

        if ($content === '') {
            return;
        }

        $replyService->reply(
            $this->conversation,
            $content,
        );

        $this->reply = '';

        $this->conversation->load([
            'customer',
            'messages' => fn ($query) => $query->oldest(),
        ]);
    }
}
