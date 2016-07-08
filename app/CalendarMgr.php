<?php

namespace App;

use DB;
use DateTime;
use App\Booking;
use App\Activity;
use App\CalendarEvent;

class CalendarMgr
{
//     private $location = 'Moratin 11';

    
    public static function get_interval_slots($intervalStart, $intervalEnd)    
    {
        // returns an array indexed with all timeslots comprised in an interval
        // if the slot is empty, its content is 0
        // if the slot is within an event, it contains an array of calendarevents
        // $is == array of interval slots
        $is = array();
        $aDate = new DateTime();  // temp variable to hold dates
        $first_timeslot = CalendarEvent::ts_timestamp($intervalStart,'am'); // interval boundaries
        $last_timeslot = CalendarEvent::ts_timestamp($intervalEnd, 'pm'); // interval boundaries
        
        // create an array of timeslots with interval length, with all timeslots empty
        for ($i = $first_timeslot; $i <= $last_timeslot; $i++) {
            $aDate->setTimestamp($i*24*3600/2);
            $is[$i][0] = new CalendarEvent();
            $is[$i][0]->date = $aDate->format("Y-m-d");
            $is[$i][0]->shift = ($i % 2 ? "pm" : "am");
            $is[$i][0]->event_id = 0;
        }
        
        // get all events taking place within the interval
        $cal_events = CalendarEvent::with('activity')
        ->where('start_date', '>=', $intervalStart)->where('start_date', '<=', $intervalEnd)
        ->orWhere('end_date', '>=', $intervalStart)->where('end_date', '<=', $intervalEnd)
        ->orWhere('start_date', '<', $intervalStart)->where('end_date', '>', $intervalEnd)->get();
        
        // fill the array with calendar events from DB
        foreach ($cal_events as $event) {
            // get event timeslots. We only require those intersecting with our interval
            $this_event_first_timeslot = CalendarEvent::ts_timestamp($event->start_date, $event->start_shift);
            $this_event_last_timeslot = CalendarEvent::ts_timestamp($event->end_date, $event->end_shift);
        
            for ($i = $this_event_first_timeslot; $i <= $this_event_last_timeslot; $i++) {
                // only timeslots within our interval
                // there could be more than one event on a timeslot, we need a multidimension array
                if ($first_timeslot <= $i && $i <= $last_timeslot) {
                    $aDate->setTimestamp($i*24*3600/2);
//                     unset($is[$i][0]);
                    
                    $is[$i][$event->id] = clone $event;                    
//                     $is[$i][$event->id] = new CalendarEvent();                    
//                     $is[$i][$event->id]->date = $aDate->format("Y-m-d");
//                     $is[$i][$event->id]->shift = ($i % 2 ? "pm" : "am");
//                     $is[$i][$event->id]->event_id = $event->id;
//                     $is[$i][$event->id]->activity_id = $event->activity_id;
//                     $is[$i][$event->id]->status = $event->status;
//                     $is[$i][$event->id]->occupancy = $event->occupancy;
                }
            }
        }
        return $is;
        
        
    }
    
    
//     public static function availability($intervalStart, $intervalEnd, $requested_activity_id, $requested_people)
//     {
//         $av = $this->get_interval_slots($intervalStart, $intervalEnd);
        
//         // remove timeslots not valid for requested activity
//         $requested_activity_shift = Activity::find($requested_activity_id)->shift;
        
//         for ($i = $first_timeslot; $i <= $last_timeslot; $i++) {
//             if ($av[$i]->shift != $requested_activity_shift) {
//                 unset ($av[$i]);
//             }
//         }      
        
//         // remove timeslots with other events already confirmed
//         foreach ($av as $key => $event) {
//             if ($event->activity_id != $requested_activity_id && $event->status == 'CONFIRMED') {
//                 unset ($av[$key]);
//             }
//         }
       
//         // remove timeslots with same activities but not enough space
//         foreach ($av as $key => $event) {
//             if ($event->activity_id == $requested_activity_id) {
//                 if ($requested_people + $event->occupancy > $event->activity->max_size) {
//                     unset ($av[$key]);
//                 }
//             }
//         }
//         return $av;
        
//     }
    

 }
