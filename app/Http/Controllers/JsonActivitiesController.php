<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Activity;
use \DateTime;

class JsonActivitiesController extends Controller
{

    public function get($id)
    {
            return Activity::find($id);
    }

    public function store(Request $request)
    {
            return "stored!";
    }

    public function update(Request $request)
    {
            return "updated $request->activity_id";
    }

    public function delete($id)
    {
            return "deleted $id";
    }
}
