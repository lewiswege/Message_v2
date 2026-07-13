<?php

namespace App\Messaging\Services;

use App\Messaging\DTOs\InboundMessage;
use App\Models\Customer;
use App\Models\CustomerChannelIdentifier;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function resolveCustomer(InboundMessage $message): Customer
    {
        $customer = $this->findCustomer($message);

        if ($customer) {

            if ($customer->name === null && $message->customerName !== null) {
                $customer->update([
                    'name' => $message->customerName,
                    ]);
            }

            return $customer;
        }

        return $this->createCustomer($message);
    }

    private function findCustomer(InboundMessage $message): ?Customer
    {
        //Used chained where() calls to preven php analyser errors
        $identifier = CustomerChannelIdentifier::query()
            ->where('channel', $message->channel)
            ->where('provider', $message->provider)
            ->where('identifier', $message->channelIdentifier)
            ->first();

        return $identifier?->customer;
    }

    private function createCustomer(InboundMessage $message): Customer
    {
        return DB::transaction(function () use ($message) {

            $customer = Customer::create([
                'name' => $message->customerName,
            ]);

            $customer->channelIdentifiers()->create([
                'channel' => $message->channel,
                'provider' => $message->provider,
                'identifier' => $message->channelIdentifier,
                'metadata' => $message->metadata,
            ]);

            return $customer;
        });
    }
}

//Neither methods know about each other the public method orchestrates them
