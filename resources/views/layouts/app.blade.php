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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans antialiased">
    <div class="min-h-full">
        <nav class="bg-indigo-600">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if(settings('site_logo'))
                                <img class="w-auto h-8" src="{{ Storage::url(settings('site_logo')) }}" alt="{{ settings('site_name', 'Your Company') }}">
                            @else
                                <img class="w-8 h-8" src="https://tailwindui.com/img/logos/mark.svg?color=white" alt="{{ settings('site_name', 'Your Company') }}">
                            @endif
                        </div>
                        <div class="hidden md:block">
                            <div class="flex items-baseline ml-10 space-x-4">
                                <span class="mr-4 font-semibold text-white">{{ settings('site_name', config('app.name')) }}</span>
                                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white' : 'text-white hover:bg-indigo-500' }} rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>
                                @if(auth()->user()->role === 'bendahara' || auth()->user()->role === 'panitia')
                                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="px-3 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-500">Admin Panel</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center ml-4 md:ml-6">
                            <div class="relative ml-3" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" type="button" class="flex items-center max-w-xs text-sm text-white bg-indigo-600 rounded-full focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" id="user-menu-button">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="flex items-center justify-center w-8 h-8 bg-indigo-700 rounded-full">
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

    @stack('scripts')
</body>
</html>
