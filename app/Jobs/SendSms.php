<?php

namespace App\Jobs;

use App\Models\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $telephone;
    protected $message;

    public function __construct($telephone, $message)
    {
        $this->telephone = $telephone;
        $this->message = $message;
    }

    public function handle()
    {
        try {
            SMS::sendSms($this->telephone, $this->message);
        } catch (\Exception $e) {
            Log::error("Failed to send SMS: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
