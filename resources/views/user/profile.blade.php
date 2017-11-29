@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            My Profile
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @if (Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="alert-message">
                <h4>
                  {!! Session::get('message') !!}
                </h4>
            </div>
        @endif
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="float: left;">{{ $currentUser->name }}'s Profile</h3>
                        </div>
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <!-- Profile Image -->
                                <div class="box-body box-profile">
                                    <img class="profile-user-img img-responsive img-circle" src="/images/user/default_user.jpg" alt="User profile picture">
                                    <h3 class="profile-username text-center">{{ $currentUser->name }}</h3>
                                    <p class="text-muted text-center">{{ $currentUser->role == 2? 'Employee' : 'Admin' }}</p>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b class="">Name : </b>
                                                <a class="pull-right">{{ !empty($currentUser->name) ? $currentUser->name : 'Nil' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b class="">Username : </b>
                                                <a class="pull-right">{{ !empty($currentUser->user_name) ? $currentUser->user_name : 'Nil' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b class="">E-mail : </b>
                                                <a class="pull-right">{{ !empty($currentUser->email) ? $currentUser->email : '    Nil' }}</a>
                                            </li>
                                            {{-- <li class="list-group-item">
                                                <b class="">Phone : </b>
                                                <a class="pull-right">{{ !empty($currentUser->phone) ? $currentUser->phone : 'Nil' }}</a>
                                            </li> --}}
                                            <li class="list-group-item">
                                                <b class="">Role : </b>
                                                <a class="pull-right">{{ !empty($currentUser->role) ? ($currentUser->role == 2? 'Employee' : 'Admin') : 'Nil' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b class="">Valid Till : </b>
                                                <a class="pull-right">{{ !empty($currentUser->valid_till) ? $currentUser->valid_till : 'Unlimited' }}</a>
                                            </li>
                                        </ul><br>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3  no-print">
                                            <a href="{{ route('logout-action') }}" class="btn btn-primary btn-block"><b>LogOut</b></a>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3  no-print">
                                            <a href="{{ route('profile-edit') }}" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                                        </div>
                                        <div class="clearfix"></div><br>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                    <!-- /.box primary -->
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection