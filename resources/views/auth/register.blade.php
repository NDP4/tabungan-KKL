<x-guest-layout>
    <div class="w-full bg-white rounded-2xl shadow-xl p-6 sm:p-8">
        <div class="text-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
            <p class="text-sm sm:text-base text-gray-600">Daftar untuk mulai menabung</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 h-12 border border-gray-300 rounded-xl text-gray-900 text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Masukkan nama lengkap" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Mahasiswa</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 h-12 border border-gray-300 rounded-xl text-gray-900 text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="122202300001@mhs.dinus.ac.id" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <div class="relative">
                    <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required
                        class="w-full px-4 h-12 border border-gray-300 rounded-xl text-gray-900 text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="A22.2023.00001" />
                </div>
                <x-input-error :messages="$errors->get('nim')" class="mt-1" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 h-12 border border-gray-300 rounded-xl text-gray-900 text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Minimal 8 karakter" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 h-12 border border-gray-300 rounded-xl text-gray-900 text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Masukkan ulang password" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <button type="submit"
                class="w-full h-12 flex items-center justify-center border border-transparent rounded-xl text-sm sm:text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 mt-6">
                Daftar Sekarang
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                        Masuk sekarang
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
