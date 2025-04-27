<x-guest-layout>
    <div class="w-full bg-white rounded-2xl shadow-xl p-6 sm:p-8">
        <div class="text-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
            <p class="text-sm sm:text-base text-gray-600">Silakan masuk ke akun Anda</p>
        </div>

        <div class="mb-6 text-center">
            <a href="{{ route('auth.google') }}"
               class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                    <path d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.345-7.574 7.439-7.574c2.33 0 3.891.989 4.785 1.849l3.254-3.138C18.189 1.186 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.869 11.52-11.726 0-.788-.085-1.39-.189-1.989H12.24z" fill="currentColor"/>
                </svg>
                Masuk dengan Google
            </a>
        </div>

        <div class="relative flex items-center justify-center my-6">
            <div class="absolute w-full border-t border-gray-300"></div>
            <div class="relative px-4 text-sm text-gray-500 bg-white">atau</div>
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
