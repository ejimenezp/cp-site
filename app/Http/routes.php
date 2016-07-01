<?php

/*
 * |--------------------------------------------------------------------------
 * | Routes File
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you will register all of the routes in an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */

//
// Cooking Point
//

// Activities
Route::get('/', function () { return view('pages.home', ['page' => 'home']); });
Route::get('classes', function () { return view('pages.classes'); });
Route::get('private-cooking-events-madrid-spain', function () { return view('pages.events'); });

// ADMIN main page
// Route::get('admin/calendar', 'CalendarEventsController@show_today'); // OK
// Route::get('admin/calendar/{date}', 'CalendarEventsController@show_week'); // OK

// CRUD for calendar events
// create/edit forms
// Route::get('admin/calendarevent/{date}/{shift}/create', 'CalendarEventsController@create'); // OK
// Route::get('admin/calendarevent/{date}/create', 'CalendarEventsController@create'); // OK
// // retrieve
// Route::get('admin/calendarevent/{date}/{ce_id}/details', 'CalendarEventsController@show');
// Route::get('admin/calendarevent/{date}/{ce_id}/edit', 'CalendarEventsController@create');
// // store, update & delete
// Route::post('admin/calendarevent/{date}', 'CalendarEventsController@store');  // OK
// Route::patch('admin/calendarevent/{date}/{ce_id}/edit', 'CalendarEventsController@edit');
// Route::delete('admin/calendarevent/{date}/{ce_id}', 'CalendarEventsController@delete'); // OK

// CRUD for activities
Route::get('admin/activity/', 'ActivitiesController@index');
Route::get('admin/activity/new', 'ActivitiesController@show');
Route::get('admin/activity/{id}', 'ActivitiesController@show');

Route::get('admin/json/activity/{id}', 'JsonActivitiesController@get');
Route::post('admin/json/activity', 'JsonActivitiesController@store');
Route::patch('admin/json/activity/{id}', 'JsonActivitiesController@update');
Route::delete('admin/json/activity/{id}', 'JsonActivitiesController@delete');

// CRUD for ce
Route::get('admin/calendar', 'CalendarEventsController@index');
Route::get('admin/calendar/{date}', 'CalendarEventsController@index');
Route::get('admin/calendarevent/new/{date}/{shift}', 'CalendarEventsController@show_new');
Route::get('admin/calendarevent/details/{date}/{id}', 'CalendarEventsController@show_details');
Route::get('admin/calendarevent/{date}/{id}', 'CalendarEventsController@index');

Route::get('admin/json/calendarevent/{id}', 'JsonCalendarEventsController@get');
Route::post('admin/json/calendareventou', 'JsonCalendarEventsController@store');
Route::patch('admin/json/calendarevent/{id}', 'JsonCalendarEventsController@update');
Route::delete('admin/json/calendarevent/{id}', 'JsonCalendarEventsController@delete');


//
// TIENDA
//
Route::get('tienda', 'TicketsController@front');
Route::get('tienda/tickets', 'TicketsController@index');
Route::post('tienda/addticket', 'TicketsController@addticket');
Route::get('tienda/voidticket/{id}', 'TicketsController@voidticket');

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | This route group applies the "web" middleware group to every route
 * | it contains. The "web" middleware group is defined in your HTTP
 * | kernel and includes session state, CSRF protection, and more.
 * |
 */

Route::group([
    'middleware' => [
        'web'
    ]
], function () {
    //
});
