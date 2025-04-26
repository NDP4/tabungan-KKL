<?php

namespace App\Events;

use App\Models\Expense;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ExpenseConfirmed implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(
        public Expense $expense
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('expenses'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->expense->id,
            'amount' => $this->expense->amount,
            'description' => $this->expense->description,
            'created_by' => $this->expense->creator->name,
            'confirmed_by' => $this->expense->confirmedByUser->name,
            'confirmed_at' => $this->expense->confirmed_at->format('Y-m-d H:i:s'),
        ];
    }
}
