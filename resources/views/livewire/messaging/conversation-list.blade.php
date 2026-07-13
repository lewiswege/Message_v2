<div class="h-full flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">

    {{-- Header --}}
    <div class="border-b border-gray-200 dark:border-gray-700 p-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            Conversations
        </h2>
    </div>

    {{-- Conversation List --}}
    <div class="flex-1 overflow-y-auto divide-y divide-gray-200 dark:divide-gray-700">

        @forelse($conversations as $conversation)

            <button
                wire:click="selectConversation('{{ $conversation->id }}')"
                @class([
                    'w-full p-4 text-left transition-all duration-200',

                    // Selected conversation
                    'bg-primary-50 dark:bg-primary-900/20 border-r-4 border-primary-600'
                        => $selectedConversationId === $conversation->id,

                    // Normal state
                    'hover:bg-gray-50 dark:hover:bg-gray-800'
                        => $selectedConversationId !== $conversation->id,
                ])
            >

                {{-- Name + Badge --}}
                <div class="flex items-center justify-between gap-3">

                    <span class="truncate font-semibold text-gray-900 dark:text-white">
                        {{ $conversation->customer?->name ?? 'Unknown Customer' }}
                    </span>

                    @if($conversation->unread_count)

                        <span class="shrink-0 rounded-full bg-primary-600 px-2 py-0.5 text-xs font-semibold text-white">
                            {{ $conversation->unread_count }}
                        </span>

                    @endif

                </div>

                {{-- Channel --}}
                <p class="mt-1 text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    {{ ucfirst($conversation->last_inbound_channel) }}
                </p>

                {{-- Latest Message --}}
                <p class="mt-2 truncate text-sm text-gray-600 dark:text-gray-300">
                    {{ $conversation->latestMessage?->content ?? 'No messages yet.' }}
                </p>

            </button>

        @empty

            <div class="flex h-40 items-center justify-center p-6 text-center">

                <div>

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        No conversations found.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

</div>
