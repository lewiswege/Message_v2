@if (!$conversation)

    <div class="h-full rounded-xl border bg-white dark:bg-gray-900 flex items-center justify-center">
        Select a conversation
    </div>

@else

    <div class="h-full rounded-xl border bg-white dark:bg-gray-900 flex flex-col overflow-hidden">

        <div class="border-b p-4">
            <h2 class="font-semibold text-lg">
                {{ $conversation->customer->name }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ ucfirst($conversation->last_inbound_channel) }}
            </p>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-4">

            @foreach($conversation->messages as $message)

                <div class="flex {{ $message->direction === 'outbound' ? 'justify-end' : 'justify-start' }}">

                    <div
                        class="max-w-[70%] rounded-2xl px-4 py-2 shadow
                        {{ $message->direction === 'outbound'
                            ? 'bg-primary-600 text-white'
                            : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' }}"
                    >

                        <p>{{ $message->content }}</p>

                        <div class="mt-1 text-xs opacity-70 text-right">
                            {{ $message->created_at->format('H:i') }}
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="border-t p-4">

            <form wire:submit="send">

                <div class="flex gap-3">

                    <textarea
                        wire:model.live="reply"
                        rows="2"
                        class="flex-1 rounded-lg border"
                        placeholder="Type your reply..."
                    ></textarea>

                    <button
                        type="submit"
                        class="px-5 py-2 rounded-lg bg-primary-600 text-white"
                    >
                        Send
                    </button>

                </div>

            </form>

        </div>

    </div>

@endif
