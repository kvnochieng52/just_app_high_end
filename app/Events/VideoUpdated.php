<?php

namespace App\Events;

use App\Models\ReelVideo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $video;

    public function __construct(ReelVideo $video)
    {
        $this->video = $video;
    }

    public function broadcastOn()
    {
        // Ensure the correct channel is being broadcasted
        return new Channel('video.' . $this->video->id);
    }

    public function broadcastAs()
    {
        return 'video.updated'; // Event name
    }
}
