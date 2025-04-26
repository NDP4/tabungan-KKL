<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabungan KKL - Aplikasi Menabung untuk Masa Depanmu</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="relative overflow-hidden">
        <!-- Header/Navigation -->
        <nav class="relative px-4 py-6 bg-white shadow-sm">
            <div class="container flex items-center justify-between mx-auto">
                <!-- Logo -->
                <div class="text-2xl font-bold text-indigo-600">
                    Tabungan KKL
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 font-medium text-white transition bg-indigo-600 rounded-md hover:bg-indigo-500">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                        class="px-4 py-2 font-medium text-indigo-600 transition hover:text-indigo-500">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                            class="px-4 py-2 font-medium text-white transition bg-indigo-600 rounded-md hover:bg-indigo-500">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative px-6 lg:px-8">
            <div class="py-20 mx-auto max-w-7xl">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        Menabung untuk KKL Jadi Lebih Mudah
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Aplikasi yang membantu mahasiswa mencapai target tabungan KKL sebesar Rp 1.950.000 dengan sistem nabung mingguan yang terstruktur.
                    </p>
                    <div class="flex items-center justify-center mt-10 gap-x-6">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 text-lg font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                Mulai Menabung
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-3 text-lg font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                                Mulai Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-white">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Fitur Utama</h2>
                </div>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-indigo-100 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Target Mingguan</h3>
                        <p class="mt-2 text-gray-600">Setoran mingguan Rp 10.000 untuk mencapai target dengan mudah</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-indigo-100 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Pantau Progress</h3>
                        <p class="mt-2 text-gray-600">Lihat perkembangan tabunganmu secara real-time dengan visualisasi yang jelas</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-indigo-100 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Mudah & Fleksibel</h3>
                        <p class="mt-2 text-gray-600">Setor tabungan via transfer atau tunai dengan konfirmasi otomatis</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t bg-gray-50">
            <div class="px-6 py-12 mx-auto max-w-7xl md:flex md:items-center md:justify-between lg:px-8">
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-sm text-center text-gray-600">
                        &copy; {{ date('Y') }} DTI. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
