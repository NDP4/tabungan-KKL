<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-6 overflow-hidden transition-all bg-white shadow-sm sm:rounded-lg hover:shadow-md">
                    <div class="text-sm font-medium text-gray-600">Total Tabungan Kamu</div>
                    <div class="mt-2 text-2xl font-bold text-blue-700">Rp {{ number_format($totalSavings, 0, ',', '.') }}</div>
                </div>
                <div class="p-6 overflow-hidden transition-all bg-white shadow-sm sm:rounded-lg hover:shadow-md">
                    <div class="text-sm font-medium text-gray-600">Total Tabungan Angkatan</div>
                    <div class="mt-2 text-2xl font-bold text-blue-700">Rp {{ number_format($totalClassSavings, 0, ',', '.') }}</div>
                    <div class="mt-1 text-xs text-gray-500">dari {{ $totalParticipants }} mahasiswa</div>
                </div>
                <div class="p-6 overflow-hidden transition-all bg-white shadow-sm sm:rounded-lg hover:shadow-md">
                    <div class="text-sm font-medium text-gray-600">Total Pengeluaran</div>
                    <div class="mt-2 text-2xl font-bold text-red-500">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
                    <div class="mt-1 text-xs text-gray-500">Total Pengeluaran yang dikeluarkan dan sudah di setujui panitian yang lain</div>
                </div>
                <div class="p-6 overflow-hidden transition-all bg-white shadow-sm sm:rounded-lg hover:shadow-md">
                    <div class="text-sm font-medium text-gray-600">Saldo Saat Ini</div>
                    <div class="mt-2 text-2xl font-bold {{ ($totalClassSavings - $totalExpenses) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format($totalClassSavings - $totalExpenses, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-xs text-gray-500">Saldo yang saat ini ada di rekening panitia</div>
                </div>
            </div>

            <!-- Progress Bars -->
            <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-2">
                <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Progress Target</h3>
                    <div class="mb-3 text-lg">
                        <span class="{{ $totalSavings >= 1950000 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                            Rp {{ number_format($totalSavings, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-600">/Rp 1.950.000</span>
                    </div>
                    <div class="relative pt-1">
                        <div class="flex h-4 overflow-hidden text-xs bg-indigo-100 rounded">
                            <div class="flex flex-col justify-center text-center text-white transition-all duration-500 bg-indigo-500 shadow-none whitespace-nowrap"
                                style="width: {{ $progressPercentage }}%">
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">{{ number_format($progressPercentage, 1) }}% tercapai</div>
                        @if($totalSavings >= 1950000)
                            <div class="mt-2 font-medium text-green-600">
                                Selamat! Kamu telah menyelesaikan target tabungan KKL. Terima kasih atas komitmenmu!
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Target Mingguan</h3>
                    <div class="mb-3 text-lg">
                        <span class="{{ $weeklySavings >= 10000 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                            Rp {{ number_format($weeklySavings, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-600">/Rp 10.000</span>
                    </div>
                    <div class="relative pt-1">
                        <div class="flex h-4 overflow-hidden text-xs bg-indigo-100 rounded">
                            <div class="flex flex-col justify-center text-center text-white transition-all duration-500 bg-indigo-500 shadow-none whitespace-nowrap"
                                style="width: {{ $weeklyProgressPercentage }}%">
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">{{ number_format($weeklyProgressPercentage, 1) }}% tercapai</div>
                        @if($weeklySavings >= 10000)
                            <div class="mt-2 font-medium text-green-600">
                                Hebat! Kamu telah mencapai target minggu ini. Pertahankan semangat menabungmu! 🎉
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Setoran -->
            <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-medium text-gray-800">Form Menabung</h3>
                    <form action="{{ route('savings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Menabung <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="number" min="1000" step="500" name="amount"
                                    value="{{ old('amount') }}"
                                    class="block w-full text-gray-800 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('amount') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="Minimal Rp 1.000">
                            </div>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Metode Pembayaran <span class="text-red-500">*</span></label>
                            <select name="payment_method" id="payment_method"
                                class="block w-full py-2 pl-3 pr-10 mt-1 text-gray-800 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('payment_method') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="">Pilih metode pembayaran</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="tunai" {{ old('payment_method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="proofFileInput" class="hidden">
                            <label class="block text-sm font-medium text-gray-700">Bukti Transfer <span class="text-red-500">*</span></label>
                            <input type="file" name="proof_file" accept="image/*,.pdf"
                                class="block w-full mt-1 text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('proof_file') border-red-300 text-red-900 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG, atau PDF. Maksimal 2MB</p>
                            @error('proof_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea name="notes" rows="2"
                                class="block w-full text-gray-800 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('notes') }}</textarea>
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Menabung
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Riwayat Setoran -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Riwayat Menabung</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal</th>
                                    {{-- <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Minggu Ke</th> --}}
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Metode</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($savings as $saving)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $saving->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    {{-- <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $saving->formatted_week }}
                                        @if($saving->week_number > 0)
                                            <span class="block text-xs text-gray-400">
                                                {{ Carbon\Carbon::parse($saving->week_range['start'])->format('d/m/Y') }} -
                                                {{ Carbon\Carbon::parse($saving->week_range['end'])->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </td> --}}
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        Rp {{ number_format($saving->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $saving->status === 'approved' ? 'bg-green-100 text-green-800' :
                                               ($saving->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $saving->status === 'approved' ? 'Diterima' :
                                               ($saving->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $saving->payment_method === 'transfer' ? 'Transfer' : 'Tunai' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        @if($saving->status === 'approved')
                                            <a href="{{ route('savings.receipt', $saving) }}" target="_blank"
                                                class="text-blue-700 hover:text-blue-900">Cetak Bukti</a>
                                        @elseif($saving->status === 'pending')
                                            <button x-data
                                                x-on:click="$dispatch('open-modal', 'confirm-cancel-{{$saving->id}}')"
                                                class="text-red-700 hover:text-red-900">
                                                Batalkan
                                            </button>

                                            <x-modal name="confirm-cancel-{{$saving->id}}" focusable>
                                                <div class="p-6">
                                                    <h2 class="text-lg font-medium text-white">
                                                        Konfirmasi Pembatalan
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-400">
                                                        Yakin ingin membatalkan setoran ini?
                                                    </p>

                                                    <div class="flex justify-end mt-6 space-x-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            Batal
                                                        </x-secondary-button>

                                                        <form action="{{ route('savings.cancel', $saving) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-danger-button type="submit">
                                                                Ya, Batalkan
                                                            </x-danger-button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </x-modal>
                                        @elseif($saving->status === 'rejected')
                                            <button x-data
                                                x-on:click="$dispatch('open-modal', 'confirm-delete-{{$saving->id}}')"
                                                class="text-red-700 hover:text-red-900">
                                                Hapus
                                            </button>

                                            <x-modal name="confirm-delete-{{$saving->id}}" focusable>
                                                <div class="p-6">
                                                    <h2 class="text-lg font-medium text-white">
                                                        Konfirmasi Penghapusan
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-400">
                                                        Yakin ingin menghapus setoran ini dari riwayat?
                                                    </p>

                                                    <div class="flex justify-end mt-6 space-x-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            Batal
                                                        </x-secondary-button>

                                                        <form action="{{ route('savings.delete', $saving) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-danger-button type="submit">
                                                                Ya, Hapus
                                                            </x-danger-button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </x-modal>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $savings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.getElementById('payment_method');
            const proofFileInput = document.getElementById('proofFileInput');

            function toggleProofFile() {
                proofFileInput.classList.toggle('hidden', paymentMethod.value !== 'transfer');
            }

            paymentMethod.addEventListener('change', toggleProofFile);
            toggleProofFile();

            // Show proof file input if transfer was previously selected and there was an error
            if ('{{ old('payment_method') }}' === 'transfer') {
                proofFileInput.classList.remove('hidden');
            }
        });
    </script>
    @endpush
</x-app-layout>
