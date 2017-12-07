<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Settings;
use App\Models\SessionTime;
use App\Http\Requests\TimeSettingsRegistrationRequest;
use DateTime;
use Validator;

class SettingsController extends Controller
{
    /**
     * Return view for timetable settings
     */
    public function settings()
    {
        $noOfDays       = 0;
        $noOfSession    = 0;
        $sessionTimes   = [];
        $sessionStatus  = 0;

        $settings       = Settings::first();
        $timeSessions   = SessionTime::where('status', 1)->get();

        if(!empty($settings) && !empty($settings->id)) {
            $noOfDays           = $settings->working_days_in_week;
            $noOfSession        = $settings->session_per_day;
            $timetableStatus    = $settings->time_table_status;
        }

        $sessionCount = Session::where('status', 1)->count();
        if(!empty($sessionCount) && $sessionCount > 0 && $sessionCount == ($noOfSession * $noOfDays)) {
            $sessionStatus = 1;
        }

        foreach ($timeSessions as $key => $timeSession) {
            $sessionTimes [$timeSession->session_index] = [
                "fromTime"  => DateTime::createFromFormat('H:i:s', $timeSession->from_time)->format('H:i A'),
                "toTime"    => DateTime::createFromFormat('H:i:s', $timeSession->to_time)->format('H:i A'),
            ];
        }

        return view('timetable.settings', [
                'noOfDays'          => $noOfDays,
                'noOfSession'       => $noOfSession,
                'timetableStatus'   => $timetableStatus,
                'sessionTimes'      => $sessionTimes,
                'sessionStatus'     => $sessionStatus,
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

        $day        = [1 => 'Monday', 2 => 'Tuesday', 3=> 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
        $session    = [1 => 'Mo', 2 => 'Tu', 3 => 'We', 4 => 'Th', 5 => 'Fr', 6 => 'Sa'];

        for ($i=1; $i <= $noOfDays; $i++) { 
            for ($j=1; $j <= $noOfSession; $j++) { 
                $sessionArray[] = [
                    'day_index'     => $i,
                    'session_index' => $j,
                    'day_name'      => $day[$i],
                    'session_name'  => ($session[$i]. " - ". $j),
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
        $settings->time_table_status        = 0;
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
        $sessionTimeArr     = [];
        $intervalTimeArr    = [];
        $validator          = Validator::make([], []);
        $errorFlag          = 0;

        //session time
        $fromTimeSession    = $request->get('from_time');
        $toTimeSession      = $request->get('to_time');
        
        $settings       = Settings::where('status', 1)->first();
        if(!empty($settings) && !empty($settings->id)) {
            $noOfSession    = $settings->session_per_day;
        }

        for ($i=1; $i <= $noOfSession; $i++) {
            $fromTime   = DateTime::createFromFormat('H:i A', $fromTimeSession[$i])->format('H:i:s');
            $toTime     = DateTime::createFromFormat('H:i A', $toTimeSession[$i])->format('H:i:s');

            if($fromTime > $toTime) {
                //invalid time selection
                $validator->errors()->add('time_error.'.$i, "Session start time should be less than end time!");
                $errorFlag = 1;
            }

            $sessionTimeArr[] = [
                'session_index' => $i,
                'from_time'     => $fromTime,
                'to_time'       => $toTime,
                'status'        => 1
            ];
        }

        if($errorFlag != 0) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //delete all existing records
        SessionTime::truncate();

        $sessionTimeFlag    = SessionTime::insert($sessionTimeArr);

        if($sessionTimeFlag)
        {
            return redirect()->back()->with("message","Time Settings saved successfully")->with("alert-class","alert-success");
        }
        
        return redirect()->back()->withInput()->with("message","Failed to save the time settings. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
    }
}
