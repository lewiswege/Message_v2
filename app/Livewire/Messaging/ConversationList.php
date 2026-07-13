<?php

namespace App\Livewire\Messaging;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ConversationList extends Component
{
    public Collection $conversations;

    public ?string $selectedConversationId = null;

    public function selectConversation(string $conversationId): void
    {
        $this->dispatch('conversation-selected', conversationId: $conversationId)
            ->to(Inbox::class);
    }

    public function render()
    {
        return view('livewire.messaging.conversation-list');
    }
}
