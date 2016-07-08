<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\CalendarMgr;
use App\CalendarEvent;
use App\Activity;
use \DateTime;
use \DateInterval;


class CalendarEventsController extends Controller
{

    // // entry point
    // public function show_today()
    // {
    //     return redirect()->action('CalendarEventsController@index', date('Y-m-d'));
    // }    

    
    // // show week only
    // public function show_week ($date)
    // {        
    //     $datetime = new DateTime($date);
        
    //     $datetime_week_start = clone $datetime;
    //     $datetime_week_start->sub(new DateInterval("P".strval (($datetime->format("w") + 6) % 7)."D"));
        
    //     $datetime_week_end = clone $datetime;
    //     $datetime_week_end->add(new DateInterval("P".strval ((7 - ($datetime->format("w")))% 7 )."D"));
        
    //     $cal_slots = CalendarMgr::get_interval_slots($datetime_week_start->format("Y-m-d"), $datetime_week_end->format("Y-m-d"));
    //     return view('calendar.show')->with('slots', $cal_slots)->with('datetime', $datetime);
    // }
    

    // returns week events and one event
    public function index ($date = 0, $id = 0)
    {       

        if ($date == 0) {
            $date = date('Y-m-d');
        }
        $datetime = new DateTime($date);
        
        $datetime_week_start = clone $datetime;
        $datetime_week_start->sub(new DateInterval("P".strval (($datetime->format("w") + 6) % 7)."D"));
        
        $datetime_week_end = clone $datetime;
        $datetime_week_end->add(new DateInterval("P".strval ((7 - ($datetime->format("w")))% 7 )."D"));
        
        $cal_slots = CalendarMgr::get_interval_slots($datetime_week_start->format("Y-m-d"), $datetime_week_end->format("Y-m-d"));
        
        $event_to_show = CalendarEvent::find($id);
        
        return view('calendarevent.index')->with('slots', $cal_slots)->with('datetime', $datetime)->with('event_to_show', $event_to_show);
    }
    

    public function show_new($date, $shift)
    {
        return $this->show($date, $shift, 0);
    }


    public function show_details($date, $id)
    {
        return $this->show($date, 'am', $id);
    }

    public function show($date, $shift, $id)
    {
        $calendarevent = ($id ? CalendarEvent::find($id) : null) ;
        
        if ($date == 0) {
            $datetime = new DateTime(date('Y-m-d'));
        } else {
            $datetime = new Datetime($date);
        }

        $compatible_activities = Activity::get_compatible($shift);

        return view('calendarevent.show')->with('activities', $compatible_activities)->with('calendarevent', $calendarevent)->with('datetime', $datetime)->with('shift', $shift)->with('id',$id);
    }
    
    // CRUD, show form to create a new event 
    public function create($date, $shift)
    {
        $datetime = new DateTime($date);

    }
    
    // CRUD, store new calendar event 
    public function store(Request $request)
    {
        
        $event = new CalendarEvent;
        $act = Activity::find($request->activity_id);
        
        $event->start_date = $request->start_date;
        $event->start_shift = $request->start_shift;
        $event->end_date = $request->end_date;
        $event->end_shift = $request->end_shift;
        $event->activity_id = $request->activity_id;
        $event->details = $request->details;
        $event->status = $request->status;
        // start & end times set to default at creation
        $event->end_time = $act->end_time;
        $event->start_time = $act->start_time;
        
        $event->save();
        
        return redirect()->action('CalendarEventsController@show_event_short', [$event->start_date, $event->id]);

    }
    
    // CRUD, store new calendar event
    public function delete($date, $ce_id)
    {
        echo "hola";
        CalendarEvent::destroy($ce_id);
        return redirect()->action('CalendarEventsController@show_week', $date);
        
        
    }
    
    
    protected function get_list(DateTime $start, DateTime $end)
    {
        $interval_start = $start->format("Y-m-d");
        $interval_end = $end->format("Y-m-d");
        $cal_events = CalendarEvent::where('start_date', '>=', $interval_start)->where('start_date', '<=', $interval_end)
            ->orWhere('end_date', '>=', $interval_start)->where('end_date', '<=', $interval_end)
            ->orWhere('start_date', '<', $interval_start)->where('end_date', '>', $interval_end)->get();
        return $cal_events;
    }   

//     public function create_cooking_class(Request $request)
//     {
        
//         $av = CalendarMgr::availability($request->date, $request->date, $request->activity_id, 0);
        
//         if (empty($av)) {
//             return null; // not time available
//         } elseif (array_pop($av)->event_id == 0) {  // slot available
//             $activity = Activity::find($request->activity_id);
//             $event = new CalendarEvent();
//             $event->start_date = $request->date;
//             $event->end_date = $request->date;
//             $event->activity_id = $request->activity_id;
//             $event->status = $request->status;
//             $event->occupancy = 0;
            
//             $event->start_time = $activity->start_time;
//             $event->start_shift = $activity->shift;
//             $event->end_time = $activity->end_time;
//             $event->end_shift = $activity->shift;
            
//             $event->save();
//             return \Redirect::to('calendarevent/');
//         } else {  // event already created
//             return \Redirect::to('calendarevent/');
//         }
//     }
}
