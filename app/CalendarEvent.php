<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use \DateTime;

class CalendarEvent extends Model
{
    protected $fillable = ['start_date','start_time'];
    
    // Each calendar event has a base activity
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }
    
    // Each calendar event has 0..* bookings
    // 0 in case of holidays, blocked,...
    // 1..1 in case of group events
    // 0..n in case of regular clases
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
        
    // returns its duration in timeslots (1 day = 2 timeslots, am & pm)
    public function duration()
    {
        $tsStart = CalendarEvent::ts_timestamp($this->start_date, $this->start_shift);
        $tsEnd = self::ts_timestamp($this->end_date, $this->end_shift);
        return $tsEnd - $tsStart + 1;
    }
    
    // timestamp in timeslosts, not in days
    static function ts_timestamp($d, $shift)
    {
        $date = new DateTime($d);
        return $date->getTimestamp()/24/3600 * 2 + ($shift == "am" ? 0 : 1);
    }
}
