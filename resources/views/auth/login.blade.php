<x-guest-layout>
    <div class="w-full bg-white rounded-2xl shadow-xl p-6 sm:p-8">
        <div class="text-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
            <p class="text-sm sm:text-base text-gray-600">Silakan masuk ke akun Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Email atau NIM</label>
                <div class="relative">
                    <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                        class="w-full px-4 h-12 border border-gray-300 rounded-xl text-gray-900 text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Masukkan email atau NIM" />
                </div>
                <x-input-error :messages="$errors->get('login')" class="mt-1" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 h-12 border border-gray-300 rounded-xl text-gray-900 text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Masukkan password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 text-sm text-gray-700">
                        Ingat Saya
                    </label>
                </div>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                    Lupa password?
                </a>
                @endif
            </div>

            <button type="submit"
                class="w-full h-12 flex items-center justify-center border border-transparent rounded-xl text-sm sm:text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 mt-6">
                Masuk
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
