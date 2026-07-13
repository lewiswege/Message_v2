<div class="bg-white dark:bg-gray-900 rounded-xl border h-full flex flex-col overflow-hidden">    <div class="p-4 border-b">
        <h2 class="text-lg font-semibold">
            Conversations
        </h2>
    </div>

    <div class="flex-1 overflow-y-auto divide-y">

        @forelse($conversations as $conversation)

            <button
                wire:click="selectConversation('{{ $conversation->id }}')"
                @class([
                    'w-full text-left p-4 transition',
                    'bg-primary-50 dark:bg-primary-900/20 border-r-4 border-primary-600'
                        => $selectedConversationId === $conversation->id,
                    'hover:bg-gray-50 dark:hover:bg-gray-800'
                        => $selectedConversationId !== $conversation->id,
                ])
            >

                <div class="flex items-center justify-between">

                    <span class="font-medium">
                        {{ $conversation->customer?->name ?? 'Unknown Customer' }}
                    </span>

                    @if($conversation->unread_count)
                        <span class="bg-primary-600 text-white rounded-full px-2 py-1 text-xs">
                            {{ $conversation->unread_count }}
                        </span>
                    @endif

                </div>

                <div class="text-sm text-gray-500 mt-1">
                    {{ ucfirst($conversation->last_inbound_channel) }}
                </div>

                <div class="text-sm text-gray-600 dark:text-gray-400 truncate mt-2">
                    {{ $conversation->latestMessage?->content }}
                </div>

            </button>

        @empty

            <div class="p-8 text-center text-gray-500">
                No conversations found.
            </div>

        @endforelse

    </div>

</div>
