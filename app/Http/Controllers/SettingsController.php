<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Settings;
use App\Models\SessionTime;
//use App\Models\IntervalTime;
use App\Http\Requests\TimeSettingsRegistrationRequest;
use DateTime;

class SettingsController extends Controller
{
    /**
     * Return view for timetable settings
     */
    public function settings()
    {
        $noOfDays       = 0;
        $noOfSession    = 0;
        $noOfInterval   = 0;
        $settings       = Settings::first();

        if(!empty($settings) && !empty($settings->id)) {
            $noOfDays       = $settings->working_days_in_week;
            $noOfSession    = $settings->session_per_day;
            $noOfInterval   = $settings->no_of_intervals_per_day;
        }
        return view('timetable.settings', [
                'noOfDays'      => $noOfDays,
                'noOfSession'   => $noOfSession,
                'noOfInterval'  => $noOfInterval
            ]);
    }

    /**
     * Return view for timetable settings
     */
    public function settingsAction(Request $request)
    {
        $sessionArray   = [];
        $noOfDays       = $request->get('no_of_days');
        $noOfSession    = $request->get('no_of_session');
        //$noOfInterval   = $request->get('no_of_intervals_per_day');

        $day        = [1 => 'Monday', 2 => 'Tuesday', 3=> 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
        $session    = [1 => 'Mo', 2 => 'Tu', 3 => 'We', 4 => 'Th', 5 => 'Fr', 6 => 'Sa'];

        for ($i=1; $i <= $noOfDays; $i++) { 
            for ($j=1; $j <= $noOfSession; $j++) { 
                $sessionArray[] = [
                    'day_index'     => $i,
                    'session_index' => $j,
                    'day_name'      => $day[$i],
                    'session_name'  => ($session[$i]. " - ". $j),
                    'time_from'     => '09:30:00',
                    'time_to'       => '16:00:00',
                    'status'        => 1
                ];
            }
        }

        //delete all existing records
        Session::truncate();
        Settings::truncate();

        $settings = new Settings;
        $settings->working_days_in_week     = $noOfDays;
        $settings->session_per_day          = $noOfSession;
        //$settings->no_of_intervals_per_day  = $noOfInterval;
        $settings->status                   = 1;
        if($settings->save())
        {
            $session = Session::insert($sessionArray);
            if($session) {
                return redirect()->back()->withInput()->with("message","Settings saved successfully")->with("alert-class","alert-success");
            } else {
                return redirect()->back()->withInput()->with("message","Failed to save the settings. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the settings. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
    }

    /**
     * action for time settings
     */
    public function timeSettingsAction(TimeSettingsRegistrationRequest $request)
    {
        $noOfSession        = 0;
        $noOfInterval       = 0;
        $sessionTimeArr     = [];
        $intervalTimeArr    = [];

        $fromTimeSession    = $request->get('from_time');
        $toTimeSession      = $request->get('to_time');
        /*$prevSessionIndex   = $request->get('prev_session_index');
        $intervalFromTime   = $request->get('interval_from_time');
        $intervalToTime     = $request->get('interval_to_time');*/
        
        $settings       = Settings::where('status', 1)->first();
        if(!empty($settings) && !empty($settings->id)) {
            $noOfSession    = $settings->session_per_day;
            //$noOfInterval   = $settings->no_of_intervals_per_day;
        }

        for ($i=1; $i <= $noOfSession; $i++) { 
            $sessionTimeArr[] = [
                'session_index' => $i,
                'from_time'     => (DateTime::createFromFormat('H:i A', $fromTimeSession[$i])->format('H:i:s')),
                'to_time'       => (DateTime::createFromFormat('H:i A', $toTimeSession[$i])->format('H:i:s')),
                'status'        => 1
            ];
        }

        /*for($j=1; $j < $noOfInterval; $j++) {
            $intervalTimeArr[] = [
                'previous_session_id'   => $prevSessionIndex[$j],
                'from_time'             => (DateTime::createFromFormat('H:i A', $intervalFromTime[$j])->format('H:i:s')),
                'to_time'               => (DateTime::createFromFormat('H:i A', $intervalToTime[$j])->format('H:i:s')),
            ];
        }*/

        //delete all existing records
        SessionTime::truncate();
        //IntervalTime::truncate();

        $sessionTimeFlag    = SessionTime::insert($sessionTimeArr);
        //$intervalTimeFlag   = IntervalTime::insert($intervalTimeArr);

        if($sessionTimeFlag/* && $intervalTimeFlag*/)
        {
            return redirect()->back()->with("message","Time Settings saved successfully")->with("alert-class","alert-success");
        }
        
        return redirect()->back()->withInput()->with("message","Failed to save the time settings. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
    }
}
