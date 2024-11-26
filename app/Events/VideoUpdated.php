<?php

namespace App\Events;

use App\Models\ReelVideo; // Assuming ReelVideo is your model for videos
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $video;
    public $likes;
    public $shares;

    public function __construct(ReelVideo $video)
    {
        $this->video = $video;
        $this->likes = $video->likes;
        $this->shares = $video->shares;
    }

    public function broadcastOn()
    {
        return new Channel('video.' . $this->video->id); // Channel for a specific video
    }

    public function broadcastAs()
    {
        return 'video.updated'; // Event name
    }
}
