@if (! $conversation)

    <div class="rounded-xl border bg-white dark:bg-gray-900 h-full flex items-center justify-center text-gray-500">
        No conversation selected.
    </div>

@else

    @php
        $identifier = $conversation->customer
            ->channelIdentifiers
            ->firstWhere('channel', $conversation->last_inbound_channel);
    @endphp

<div class="rounded-xl border bg-white dark:bg-gray-900 h-full flex flex-col overflow-hidden">
        <div class="border-b p-4">
            <h2 class="font-semibold text-lg">
                Customer Details
            </h2>
        </div>

        <div class="flex-1 overflow-y-auto p-5">

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Name
                </div>

                <div class="font-medium">
                    {{ $conversation->customer->name }}
                </div>
            </div>

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Channel
                </div>

                <div>
                    {{ ucfirst($conversation->last_inbound_channel) }}
                </div>
            </div>

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Provider
                </div>

                <div>
                    {{ ucfirst($conversation->last_inbound_provider) }}
                </div>
            </div>

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Identifier
                </div>

                <div class="break-all">
                    {{ $identifier?->identifier ?? '—' }}
                </div>
            </div>

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Status
                </div>

                <div>
                    {{ ucfirst($conversation->status) }}
                </div>
            </div>

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Unread
                </div>

                <div>
                    {{ $conversation->unread_count }}
                </div>
            </div>

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Started
                </div>

                <div>
                    {{ $conversation->created_at->diffForHumans() }}
                </div>
            </div>

            <div>
                <div class="text-xs uppercase text-gray-500 mb-1">
                    Last Activity
                </div>

                <div>
                    {{ optional($conversation->last_message_at)->diffForHumans() }}
                </div>
            </div>

        </div>

    </div>

@endif
