<?php

namespace App\Providers;

use App\Messaging\Managers\ChannelManager;
use App\Messaging\Drivers\Sms\SmsDriver;
use App\Messaging\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\ServiceProvider;

class ChannelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ChannelManager::class, function ($app) {

            $drivers = [
                $app->make(SmsDriver::class),
                $app->make(TelegramDriver::class),
                // $app->make(WhasappDriver::class),
                // $app->make(InstagramDriver::class),
            ];

            return new ChannelManager(
                $drivers,
                $app->make(\App\Messaging\Services\CustomerService::class),
                $app->make(\App\Messaging\Services\ConversationService::class),
                $app->make(\App\Messaging\Services\MessageService::class),
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
