<div class="grid grid-cols-12 gap-4 h-[calc(100vh-12rem)]">

    <aside class="col-span-3 min-h-0 overflow-hidden">
        <livewire:messaging.conversation-list
            :conversations="$conversations"
            :selected-conversation-id="$selectedConversationId"
            wire:key="conversation-list"
        />
    </aside>

    <main class="col-span-6 min-h-0 overflow-hidden">
        <livewire:messaging.conversation-view
            :conversation="$selectedConversation"
            wire:key="conversation-view-{{ $selectedConversationId }}"
        />
    </main>

    <aside class="col-span-3 min-h-0 overflow-hidden">
        <livewire:messaging.conversation-sidebar
            :conversation="$selectedConversation"
            wire:key="conversation-sidebar-{{ $selectedConversationId }}"
        />
    </aside>

</div>
