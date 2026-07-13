<div class="h-[calc(100vh-8rem)] overflow-hidden">

    <div class="grid h-full grid-cols-1 lg:grid-cols-12 gap-4">

        {{-- Conversation List --}}
        <aside class="lg:col-span-3 h-full overflow-hidden">

            <livewire:messaging.conversation-list
                :conversations="$conversations"
                :selected-conversation-id="$selectedConversationId"
                wire:key="conversation-list"
            />

        </aside>

        {{-- Conversation View --}}
        <main class="lg:col-span-6 h-full overflow-hidden">

            <livewire:messaging.conversation-view
                :conversation="$selectedConversation"
                wire:key="conversation-view-{{ $selectedConversationId }}"
            />

        </main>

        {{-- Customer Sidebar --}}
        <aside class="hidden xl:block xl:col-span-3 h-full overflow-hidden">

            <livewire:messaging.conversation-sidebar
                :conversation="$selectedConversation"
                wire:key="conversation-sidebar-{{ $selectedConversationId }}"
            />

        </aside>

    </div>

</div>
