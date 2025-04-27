<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen w-full bg-gradient-to-br from-blue-50 to-indigo-50">
            <div class="container mx-auto min-h-screen flex flex-col items-center pt-8 sm:pt-12">
                @if(settings('site_logo'))
                    <div class="mb-4">
                        <a href="/">
                            <img src="{{ Storage::url(settings('site_logo')) }}" alt="{{ settings('site_name', 'Your Company') }}" class="w-16 h-16 object-contain">
                        </a>
                    </div>
                @else
                    <div class="mb-4">
                        <a href="/">
                            <x-application-logo class="w-16 h-16 text-indigo-600 fill-current" />
                        </a>
                    </div>
                @endif

                <div class="w-full max-w-[480px] px-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
