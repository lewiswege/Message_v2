<?php

namespace App\Messaging\Services;

use App\Models\Conversation;
use App\Models\Customer;
use Illuminate\Support\Carbon;

class ConversationService
{
    public function resolveConversation(Customer $customer): Conversation
    {
        $conversation = $this->findActiveConversation($customer);

        if ($conversation) {
            return $conversation;
        }

        return $this->createConversation($customer);
    }

    private function findActiveConversation(Customer $customer): ?Conversation
    {
        return $customer->conversations()
            ->where('status', Conversation::STATUS_OPEN)
            ->latest()
            ->first();
    }

    private function createConversation(Customer $customer): Conversation
    {
        return $customer->conversations()->create([
            'status' => Conversation::STATUS_OPEN,
            'last_message_at' => Carbon::now(),
            'unread_count' => 0,
        ]);
    }
}
