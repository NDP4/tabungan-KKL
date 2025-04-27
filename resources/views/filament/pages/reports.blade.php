<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Savings Summary Card -->
        <x-filament::card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium">Ringkasan Setoran</h2>
            </div>
            <div class="mt-4">
                <dl class="grid grid-cols-1 gap-4">
                    <div class="px-4 py-5 bg-gray-50 rounded-lg">
                        <dt class="text-sm font-medium text-gray-500">Total Setoran (Approved)</dt>
                        <dd class="mt-1 text-2xl font-semibold text-primary-600">
                            Rp {{ number_format(\App\Models\Saving::where('status', 'approved')->sum('amount'), 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 bg-gray-50 rounded-lg">
                        <dt class="text-sm font-medium text-gray-500">Jumlah Setoran Pending</dt>
                        <dd class="mt-1 text-2xl font-semibold text-warning-600">
                            {{ \App\Models\Saving::where('status', 'pending')->count() }}
                        </dd>
                    </div>
                </dl>
            </div>
        </x-filament::card>

        <!-- Students Summary Card -->
        <x-filament::card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium">Ringkasan Mahasiswa</h2>
            </div>
            <div class="mt-4">
                <dl class="grid grid-cols-1 gap-4">
                    <div class="px-4 py-5 bg-gray-50 rounded-lg">
                        <dt class="text-sm font-medium text-gray-500">Total Mahasiswa</dt>
                        <dd class="mt-1 text-2xl font-semibold text-primary-600">
                            {{ \App\Models\User::where('role', 'mahasiswa')->count() }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 bg-gray-50 rounded-lg">
                        <dt class="text-sm font-medium text-gray-500">Sudah Verifikasi Email</dt>
                        <dd class="mt-1 text-2xl font-semibold text-success-600">
                            {{ \App\Models\User::where('role', 'mahasiswa')->whereNotNull('email_verified_at')->count() }}
                        </dd>
                    </div>
                </dl>
            </div>
        </x-filament::card>
    </div>

    <div class="mt-8">
        <x-filament::card>
            <div class="prose max-w-none">
                <h3>Panduan Export Data</h3>
                <p>Gunakan tombol-tombol di atas untuk mengexport data dalam format yang Anda inginkan:</p>
                <ul>
                    <li><strong>Export Setoran (Excel/PDF)</strong> - Berisi data lengkap semua setoran mahasiswa</li>
                    <li><strong>Export Mahasiswa (Excel/PDF)</strong> - Berisi data lengkap semua mahasiswa beserta progress KKL</li>
                </ul>
                <p>File yang diexport akan otomatis terdownload dan bisa langsung dibuka dengan aplikasi yang sesuai.</p>
            </div>
        </x-filament::card>
    </div>
</x-filament-panels::page>
