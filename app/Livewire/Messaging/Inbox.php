<?php

namespace App\Livewire\Messaging;

use App\Models\Conversation;
use Livewire\Attributes\On;
use Livewire\Component;

class Inbox extends Component
{
    public ?string $selectedConversationId = null;

    public function mount(): void
    {
        $this->selectedConversationId = Conversation::query()
            ->orderByDesc('last_message_at')
            ->value('id');
    }

    #[On('conversation-selected')]
    public function selectConversation(string $conversationId): void
    {
        $this->selectedConversationId = $conversationId;
    }

    public function render()
    {
        $conversations = Conversation::query()
            ->with([
                'customer',
                'latestMessage',
            ])
            ->orderByDesc('last_message_at')
            ->get();

        $selectedConversation = $conversations
            ->firstWhere('id', $this->selectedConversationId);

        if ($selectedConversation) {
            $selectedConversation->loadMissing([
                'messages',
                'customer.channelIdentifiers',
            ]);
        }

        return view('livewire.messaging.inbox', [
            'conversations' => $conversations,
            'selectedConversation' => $selectedConversation,
        ]);
    }
}
