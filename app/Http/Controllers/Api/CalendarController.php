<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Property;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

class CalendarController extends Controller
{
    public function submit(Request $request)
    {
        $date = $request['date'];
        $time = $request['time'];

        // Combine date and time into a single string
        $datetime_str = $date . ' ' . $time;

        // Create a DateTime object from the string using the correct format
        $start_datetime = DateTime::createFromFormat('Y-m-d h:i A', $datetime_str);

        // Check if the DateTime object was created successfully
        if (!$start_datetime) {
            return response()->json([
                "success" => false,
                "message" => 'Invalid date format',
            ]);
        }

        // Format the start date time for MySQL
        $start_date_time = $start_datetime->format('Y-m-d H:i:s');

        // Clone the DateTime object to add 30 minutes
        $end_datetime = clone $start_datetime;
        $end_datetime->modify('+30 minutes');

        // Format the end date time for MySQL
        $end_date_time = $end_datetime->format('Y-m-d H:i:s');

        Calendar::insert([
            'date_time_start' => $start_date_time,
            'date_time_end' => $end_date_time,
            'property_id' => $request['propertyID'],
            'name' => $request['name'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'status' => 1,
            'user_id' => Property::where('id', $request['propertyID'])->first()->created_by,
            'created_by' => $request['user_id'],
            'updated_by' => $request['user_id'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);


        $propertyDetails = Property::getPropertyByID($request['propertyID']);

        $email = $propertyDetails->email;
        if (stripos($email, '@gmail.com') !== false) {
            $calendarLink = Calendar::createGoogleCalendarLink(
                "Appointment For :" . $propertyDetails->property_title . "with " . $request['name'],
                'Appointment with ' . $request['name'],
                $propertyDetails->address . ", " . $propertyDetails->sub_region_name . ", " . $propertyDetails->town_name,
                $request['date'] . ' ' . $request['time'],
                date("Y-m-d H:i:s", strtotime("+30 minutes", strtotime($request['date'] . ' ' . $request['time'])))
            );
        } else {

            $calendarLink = route('download-calendar-event', [
                'title' => "Appointment For :" . $propertyDetails->property_title . "with " . $request['name'],
                'description' => 'Appointment with ' . $request['name'],
                'startTime' => $request['date'] . ' ' . $request['time'],
                'endTime' => date("Y-m-d H:i:s", strtotime("+30 minutes", strtotime($request['date'] . ' ' . $request['time']))),
                'location' => $propertyDetails->address . ", " . $propertyDetails->sub_region_name . ", " . $propertyDetails->town_name,
            ]);
        }


        Mail::send(
            'mailing.calendar.notification',
            [
                'property_name' => $propertyDetails->property_title,
                'client_name' => $request['name'],
                'email' => $request['email'],
                'telephone' => $request['telephone'],
                'date' => $request['date'],
                'time' => $request['time'],
                'created_by_name' => $propertyDetails->created_by_name,
                'calendar_link' => $calendarLink,
            ],
            function ($message) use ($request, $propertyDetails) {
                $message->from('noreply@justhomes.co.ke');
                $message->to($propertyDetails->email)->subject("New Appointment Notification for: " . $request['name'] . " - Just Homes.");
            }
        );



        $email = $request['email'];
        if (stripos($email, '@gmail.com') !== false) {
            $calendarLink = Calendar::createGoogleCalendarLink(
                "Appointment For: " . $propertyDetails->property_title . "with " . $propertyDetails->created_by_name,
                'Appointment with ' . $propertyDetails->created_by_name,
                $propertyDetails->address . ", " . $propertyDetails->sub_region_name . ", " . $propertyDetails->town_name,
                $request['date'] . ' ' . $request['time'],
                date("Y-m-d H:i:s", strtotime("+30 minutes", strtotime($request['date'] . ' ' . $request['time'])))
            );
        } else {

            $calendarLink = route('download-calendar-event', [
                'title' => "Appointment For: " . $propertyDetails->property_title . "with " . $propertyDetails->created_by_name,
                'description' => 'Appointment with ' . $propertyDetails->created_by_name,
                'startTime' => $request['date'] . ' ' . $request['time'],
                'endTime' => date("Y-m-d H:i:s", strtotime("+30 minutes", strtotime($request['date'] . ' ' . $request['time']))),
                'location' => $propertyDetails->address . ", " . $propertyDetails->sub_region_name . ", " . $propertyDetails->town_name,
            ]);
        }


        Mail::send(
            'mailing.calendar.notification_client',
            [
                'property_name' => $propertyDetails->property_title,
                'client_name' => $request['name'],
                'email' => $request['email'],
                'telephone' => $request['telephone'],
                'date' => $request['date'],
                'time' => $request['time'],
                'created_by_name' => $propertyDetails->created_by_name,
                'calendar_link' => $calendarLink,
            ],
            function ($message) use ($request, $propertyDetails) {
                $message->from('noreply@justhomes.co.ke');
                $message->to($request['email'])->subject("Your Appointment Notification with: " . $propertyDetails->created_by_name . " - " . $propertyDetails->property_title . " - Just Homes.");
            }
        );

        return response()->json([
            "success" => true,
            "message" => 'Tour scheduled successfully',
        ]);
    }


    public function checkDate(Request $request)
    {

        $date = $request['date'];
        $propertyID = $request['propertyID'];

        $userID = Property::where('id', $propertyID)->first()->created_by;

        $dateObj = Carbon::createFromFormat('Y-m-d', $date);
        $startTime = Carbon::createFromTime(8, 0, 0, $dateObj->timezone)->setDate($dateObj->year, $dateObj->month, $dateObj->day);
        $endTime = Carbon::createFromTime(18, 0, 0, $dateObj->timezone)->setDate($dateObj->year, $dateObj->month, $dateObj->day);

        $existingSlots = Calendar::whereDate('date_time_start', $dateObj->toDateString())
            ->orWhereDate('date_time_end', $dateObj->toDateString())
            ->where('user_id', $userID)
            ->get(['date_time_start', 'date_time_end'])
            ->map(function ($slot) {
                return [
                    'start' => Carbon::parse($slot->date_time_start),
                    'end' => Carbon::parse($slot->date_time_end)
                ];
            });

        // Initialize the array to store available time slots
        $availableSlots = [];

        // Loop through the time range in 30-minute intervals
        while ($startTime->lessThan($endTime)) {
            $slotEndTime = $startTime->copy()->addMinutes(30);

            // Check if the current slot is in the existingSlots
            $isAvailable = true;
            foreach ($existingSlots as $slot) {
                if (($startTime->between($slot['start'], $slot['end'])) ||
                    ($slotEndTime->between($slot['start'], $slot['end']))
                ) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                // $availableSlots[] = $startTime->format('h:i A') . ' - ' . $slotEndTime->format('h:i A'); // Format time with AM/PM
                $availableSlots[] = $startTime->format('h:i A');
            }
            $startTime->addMinutes(30);
        }


        return response()->json([
            "success" => true,
            "data" => [
                "slots" => $availableSlots,
            ],
        ]);
    }

    public function calendar(Request $request)
    {

        $dates = Calendar::selectRaw("DATE(date_time_start) as date, CONCAT(COUNT(*), ' meetings') as title")
            ->where('user_id', Auth::user()->id)
            ->groupBy('date')
            ->get()
            ->toArray();

        return Inertia::render('Dashboard/Calendar', [
            'calendarEvents' => $dates,
            'userID' => Auth::user()->id,
        ]);
    }

    public function getEvents(Request $request)
    {

        $userID = $request['user_id']; //2024-07-07
        $events = Calendar::getUserEvents($userID);
        return response()->json([
            "success" => true,
            "data" => [
                'events' => $events
            ],
        ]);
    }


    public function cancelEvent(Request $request)
    {
        Calendar::where('id', $request['calendar_id'])->update([
            'status' => 2,
        ]);

        return response()->json([
            "success" => true,
            "data" => [
                'calendar' =>  Calendar::where('id', $request['calendar_id'])->first()
            ],
        ]);
    }
}
