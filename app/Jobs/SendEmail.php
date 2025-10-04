<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{

    //comment here
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $resetCode;
    protected $view;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $resetCode
     * @param string $view
     */
    public function __construct($user, $resetCode, $view = 'mailing.password.forgot')
    {
        $this->user = $user;
        $this->resetCode = $resetCode;
        $this->view = $view;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Mail::send(
                $this->view,
                [
                    'resetCode' => $this->resetCode,
                    'name' => $this->user->name,
                ],
                function ($message) {
                    $message->from('app@justhomesapp.com', 'Just Homes');
                    $message->to($this->user->email)->subject("Password Reset Code");
                }
            );
        } catch (\Exception $e) {
            Log::error("Failed to send email: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
