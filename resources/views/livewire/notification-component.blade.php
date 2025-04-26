<div x-data="{ open: false }" @notification-read.window="$wire.$refresh()" @all-notifications-read.window="$wire.$refresh()" class="relative">
    <button @click="open = !open" class="relative p-2 text-sm text-gray-700 bg-white rounded-full hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <span class="sr-only">View notifications</span>
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $unreadCount }}</span>
        @endif
    </button>

    <div x-show="open"
         @click.away="open = false"
         class="absolute right-0 z-50 mt-2 origin-top-right bg-white rounded-lg shadow-lg w-80 ring-1 ring-black ring-opacity-5"
         style="top: 100%;">
        <div class="py-1">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="flex items-start px-4 py-2 text-sm {{ !$notification->read_at ? 'bg-blue-50' : '' }} hover:bg-gray-50">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900">
                                {{ $notification->data['message'] ?? 'Notification' }}
                            </p>
                            @if(isset($notification->data['amount']))
                                <p class="mt-1 text-gray-500">
                                    Rp {{ number_format($notification->data['amount'], 0, ',', '.') }}
                                </p>
                            @endif
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if(!$notification->read_at)
                            <button wire:click="markAsRead('{{ $notification->id }}')" class="ml-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                Mark as read
                            </button>
                        @endif
                    </div>
                @endforeach
                @if($unreadCount > 0)
                    <div class="px-4 py-2 text-sm border-t border-gray-100">
                        <button wire:click="markAllAsRead" class="w-full text-center text-indigo-600 hover:text-indigo-800">
                            Mark all as read
                        </button>
                    </div>
                @endif
            @else
                <div class="px-4 py-6 text-sm text-center text-gray-500">
                    No notifications
                </div>
            @endif
        </div>
    </div>
</div>
