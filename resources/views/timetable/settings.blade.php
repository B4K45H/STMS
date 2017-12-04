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
            <li class="active">Subject Registration</li>
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
        <div class="row no-print">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="callout callout-warning">
                    <i  style="color: red;" class="fa fa-exclamation-circle">&emsp;<b><i> Warning</i></b></i>
                    <br><br>
                    <ul>
                        <li>
                            <b style="color: maroon;">&emsp;Any changes to the current settings would invalidate the current timetable.</b>
                        </li>
                        <li>
                            <b style="color: maroon;">&emsp;Generating new timetable would delete the existing timetable and generate the new one.</b>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="float: left;">Session Settings</h3>
                            <p>&emsp;&emsp;<b style="color: maroon;"><i class="fa fa-exclamation-triangle"></i> Proceed with caution.</b></p>
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
                                            @if(!empty($errors->first('category_id')))
                                                <p style="color: red;" >{{$errors->first('category_id')}}</p>
                                            @endif
                                        </div>
                                    </div><br>
                                </div>
                            <div class="clearfix"> </div><br>
                            <div class="row">
                                <div class="col-xs-3"></div>
                                <div class="col-xs-3">
                                    <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="6">Clear</button>
                                </div>
                                <div class="col-xs-3">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat" tabindex="5">Submit</button>
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="float: left;">Timetable Generation</h3>
                            <p>&emsp;&emsp;<b style="color: maroon;"><i class="fa fa-exclamation-triangle"></i> Proceed with caution.</b></p>
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
                                        <p style="color: blue;">&emsp;&emsp;<b>To generete the new timetable a confirmation dialoge would ask you for the captcha, fill them and click generate timetable button.</b></p>
                                    </div>
                                    <br><br>
                                    <div class="col-xs-4"></div>
                                    <div class="col-xs-4">
                                        <button type="button" class="btn btn-primary btn-block btn-flat" id="timetable_generate_btn" tabindex="5" {{ empty($noOfSession) || empty($noOfDays) ? "disabled" : "" }}>Generate Timetable</button>
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
        <div class="modal modal-warning" id="confirm_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" style="color: red;">Confirm Settings</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Captcha Message : <p class="pull-right">:</p></label>
                            <div class="col-sm-7">
                                <input type="text" id="captcha_message" name="captcha_message" class="form-control" style="width: 100%; color: red; font-size:25px;" readonly>
                            </div>
                        </div><br><br>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Enter The Message <i style="color: maroon;">(Case sensitive)</i><p class="pull-right">:</p></label>
                            <div class="col-sm-7">
                                <input type="text" id="user_captcha" name="user_captcha" class="form-control" style="width: 100%;">
                            </div>
                        </div><br><br>
                        <div id="modal_warning">
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-10">
                                    <p style="color: blue;">
                                        <b><i>Please enter the character string as it is shown in the box above.</i></b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn_modal_submit" class="btn btn-outline">Confirm</button>
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