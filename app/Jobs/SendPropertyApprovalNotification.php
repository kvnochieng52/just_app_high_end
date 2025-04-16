<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Property;
use Illuminate\Support\Facades\Log;


class SendPropertyApprovalNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $propertyID;

    /**
     * Create a new job instance.
     */
    public function __construct($propertyID)
    {
        $this->propertyID = $propertyID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $propertDetails = Property::getPropertyByID($this->propertyID);

        if (!$propertDetails) {
            Log::error("Property not found for ID: " . $this->propertyID);
            return;
        }

        try {
            Mail::send(
                'mailing.admin.admins_notify',
                [
                    'property_title' => $propertDetails->property_title,
                    'created_by_name' => $propertDetails->created_by_name,
                    'address' => $propertDetails->google_address,
                ],
                function ($message) use ($propertDetails) {
                    $adminEmails = DB::table('model_has_roles')
                        ->leftJoin('users', 'model_has_roles.model_id', 'users.id')
                        ->where('role_id', 1)
                        ->whereNotNull('users.email')
                        ->pluck('users.email')
                        ->toArray();

                    $adminEmails[] = 'thejustgrouplimited@gmail.com';

                    $subject = 'POSTED: ' . $propertDetails->property_title . ' Requires Approval';

                    $message->from('app@justhomesapp.com', 'Just Homes');
                    $message->to($adminEmails);
                    $message->subject($subject);
                }
            );
        } catch (\Exception $e) {
            Log::error('Failed to send property approval notification: ' . $e->getMessage());
        }
    }
}
