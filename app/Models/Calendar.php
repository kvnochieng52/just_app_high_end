<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;


    public static function getUserEvents($userID)
    {
        $events = self::join('properties', 'calendars.property_id', '=', 'properties.id')
            ->select(
                'calendars.date_time_start',
                'calendars.date_time_end',
                'calendars.name',
                'calendars.email',
                'calendars.telephone',
                'properties.property_name'
            )
            ->where('calendars.user_id', $userID)
            ->where('calendars.status', 1) // Assuming you only want events with status = 1
            ->get();

        // Initialize an empty array to hold the structured events
        $structuredEvents = [];

        // Loop through the events and structure them
        foreach ($events as $event) {
            // Parse the start and end times
            $start = Carbon::parse($event->date_time_start);
            $end = Carbon::parse($event->date_time_end);

            // Format the date
            $date = $start->toDateString();

            // Format the time
            $startTime = $start->format('h:i A');
            $endTime = $end->format('h:i A');

            // Create the event
            $eventData = [
                'name' => $event->name,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'telephone' => $event->telephone,
                'email' => $event->email,
                'property_name' => $event->property_name,
            ];

            // Add the event to the structured events array
            if (!isset($structuredEvents[$date])) {
                $structuredEvents[$date] = [];
            }
            $structuredEvents[$date][] = $eventData;
        }

        return $structuredEvents;
    }
}
