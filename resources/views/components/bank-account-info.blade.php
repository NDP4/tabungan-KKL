<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h2 class="font-semibold text-xl mb-4">Informasi Rekening</h2>

        <div class="space-y-4">
            <div>
                <div class="text-sm text-gray-500">Bank</div>
                <div class="font-medium">{{ $bankName }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Nomor Rekening</div>
                <div class="flex items-center gap-2">
                    <div class="font-medium" id="account-number">{{ $accountNumber }}</div>
                    <button onclick="copyToClipboard('account-number')" class="text-sm text-indigo-600 hover:text-indigo-800">
                        Copy
                    </button>
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Atas Nama</div>
                <div class="font-medium">{{ $accountHolder }}</div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    const text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Nomor rekening berhasil disalin!');
    });
}
</script>
