<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserUpdationRequest;
use Hash;
use Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Return view for registering new users
     */
    public function register()
    {
        return view('user.register');
    }

    /**
     * Handle new user registration
     */
    public function registerAction(UserRegistrationRequest $request)
    {
        $name       = $request->get('name');
        $userName   = $request->get('user_name');
        $email      = $request->get('email');
        /*$phone      = $request->get('phone');*/
        $password   = $request->get('password');
        $role       = $request->get('role');
        $validTill  = $request->get('valid_till');

        if ($request->hasFile('image_file')) {
            $destination        = '/images/user/'; // upload path
            $file               = $request->file('image_file');
            $extension          = $file->getClientOriginalExtension(); // getting image extension
            $fileName           = $userName.'_'.time().'.'.$extension; // renameing image
            $file->move(public_path().$destination, $fileName); // uploading file to given path
        }

        $user = new User;
        $user->name         = $name;
        $user->user_name    = $userName;
        $user->email        = $email;
        /*$user->phone        = $phone;*/
        $user->password     = Hash::make($password);
        if(!empty($fileName)) {
            $user->image        = $destination.$fileName;
        }
        $user->role         = $role;
        $user->status       = 1;

        if(!empty($validTill)) {
            //converting date and time to sql datetime format
            $validTill = date('Y-m-d H:i:s', strtotime($validTill.' '.'23:59:00'));
            $user->valid_till = $validTill;
        }
        if($user->save()) {
            return redirect()->back()->with("message","Successfully saved.")->with("alert-class","alert-success");
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the user details. Try again after reloading the page!")->with("alert-class","alert-danger");
        }
    }

    /**
     * Return view user profile
     */
    public function profileView()
    {
        return view('user.profile');
    }

    /**
     * Return view for user listing
     */
    public function userList()
    {
        $users = User::paginate(15);

        if(empty($users)) {
            session()->flash('message', 'No users available to show!');
        }
        return view('user.list',[
                    'users' => $users
                ]);
    }

    /**
     * Return view for registering new users
     */
    public function editProfile()
    {
        return view('user.profile-edit');
    }

    /**
     * Handle new user registration
     */
    public function updateProfile(UserUpdationRequest $request)
    {
        $name               = $request->get('name');
        $email              = $request->get('email');
        $currentPassword    = $request->get('old_password');
        $password           = $request->get('password');

        if(Hash::check($currentPassword, Auth::User()->password)) {
            $user = Auth::User();
            $user->name         = $name;
            $user->email        = $email;
            $user->password     = Hash::make($password);

            if($user->save()) {
                return redirect()->back()->with("message","Successfully updated.")->with("alert-class","alert-success");
            } else {
                return redirect()->back()->withInput()->with("message","Failed to update the user profile. Try again after reloading the page!")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Current password is invaild!")->with("alert-class","alert-danger");
        }
    }
}
