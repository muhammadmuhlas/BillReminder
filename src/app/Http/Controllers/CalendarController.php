<?php

namespace App\Http\Controllers;

use Askedio\Laravel5GoogleCalendar\Calendar;
use Auth;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a calendar, redirect home.
     *
     * @return redirect
     */
    public function store(Request $request)
    {
        $_calendar = $request->input('calendar') ?: 'Bill Reminders';
        $_id = false;

        Calendar::setVar('calendar', '');
        $_calendars = Calendar::readCalendar();
        if ($_calendars->items) {
            $_found = false;
            foreach ($_calendars->items as $_cal) {
                if ($_cal->summary == $_calendar) {
                    $_id = $_cal->id;
                    break;
                }
            }
        }

        if (!$_id) {
            Calendar::setVar('calendar', 'create');
            $_results = Calendar::createCalendar([
          'summary'         => $request->input('calendar') ?: 'Bill Reminders',
          'description'     => 'Created by BillReminder',
        ]);
        /* TO-DO: Needs proper checks. */
        $_id = $_results->id;
        }

        if ($_id) {
            Auth::user()->calendar = $_id;
            Auth::user()->save();
        } else {
            die('shoot');
        }

        return redirect('home');
    }
}
