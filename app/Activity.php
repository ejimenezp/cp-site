<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['type','shortcode','start_time','end_time','shift','visible','price_adult','price_child','max_size'];

    public function calendar_events()
    {
        return $this->hasMany('App\CalendarEvent');
    }
    
    public static function get_compatible($shift)
    {
    	if ($shift == "any")
    	{
			return Activity::all();

    	} else {
			return Activity::where('shift', $shift)->orWhere('shift', 'any')->get();
    	}
    }
}
