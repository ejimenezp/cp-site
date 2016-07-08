<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\CalendarEvent;


class JsonCalendarEventsController extends Controller
{

    public function get($id)
    {
            return CalendarEvent::find($id);
    }

    public function store(Request $request)
    {
            return "stored!";
    }

    public function update(Request $request)
    {
            return "updated $request->id";
    }

    public function delete($id)
    {
            return "deleted $id";
    }
}
