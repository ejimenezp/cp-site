<?php
namespace App\Http\Controllers;

Use App\Activity;
use \DateTime;

class ActivitiesController extends Controller
{
    // return all activities
    public function index()
    {
        $list = Activity::all()->sortBy('shortcode');
        // return $list;
        $today = new DateTime(date('Y-m-d'));
        return view('activity.index')->with('activities', $list)->with('datetime', $today);
    }

    public function show($id = 0)
    {
            $activity = ($id ? Activity::find($id) : null) ;

        $today = new DateTime(date('Y-m-d'));
        return view('activity.show')->with('id', $id)->with('activity', $activity)->with('datetime', $today);
    }


}
