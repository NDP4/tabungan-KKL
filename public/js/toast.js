// Konfigurasi default untuk Toastr
toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

// Fungsi untuk menampilkan notifikasi sukses
function showSuccess(message) {
    toastr.success(message, "Berhasil!");
}

// Fungsi untuk menampilkan notifikasi error
function showError(message) {
    toastr.error(message, "Error!");
}

// Fungsi untuk menampilkan notifikasi warning
function showWarning(message) {
    toastr.warning(message, "Perhatian!");
}

// Fungsi untuk menampilkan notifikasi info
function showInfo(message) {
    toastr.info(message, "Informasi");
}
