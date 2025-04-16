<?php

namespace App\Jobs;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class NotifyAdminsOfPostedProperty implements ShouldQueue
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
        try {
            $propertyDetails = Property::getPropertyByID($this->propertyID);

            if (!$propertyDetails) {
                Log::warning("Property not found for ID: {$this->propertyID}");
                return;
            }

            Mail::send(
                'mailing.admin.admins_notify',
                [
                    'property_title' => $propertyDetails->property_title,
                    'created_by_name' => $propertyDetails->created_by_name,
                    'address' => $propertyDetails->google_address,
                ],
                function ($message) use ($propertyDetails) {
                    $adminEmails = DB::table('model_has_roles')
                        ->leftJoin('users', 'model_has_roles.model_id', 'users.id')
                        ->where('role_id', 1)
                        ->whereNotNull('users.email')
                        ->pluck('users.email')
                        ->toArray();

                    $adminEmails[] = 'thejustgrouplimited@gmail.com';

                    $subject = 'POSTED: ' . $propertyDetails->property_title . ' Requires Approval';

                    $message->from('app@justhomesapp.com', 'Just Homes');
                    $message->to($adminEmails);
                    $message->subject($subject);
                }
            );

            Log::info("Admin notification email sent for property ID: {$this->propertyID}");
        } catch (\Exception $e) {
            Log::error("Failed to send admin notification for property ID {$this->propertyID}. Error: " . $e->getMessage());
        }
    }
}
