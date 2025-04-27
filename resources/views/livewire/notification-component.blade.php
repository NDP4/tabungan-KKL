<div class="relative" x-data="{ open: false }" wire:poll.15s="loadNotifications">
    <button @click="open = !open" type="button" class="relative p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        <span class="absolute -inset-1.5"></span>
        <span class="sr-only">View notifications</span>
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-semibold text-white bg-red-500 rounded-full -top-1 -right-1">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open"
         @click.away="open = false"
         x-cloak
         class="absolute right-0 z-50 mt-2 origin-top-right bg-white rounded-lg shadow-lg w-80 ring-1 ring-black ring-opacity-5">
        <div class="p-4">
            {{-- <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium">Notifikasi ({{ $unreadCount }})</h3>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" type="button"
                            class="text-sm text-blue-600 hover:text-blue-800 focus:outline-none">
                        Tandai semua dibaca
                    </button>
                @endif
            </div> --}}

            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="relative p-4 transition-colors {{ is_null($notification->read_at) ? 'bg-blue-50' : 'bg-white' }} hover:bg-gray-50 rounded-md">
                        <div class="flex justify-between">
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    {{ $notification->data['message'] }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            {{-- <div class="flex items-center space-x-2">
                                @if(is_null($notification->read_at))
                                    <button wire:click="markAsRead('{{ $notification->id }}')" type="button"
                                            class="text-sm text-blue-600 hover:text-blue-800 focus:outline-none">
                                        Tandai dibaca
                                    </button>
                                @endif
                                <button wire:click="deleteNotification('{{ $notification->id }}')" type="button"
                                        class="text-sm text-red-600 hover:text-red-800 focus:outline-none">
                                    Hapus
                                </button>
                            </div> --}}
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center text-gray-500">
                        Tidak ada notifikasi
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
