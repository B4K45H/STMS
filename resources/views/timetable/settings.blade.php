@extends('layouts.app')
@section('title', 'Timetable Settings')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Timetable
            <small>Settings</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Timetable Settings</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @if (Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="alert-message">
                <h4>
                  {{ Session::get('message') }}
                </h4>
            </div>
        @endif
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row no-print">
                    <div class="col-md-12">
                        <div class="callout callout-warning">
                            <h4>
                                <i class="fa fa-exclamation-circle">&emsp;<b>Warning</b></i>
                            </h4>
                            <h5>
                                <b>&emsp;Any updation to the current session settings would invalidate the existing timetable.</b>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="float: left;">Session Settings</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('timetable-settings-action')}}" method="post" class="form-horizontal">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label"><b style="color: red;">* </b> Working Days In A Week : </label>
                                        <div class="col-sm-9 {{ !empty($errors->first('no_of_days')) ? 'has-error' : '' }}">
                                            <select class="form-control select_2" name="no_of_days" id="no_of_days" tabindex="1" style="width: 100%">
                                                <option value="" {{ (empty(old('no_of_days')) || empty($noOfDays)) ? 'selected' : '' }}>Select working days in a week</option>
                                                <option value="5" {{ (old('no_of_days')==1 || $noOfDays == 5) ? 'selected' : '' }}>Monday to Friday - 5 Days</option>
                                                <option value="6" {{ (old('no_of_days')==2 || $noOfDays == 6) ? 'selected' : '' }}>Monday to Saturday - 6 days</option>
                                            </select>
                                            @if(!empty($errors->first('name')))
                                                <p style="color: red;" >{{$errors->first('name')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><b style="color: red;">* </b>No Of Sessions In A Day : </label>
                                        <div class="col-sm-9 {{ !empty($errors->first('no_of_session')) ? 'has-error' : '' }}">
                                            <select class="form-control select_2" name="no_of_session" id="no_of_session" tabindex="2" style="width: 100%">
                                                <option value="" {{ (empty(old('no_of_session')) || empty($noOfSession)) ? 'selected' : '' }}>Select no of sessions in a day</option>
                                                <option value="5" {{ (old('no_of_session')==5 || $noOfSession == 5) ? 'selected' : '' }}>5 Sessions</option>
                                                <option value="6" {{ (old('no_of_session')==6 || $noOfSession == 6) ? 'selected' : '' }}>6 Sessions</option>
                                                <option value="7" {{ (old('no_of_session')==7 || $noOfSession == 7) ? 'selected' : '' }}>7 Sessions</option>
                                                <option value="8" {{ (old('no_of_session')==8 || $noOfSession == 8) ? 'selected' : '' }}>8 Sessions</option>
                                                <option value="9" {{ (old('no_of_session')==9 || $noOfSession == 9) ? 'selected' : '' }}>9 Sessions</option>
                                            </select>
                                            @if(!empty($errors->first('no_of_session')))
                                                <p style="color: red;" >{{$errors->first('no_of_session')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="clearfix"> </div><br>
                            <div class="row">
                                <div class="col-xs-3"></div>
                                <div class="col-xs-3">
                                    <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="6">Clear</button>
                                </div>
                                <div class="col-xs-3">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit" tabindex="5">Submit</button>
                                </div>
                                <!-- /.col -->
                            </div><br>
                        </div>
                    </form>
                </div>
                <!-- /.box primary -->
            </div>
            </div>
        </div>
        <!-- /.row (main row) -->
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <!-- form start -->
                    <form action="{{route('timetable-time-settings-action')}}" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title" style="float: left;">Session Time Settings</h3>
                                    <p>&emsp;(All fields are mandatory.)</b></p>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="clearfix"></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%;"><p class="text-center">Session Index</p></th>
                                                    <th style="width: 40%;"><p class="text-center">Start Time</p></th>
                                                    <th style="width: 40%;"><p class="text-center">End Time</p></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($noOfSession))
                                                @for($i=1; $i <= $noOfSession; $i++)
                                                    <tr>
                                                        <td class="text-center">
                                                            <b>{{ $i }}</b>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-12 {{ (!empty($errors->first('from_time.'.$i)) || !empty($errors->first('time_error.'.$i))) ? 'has-error' : '' }}">
                                                                <div class="bootstrap-timepicker">
                                                                    <input type="text" class="form-control text-center timepicker" name="from_time[{{ $i }}]" id="from_time_{{ $i }}" placeholder="Time" value="{{ !empty(old('from_time.'.$i)) ? old('from_time.'.$i) : (!empty($sessionTimes[$i]['fromTime']) ? $sessionTimes[$i]['fromTime'] : "" ) }}">
                                                                </div>
                                                                @if(!empty($errors->first('from_time.'.$i)))
                                                                    <p style="color: red;" >{{$errors->first('from_time.'. $i)}}</p>
                                                                @endif
                                                                @if(!empty($errors->first('time_error.'.$i)))
                                                                    <p style="color: red;" >{{$errors->first('time_error.'. $i)}}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-12 {{ (!empty($errors->first('to_time.'.$i)) || !empty($errors->first('time_error.'.$i))) ? 'has-error' : '' }}">
                                                                <div class="bootstrap-timepicker">
                                                                    <input type="text" class="form-control text-center timepicker" name="to_time[{{ $i }}]" id="to_time_{{ $i }}" placeholder="Time" value="{{ !empty(old('to_time.'.$i)) ? old('to_time.'.$i) : (!empty($sessionTimes[$i]['toTime']) ? $sessionTimes[$i]['toTime'] : "" ) }}">
                                                                </div>
                                                                @if(!empty($errors->first('to_time.'.$i)))
                                                                    <p style="color: red;" >{{$errors->first('to_time.'.$i)}}</p>
                                                                @endif
                                                                @if(!empty($errors->first('time_error.'.$i)))
                                                                    <p style="color: red;" >{{$errors->first('time_error.'. $i)}}</p>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-3">
                                        <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="6">Clear</button>
                                    </div>
                                    <div class="col-xs-3">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat submit" tabindex="5">Submit</button>
                                    </div>
                                    <!-- /.col -->
                                </div><br>
                            </div>
                        </div>
                        <!-- /.box primary -->
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row no-print">
                    <div class="col-md-12">
                        <div class="callout callout-warning">
                            <h4>
                                <i class="fa fa-exclamation-circle">&emsp;<b>Warning</b></i>
                            </h4>
                            <h5>
                                <b>&emsp;Generating new Timetable would delete the existing timetable and generate the new one. This action is irreversible!</b>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="float: left;">Timetable Generation</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('timetable-generation-action')}}" method="post" class="form-horizontal" id="timetable_generate_form">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="clearfix"> </div>
                                <div class="row">
                                <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center">&emsp;</span>
                                                <h5 class="text-info">To generete the new timetable, type the characters you see in the confirmation popup and click <b>Confirm </b>button.</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-xs-4"></div>
                                    <div class="col-xs-4">
                                        <button type="button" class="btn btn-primary btn-block btn-flat submit" id="timetable_generate_btn" tabindex="5" {{ ($noOfSession > 0 && $noOfDays > 0 && $sessionStatus == 1) ? "" : "disabled" }}>
                                            {{ $timetableStatus == 0 ? "G" : "Reg" }}enerate Timetable
                                        </button>
                                        @if($sessionStatus != 1)
                                            <p style="color: red;">Due to invalid setings, timetable can't be generated.</p>
                                        @endif
                                    </div>
                                    <!-- /.col -->
                                </div><br>
                        </div>
                    </form>
                </div>
                <!-- /.box primary -->
            </div>
            </div>
        </div>
        <!-- /.row (main row) -->
        <div class="modal modal-warning" data-backdrop="static" data-keyboard="false" id="confirm_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close modal_close_button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-question-circle"> Confirm Action</i>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Captcha Message : <p class="pull-right">:</p></label>
                            <div class="col-sm-7">
                                <input type="text" id="captcha_message" name="captcha_message" class="form-control" style="width: 100%; color: red; font-size:25px;" readonly>
                            </div>
                        </div><br><br>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Enter The Message <i style="color: maroon;">(Case sensitive)</i><p class="pull-right">:</p></label>
                            <div class="col-sm-7">
                                <input type="text" id="user_captcha" name="user_captcha" class="form-control" style="width: 100%;">
                            </div>
                        </div><br><br>
                        <div id="modal_warning">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-sm-11">
                                    <h4>Are You Sure to delete existing timetable and generate new one?</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left modal_close_button" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn_modal_submit" class="btn btn-outline">Confirm</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="modal modal-default" data-backdrop="static" data-keyboard="false" id="wait_modal" style="background: url('/images/public/hour_glass.gif') no-repeat; background-position: center center; background-color: #000000;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #000000; color: white;">
                        <h4 class="modal-title">
                            <div class='overlay'><i class='fa fa-hourglass-half fa-spin'></i>&emsp;Generating Timetable</div>
                        </h4>
                    </div>
                    <div class="modal-body" style="background-color: #000000; color: white;">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-center" id="wait_modal_message_1">
                                    <b>Processing...</b>
                                </h4>
                                <h4 class="text-center" id="wait_modal_message_2" hidden>
                                    <b>Do not refresh the page or close the window.</b>
                                </h4>
                                <h4 class="text-center" id="wait_modal_message_3" hidden>
                                    <b>Please wait, this might take several minutes.</b>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #000000;">
                        <h5 style="color: blue;" class="text-center">
                            <b>You will be automatically redirected when completed.</b>
                        </h5>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
    <script src="/js/results/timetable.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection