<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4 py-12 bg-gray-100 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg p-8 bg-white shadow-lg rounded-xl">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800">Buat Akun Baru</h2>
                <p class="mt-2 text-sm text-gray-600">Daftar untuk mulai menabung</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="mt-1">
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Mahasiswa (@mhs.dinus.ac.id)</label>
                    <div class="mt-1">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="122202300001@mhs.dinus.ac.id"
                            class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- NIM -->
                <div class="mt-4">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <div class="mt-1">
                        <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required autocomplete="nim"
                            placeholder="A22.2023.00001"
                            class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="mt-1">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Daftar
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Masuk sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
