<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /**
     * Return view for public home page
     */
    public function publicHome()
    {
        return view('public.home');
    }

    /**
     * Return view for login
     */
    public function login()
    {
        return view('public.login');
    }

    public function lockscreen()
    {
        $user = Auth::user();
        Auth::logout();

        return view('user.lockscreen',[
                'user'  => $user
            ]);
    }

    /**
     * Handle an authentication attempt.
     */
    public function loginAction(Request $request)
    {
        $userName = $request->get('user_name');
        $password = $request->get('password');
         
         if(Auth::attempt(['user_name' => $userName, 'password' => $password, 'status' => '1'],false)) {
            // Authentication passed...
            $user   = Auth::user();
            $today  = strtotime('now');
            $userValidDate = strtotime($user->valid_till);
            // redirect to login if the user validation is completed
            if(!empty($user->valid_till) && $today > $userValidDate) {
                //logout user
                Auth::logout();
                return redirect(route('user-expired'))->with("expired-user", $user->user_name);
            } else if(!empty($user->valid_till) && (($userValidDate - $today) <= 172800)){
                return redirect(route('user-dashboard'))->with("message",("Welcome " . $user->name . ". Your trial pack ends on " . $user->valid_till . ". Please contact developer team for more info."))->with("alert-class","alert-warning");
            }
            return redirect(route('dashboard'))->with("message","Welcome " . $user->name . ". You are successfully logged in to the School Timetable Managemet System.")->with("alert-class","alert-success");
        } else {
            // Authentication fails...
            return redirect(route('login'))->with("message","Login failed. Incorrect user name and password.")->with("alert-class","alert-danger");
        }
    }

    /**
     * Redirect successfully logged users
     */
    public function dashboard()
    {
        $pendingWeighmentsCount = 0;
        $accountsCount = 0;
        $salesCount = 0;
        $productsCount = 0;

        return view('user.dashboard', [
                'pendingWeighmentsCount'    => $pendingWeighmentsCount,
                'accountsCount'             => $accountsCount,
                'salesCount'                => $salesCount,
                'productsCount'             => $productsCount
            ]);
    }

    /**
     * Logsout users
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    /**
     * Return view for software licence
     */
    public function licence()
    {
        return view('public.license');
    }

    /**
     * Return view for uncompleted pages
     */
    public function underConstruction()
    {
        return view('public.under-construction');
    }

    /**
     * Return view for expired users
     */
    public function userExpired()
    {
        return view('public.expired');
    }
}
