<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationComponent extends Component
{
    public $notifications;
    public $unreadCount = 0;

    protected $listeners = [
        'echo:private-App.Models.User.*,Illuminate\\Notifications\\Events\\BroadcastNotificationCreated' => 'refreshNotifications',
        'markAsRead',
        'markAllAsRead'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        if ($user instanceof User) {
            $this->notifications = DatabaseNotification::where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->latest()
                ->take(10)
                ->get();

            $this->unreadCount = DatabaseNotification::where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')
                ->count();
        }
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        if ($user instanceof User) {
            DatabaseNotification::where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->where('id', $notificationId)
                ->update(['read_at' => now()]);

            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        if ($user instanceof User) {
            DatabaseNotification::where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            $this->loadNotifications();
        }
    }

    public function refreshNotifications()
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-component');
    }
}
