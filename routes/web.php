<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//licence
Route::get('/licence', 'LoginController@licence')->name('licence');
Route::get('/under-construction', 'LoginController@underConstruction')->name('under-construction');

Route::group(['middleware' => 'is.guest'], function() {
    Route::get('/', 'LoginController@publicHome')->name('public-home');
    //user validity expired
    Route::get('/user/expired', 'LoginController@userExpired')->name('user-expired');

    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/login/action', 'LoginController@loginAction')->name('login-action');
});
Route::group(['middleware' => 'auth.check'], function () {
    //common routes
    Route::get('/dashboard', 'LoginController@dashboard')->name('dashboard');
    Route::get('/my/profile', 'UserController@profileView')->name('user-profile');
    Route::get('/my/profile/edit', 'UserController@editProfile')->name('profile-edit');
    Route::post('/my/profile/update/action', 'UserController@updateProfile')->name('profile-update-action');
    Route::get('/lockscreen', 'LoginController@lockscreen')->name('lockscreen');
    Route::get('/logout', 'LoginController@logout')->name('logout-action');
    Route::get('/error/404', 'LoginController@invalidUrl')->name('invalid-url');
    Route::get('/error/500', 'LoginController@serverError')->name('server-error');

    //superadmin routes
    Route::group(['middleware' => ['user.role:0,,']], function () {
        Route::get('/user/register', 'UserController@register')->name('user-register');
        Route::post('/user/register/action', 'UserController@registerAction')->name('user-register-action');
        Route::get('/user/list', 'UserController@userList')->name('user-list');
    });

    //admin routes
    Route::group(['middleware' => ['user.role:1,,']], function () {
        //subject
        Route::get('/subject/register', 'SubjectController@register')->name('subject-register');
        Route::post('/subject/register/action', 'SubjectController@registerAction')->name('subject-register-action');
        Route::get('/subject/list', 'SubjectController@subjectList')->name('subject-list');

        //teacher
        Route::get('/teacher/register', 'TeacherController@register')->name('teacher-register');
        Route::post('/teacher/register/action', 'TeacherController@registerAction')->name('teacher-register-action');
        Route::get('/teacher/list', 'TeacherController@teacherList')->name('teacher-list');

        //class
        Route::get('/classroom/register', 'ClassRoomController@register')->name('class-room-register');
        Route::post('/classroom/register/action', 'ClassRoomController@registerAction')->name('class-room-register-action');
        Route::get('/classroom/list', 'ClassRoomController@classRoomList')->name('class-room-list');
        Route::get('/classroom/combinationList/{id}', 'ClassRoomController@combinationList')->name('class-room-combination-list');
        Route::get('/get/subjects/standard/{id}', 'ClassRoomController@getSubjectsByStandard')->name('get-subjects-by-standard');

        //timetable
        Route::get('/timetable/teacher', 'TimetableController@teacherLevel')->name('timetable-teacher');
        Route::get('/timetable/student', 'TimetableController@studentLevel')->name('timetable-student');
        Route::get('/timetable/settings', 'TimetableController@settings')->name('timetable-settings');
        Route::post('/timetable/settings/action', 'TimetableController@settingsAction')->name('timetable-settings-action');
        Route::post('/timetable/generate/action', 'TimetableController@generateTimetableAction')->name('timetable-generation-action');
        
        //substitution - leave
        Route::get('/substitution/leave/register', 'LeaveController@leaveRegister')->name('substitution-leave-register');
        Route::Post('/substitution/leave/register/action', 'LeaveController@leaveRegisterAction')->name('teacher-leave-register-action');

        //substitution
        Route::get('/substitution/register', 'SubstitutionController@substitution')->name('substitution-register');
        Route::post('/substitution/register/action', 'SubstitutionController@substitutionAction')->name('substitution-register-action');
        Route::get('/substitution/temp/timetable', 'SubstitutionController@substitutedTimetable')->name('substituted-timetable');
    });
});