<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen pt-0 bg-gray-100">
        <div class="w-full max-w-xl p-8 bg-white shadow-lg rounded-xl">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800">Selamat Datang</h2>
                <p class="mt-2 text-sm text-gray-600">Silakan masuk ke akun Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Email or NIM -->
                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700">Email atau NIM</label>
                    <div class="mt-1">
                        <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                            placeholder="Email atau NIM Anda"
                            class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('login')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" type="password" name="password" required
                            class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="remember_me" class="block ml-2 text-sm text-gray-700">
                            Ingat Saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                            class="font-medium text-blue-600 hover:text-blue-500">
                            Lupa password?
                        </a>
                    </div>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Masuk
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
