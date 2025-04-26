<?php

namespace App\Events;

use App\Models\Saving;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SavingStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(
        public Saving $saving
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('savings'),
            new Channel('savings.' . $this->saving->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->saving->id,
            'status' => $this->saving->status,
            'amount' => $this->saving->amount,
            'student_name' => $this->saving->user->name,
            'updated_at' => $this->saving->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
