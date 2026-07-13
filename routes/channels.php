<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    'conversations.{conversationId}',
    function ($user, string $conversationId) {
        return true;
    }
);
