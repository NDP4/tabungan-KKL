<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Notifications\DatabaseNotification;

class NotificationComponent extends Component
{
    public $notifications;
    public $unreadCount;

    protected $listeners = ['echo-private:notifications.*,notification' => '$refresh'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        try {
            $user = Auth::user();
            if ($user) {
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
        } catch (\Exception $e) {
            Log::error('Error loading notifications', [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function markAsRead($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return;
            }

            $notification = DatabaseNotification::where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->where('id', $id)
                ->first();

            if ($notification) {
                $notification->markAsRead();
                $this->dispatch('alert', [
                    'type' => 'success',
                    'message' => 'Notifikasi telah ditandai sebagai dibaca'
                ]);
                $this->loadNotifications();
            }
        } catch (\Exception $e) {
            Log::error('Error marking notification as read', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Gagal menandai notifikasi sebagai dibaca'
            ]);
        }
    }

    public function markAllAsRead()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return;
            }

            DatabaseNotification::where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
            ]);
            $this->loadNotifications();
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read', [
                'error' => $e->getMessage()
            ]);
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Gagal menandai semua notifikasi sebagai dibaca'
            ]);
        }
    }

    public function deleteNotification($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return;
            }

            $notification = DatabaseNotification::where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->where('id', $id)
                ->first();

            if ($notification) {
                $notification->delete();
                $this->dispatch('alert', [
                    'type' => 'success',
                    'message' => 'Notifikasi telah dihapus'
                ]);
                $this->loadNotifications();
            }
        } catch (\Exception $e) {
            Log::error('Error deleting notification', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Gagal menghapus notifikasi'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.notification-component');
    }
}
