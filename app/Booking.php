<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    protected $fillable = ['name','email', 'phone','adults','children','price','foodrestrictions','comments','source','partner'];
    
    // Each booking belongs to calendar event
    function CalendarEvent()
    {
        return $this->belongsTo('CalendarEvent');
    }
}
