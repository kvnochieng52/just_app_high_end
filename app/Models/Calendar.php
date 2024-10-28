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
                'calendars.id',
                'calendars.date_time_start',
                'calendars.date_time_end',
                'calendars.name',
                'calendars.email',
                'calendars.telephone',
                'properties.property_title'
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
                'property_name' => $event->property_title,
                'calendar_id' => $event->id
            ];

            // Add the event to the structured events array
            if (!isset($structuredEvents[$date])) {
                $structuredEvents[$date] = [];
            }
            $structuredEvents[$date][] = $eventData;
        }

        return $structuredEvents;
    }


    public static function  generateICS($title, $startTime, $endTime, $description, $location)
    {
        return "BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
SUMMARY:$title
DESCRIPTION:$description
DTSTART:" . date("Ymd\THis", strtotime($startTime)) . "
DTEND:" . date("Ymd\THis", strtotime($endTime)) . "
LOCATION:$location
END:VEVENT
END:VCALENDAR";
    }


    public static function isGmail($email)
    {
        return stripos($email, '@gmail.com') !== false;
    }

    // Helper function to create a Google Calendar link
    public static function createGoogleCalendarLink($title, $description, $location, $startTime, $endTime)
    {
        return "https://www.google.com/calendar/render?action=TEMPLATE" .
            "&text=" . urlencode($title) .
            "&details=" . urlencode($description) .
            "&location=" . urlencode($location) .
            "&dates=" . gmdate("Ymd\THis\Z", strtotime($startTime)) .
            "/" . gmdate("Ymd\THis\Z", strtotime($endTime));
    }
}
