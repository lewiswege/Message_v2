<?php
// Adding a new driver is now easy we only change this file. 
return [
    'drivers' => [
        App\Messaging\Drivers\Sms\SmsDriver::class,
        // App\Messaging\Drivers\Telegram\TelegramDriver::class,
        // App\Messaging\Drivers\Whatsapp\WhatsappDriver::class,
        // APp\Messaging\Drivers\Instagram\InstagramDriver::class,
    ],
];
