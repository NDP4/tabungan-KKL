// Konfigurasi default untuk Toastr
toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

// Function untuk menampilkan notifikasi
function showNotification(type, message) {
    switch (type) {
        case "success":
            toastr.success(message);
            break;
        case "error":
            toastr.error(message);
            break;
        case "warning":
            toastr.warning(message);
            break;
        case "info":
            toastr.info(message);
            break;
        default:
            toastr.info(message);
    }
}

// Fungsi untuk menampilkan notifikasi
document.addEventListener("livewire:init", () => {
    Livewire.on("alert", (data) => {
        showNotification(data[0].type, data[0].message);
    });
});
