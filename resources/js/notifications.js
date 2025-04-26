import "./bootstrap";

// Listen for notification sounds
window.Echo.private(`notifications.${window.userId}`).notification(
    (notification) => {
        // Play notification sound
        const audio = new Audio("/notification.mp3");
        audio.play();

        // Show toast notification
        toastr.info(notification.message);
    }
);
