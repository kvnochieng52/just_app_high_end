<?php

namespace App\Jobs;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendUserPropertyApprovalNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $propertyId;
    protected $comment;
    protected $action;

    /**
     * Create a new job instance.
     */
    public function __construct($propertyId, $comment, $action)
    {
        $this->propertyId = $propertyId;
        $this->comment = $comment;
        $this->action = $action;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $propertyDetails = Property::getPropertyByID($this->propertyId);

        if (!$propertyDetails) {
            return; // Optional: handle the case where property is not found
        }

        Mail::send(
            'mailing.admin.approve_notify',
            [
                'property_title' => $propertyDetails->property_title,
                'created_by_name' => $propertyDetails->created_by_name,
                'comment' => $this->comment,
                'action' => $this->action,
            ],
            function ($message) use ($propertyDetails) {
                $subject = ($this->action == 'approve' ? 'APPROVED' : 'DECLINED') . ": {$propertyDetails->property_title}";

                $message->from('app@justhomesapp.com', 'Just Homes');
                $message->to($propertyDetails->email);
                $message->subject($subject);
            }
        );
    }
}
