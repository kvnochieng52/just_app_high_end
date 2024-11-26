<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeOrShareUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;
    public $itemId;

    public function __construct($status, $itemId)
    {
        $this->status = $status;
        $this->itemId = $itemId;
    }

    public function broadcastOn()
    {
        return new Channel('item.' . $this->itemId); // Broadcasting to a specific item channel
    }

    public function broadcastAs()
    {
        return 'like_or_share.updated';
    }
}
