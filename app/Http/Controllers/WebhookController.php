<?php

namespace App\Http\Controllers;

use App\Messaging\Managers\ChannelManager;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __construct(
        private readonly ChannelManager $channelManager,
    ) {
    }

    public function handle(Request $request, string $channel)
    {
        $this->channelManager->handleWebhook($channel, $request);

        return response()->json([
            'success' => true,
        ]);
    }
}
