<?php

namespace App\Livewire\Messaging;

use App\Models\Conversation;
use Livewire\Component;

class ConversationSidebar extends Component
{
    public ?Conversation $conversation = null;

    public function render()
    {
        return view('livewire.messaging.conversation-sidebar');
    }
}
