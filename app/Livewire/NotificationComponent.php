<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class NotificationComponent extends Component
{
    use Notifiable;

    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = [
        'echo-private:notifications.*,notification' => '$refresh',
        'refreshNotifications' => 'loadNotifications'
    ];

    public function getListeners()
    {
        return [
            "echo-private:notifications.{$this->getUserId()},notification" => '$refresh'
        ];
    }

    public function mount()
    {
        $this->loadNotifications();
    }

    // public function loadNotifications()
    // {
    //     $user = Auth::user();
    //     if ($user) {
    //         $this->notifications = $user->notifications()->latest()->take(10)->get();
    //         $this->unreadCount = $user->unreadNotifications->count();
    //     }
    // }

    public function loadNotifications()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $this->notifications = $user->notifications()->latest()->take(10)->get();
            $this->unreadCount = $user->unreadNotifications->count();
        }
    }

    public function markAsRead($notificationId)
    {
        /** @var \App\Models\User $user */
        // $user = Auth::user();

        $user = Auth::user();
        if ($user) {
            $notification = $user->notifications()->findOrFail($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $this->dispatch('alert', [
                    'type' => 'success',
                    'message' => 'Notification marked as read'
                ]);
                $this->loadNotifications();
            }
        }
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'All notifications marked as read'
            ]);
            $this->loadNotifications();
        }
    }

    protected function getUserId()
    {
        return Auth::id();
    }

    public function render()
    {
        return view('livewire.notification-component');
    }
}
