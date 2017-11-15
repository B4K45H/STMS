@extends('layouts.app')
@section('title', 'Timetable Settings')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Teacher
            <small>Registartion</small>
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
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="float: left;">Session Settigs</h3>
                            <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
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
                                            <select class="form-control" name="no_of_days" id="no_of_days" tabindex="5">
                                                <option value="" {{ empty(old('no_of_days')) ? 'selected' : '' }}>Select working days in a week</option>
                                                <option value="5" {{ old('no_of_days')==1 ? 'selected' : '' }}>Monday to Friday - 5 Days</option>
                                                <option value="6" {{ old('no_of_days')==2 ? 'selected' : '' }}>Monday to Saturday - 6 days</option>
                                            </select>
                                            @if(!empty($errors->first('name')))
                                                <p style="color: red;" >{{$errors->first('name')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><b style="color: red;">* </b>No Of Sessions In A Day : </label>
                                        <div class="col-sm-9 {{ !empty($errors->first('no_of_session')) ? 'has-error' : '' }}">
                                            <select class="form-control" name="no_of_session" id="category_id" tabindex="5">
                                                <option value="" {{ empty(old('no_of_session')) ? 'selected' : '' }}>Select no of sessions in a day</option>
                                                <option value="5" {{ old('no_of_session')==1 ? 'selected' : '' }}>5 Sessions</option>
                                                <option value="6" {{ old('no_of_session')==2 ? 'selected' : '' }}>6 Sessions</option>
                                                <option value="7" {{ old('no_of_session')==3 ? 'selected' : '' }}>7 Sessions</option>
                                                <option value="8" {{ old('no_of_session')==4 ? 'selected' : '' }}>8 Sessions</option>
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
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="5">Submit</button>
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
                            <p>&nbsp&nbsp&nbsp<b style="color: red;">Proceed with caution.</b></p>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('timetable-generation-action')}}" method="post" class="form-horizontal">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-md-11">
                                    <p style="color: orange;">
                                        &emsp;&emsp;&emsp; You are about to delete the existing timetable and generate the new one. If once submited the existing timetable would be permanently lost.To generete the new timetable a confirmation dialoge would ask you for the user password, fill them and click generate timetable button.
                                    </p>
                                </div>
                            <div class="clearfix"> </div><br>
                            <div class="row">
                                <div class="col-xs-4"></div>
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="5">Generate Timetable</button>
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
    </section>
    <!-- /.content -->
</div>
@endsection