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

class CalendarController extends Controller
{
    public function submit(Request $request)
    {

        $date = $request['date'];
        $time = $request['time'];

        // Combine date and time into a single string
        $datetime_str = $date . ' ' . $time;

        // Create a DateTime object from the string
        $start_datetime = DateTime::createFromFormat('d-m-Y h:i A', $datetime_str);

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
            'property_id' => $request['propertyId'],
            'name' => $request['fullNames'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'status' => 1,
            'user_id' => $request['userId'],
            // 'created_by' => Auth::user()->id,
            // 'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
        return response()->json([
            "success" => true,
            "message" => 'here',
        ]);
    }

    public function checkDate(Request $request)
    {

        $date = $request['date']; // Expecting '19/09/2024' or similar
        $propertyID = $request['propertyID'];

        // Fetch the userID associated with the property
        $userID = Property::where('id', $propertyID)->first()->created_by;

        // Convert date format if necessary
        $formattedDate = str_replace('/', '-', $date);

        // Create a Carbon instance from the formatted date string
        $dateObj = Carbon::createFromFormat('d-m-Y', $formattedDate);

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

        $date = $request['date']; //2024-07-07

        $events = Calendar::leftJoin('properties', 'calendars.property_id', 'properties.id')
            ->where('user_id', Auth::user()->id)
            ->whereDate('date_time_start', '=', $date)
            ->get();

        return response()->json([
            'events' => count($events) > 0 ? $events : [],
            "success" => true,
            "userID" => $request['userID'],
            "date" => $request['date'],
        ]);
    }
}
