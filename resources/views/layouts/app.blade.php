<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ settings('site_name', config('app.name')) }}</title>

    @if(settings('favicon'))
        <link rel="icon" type="image/png" href="{{ Storage::url(settings('favicon')) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    @livewireStyles
    {{-- @livewire('notification-component') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans antialiased" x-data="{ mobileMenuOpen: false }">
    <div class="min-h-full">
        <nav class="bg-white shadow">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo and Site Name -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ url('/') }}" class="flex items-center">
                                @if(settings('site_logo'))
                                    <img class="w-auto h-8" src="{{ Storage::url(settings('site_logo')) }}" alt="{{ settings('site_name', 'Your Company') }}">
                                @else
                                    <img class="w-8 h-8" src="https://tailwindui.com/img/logos/mark.svg?color=white" alt="{{ settings('site_name', 'Your Company') }}">
                                @endif
                                <span class="ml-2 text-lg font-semibold text-gray-900">{{ settings('site_name', config('app.name')) }}</span>
                            </a>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:ml-6 md:flex md:space-x-4">
                            <a href="{{ route('dashboard') }}"
                               class="{{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white' : 'text-gray-900 hover:bg-indigo-500 hover:text-white' }} px-3 py-2 text-sm font-medium rounded-md">
                                Dashboard
                            </a>
                            @if(auth()->user()->role === 'bendahara' || auth()->user()->role === 'panitia')
                                <a href="{{ route('filament.admin.pages.dashboard') }}"
                                   class="px-3 py-2 text-sm font-medium text-gray-900 rounded-md hover:bg-indigo-500 hover:text-white">
                                    Admin Panel
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center ml-4 md:ml-6">
                            <!-- Notification Component -->
                            @livewire('notification-component')

                            <div class="relative ml-3" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" type="button" class="flex items-center max-w-xs text-sm bg-indigo-700 rounded-full focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" id="user-menu-button">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="flex items-center justify-center w-8 h-8 text-white rounded-full">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </button>
                                </div>
                                <div x-show="open"
                                     @click.away="open = false"
                                     class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                     role="menu">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex -mr-2 md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-500">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div class="md:hidden" x-show="mobileMenuOpen" x-cloak>
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white' : 'text-gray-900 hover:bg-indigo-500 hover:text-white' }} block px-3 py-2 text-base font-medium rounded-md">
                            Dashboard
                        </a>
                        @if(auth()->user()->role === 'bendahara' || auth()->user()->role === 'panitia')
                            <a href="{{ route('filament.admin.pages.dashboard') }}"
                               class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-indigo-500 hover:text-white">
                                Admin Panel
                            </a>
                        @endif
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center w-10 h-10 text-white bg-indigo-700 rounded-full">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                            <div class="ml-auto">
                                @livewire('notification-component')
                            </div>
                        </div>
                        <div class="px-2 mt-3 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-3 py-2 text-base font-medium text-left text-gray-900 rounded-md hover:bg-gray-100">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                @if (session('success'))
                    <x-alert type="success">
                        {{ session('success') }}
                    </x-alert>
                @endif

                @if (session('error'))
                    <x-alert type="error">
                        {{ session('error') }}
                    </x-alert>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')

    <!-- jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        // Configure toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Handle Livewire events
        document.addEventListener('livewire:init', () => {
            // Listen for generic alert events
            Livewire.on('alert', (data) => {
                const type = data[0].type;
                const message = data[0].message;

                switch(type) {
                    case 'success':
                        toastr.success(message);
                        break;
                    case 'error':
                        toastr.error(message);
                        break;
                    case 'warning':
                        toastr.warning(message);
                        break;
                    case 'info':
                        toastr.info(message);
                        break;
                    default:
                        toastr.info(message);
                }
            });
        });

        // Handle session flash messages
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    </script>
</body>
</html>
