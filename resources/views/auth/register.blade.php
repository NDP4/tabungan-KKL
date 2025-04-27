<x-guest-layout>
    <div class="w-full p-6 bg-white shadow-xl rounded-2xl sm:p-8">
        <div class="mb-6 text-center sm:mb-8">
            <h2 class="mb-2 text-2xl font-bold text-gray-900 sm:text-3xl">Buat Akun Baru</h2>
            <p class="text-sm text-gray-600 sm:text-base">Daftar untuk mulai menabung</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                <div class="relative">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full h-12 px-4 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 border border-gray-300 rounded-xl sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Masukkan nama lengkap" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email Mahasiswa</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full h-12 px-4 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 border border-gray-300 rounded-xl sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="122202300001@mhs.dinus.ac.id" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            {{-- <div>
                <label for="nim" class="block mb-1 text-sm font-medium text-gray-700">NIM</label>
                <div class="relative">
                    <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required
                        class="w-full h-12 px-4 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 border border-gray-300 rounded-xl sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="A22.2023.00001" />
                </div>
                <x-input-error :messages="$errors->get('nim')" class="mt-1" />
            </div> --}}

            <div>
                <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full h-12 px-4 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 border border-gray-300 rounded-xl sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Minimal 8 karakter" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full h-12 px-4 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 border border-gray-300 rounded-xl sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Masukkan ulang password" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <button type="submit"
                class="flex items-center justify-center w-full h-12 mt-6 text-sm font-semibold text-white transition-all duration-200 bg-blue-600 border border-transparent rounded-xl sm:text-base hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Daftar Sekarang
            </button>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 transition-colors duration-200 hover:text-blue-500">
                        Masuk sekarang
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
