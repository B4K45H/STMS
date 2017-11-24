@extends('layouts.app')
@section('title', 'Substitution')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Teacher Leave
            <small>Registration</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Teacher Level</li>
        </ol>
    </section>
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
                        <h3 class="box-title" style="float: left;">Teacher Leave Registration</h3>
                            <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('teacher-leave-register-action')}}" method="post" class="form-horizontal">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="teacher_id" class="col-sm-2 control-label"><b style="color: red;">* </b> Teacher Name : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('teacher_id')) ? 'has-error' : '' }}">
                                            <select class="form-control" name="teacher_id" id="teacher_id" tabindex="3" style="width: 100%">
                                                <option value="">Select teacher</option>
                                                @if(!empty($teachers) && (count($teachers) > 0))
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? "selected" : "" }}>{{ $teacher->teacher_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('teacher_id')))
                                                <p style="color: red;" >{{$errors->first('teacher_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="leave_date" class="col-sm-2 control-label">Leave Date : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('leave_date')) ? 'has-error' : '' }}">
                                            <input type="text" name="leave_date" class="form-control datepicker" placeholder="select date." value="{{ !empty(old('leave_date')) ? old('leave_date') : '' }}" id="datepicker1" tabindex="7">
                                            @if(!empty($errors->first('leave_date')))
                                                <p style="color: red;" >{{$errors->first('leave_date')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            <div class="clearfix"> </div><br>
                            <div class="row">
                                <div class="col-xs-3"></div>
                                <div class="col-xs-3">
                                    <button type="reset" class="btn btn-default btn-block btn-flat" tabindex="8">Clear</button>
                                </div>
                                <div class="col-xs-3">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="7">Submit</button>
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
    <section class="content-header">
        <h1>
            Teacher Substitution
            <small></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
                <div class="box">
                    {{-- <div class="box-header">
                        <h3 class="box-title">Filter List</h3>
                    </div> --}}
                    <!-- /.box-header -->
                    <div class="box-header">
                        <form action="#" method="get" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-6 {{ !empty($errors->first('leave_teacher_id')) ? 'has-error' : '' }}">
                                            <label for="leave_teacher_id" class="control-label">Teacher Name : </label>
                                            <select class="form-control" name="leave_teacher_id" id="leave_teacher_id" tabindex="3" style="width: 100%">
                                                <option value="">Select teacher</option>
                                                @if(!empty($teacherCombo) && (count($teachers) > 0))
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ ((old('leave_teacher_id') == $teacher->id )) ? 'selected' : '' }}>{{ $teacher->teacher_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('leave_teacher_id')))
                                                <p style="color: red;" >{{$errors->first('leave_teacher_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-6 {{ !empty($errors->first('sub_date')) ? 'has-error' : '' }}">
                                            <label for="sub_date" class="control-label">Date : </label>
                                            <input type="text" name="sub_date" class="form-control datepicker" placeholder="select date." value="{{ !empty(old('date')) ? old('sub_date') : '' }}" id="datepicker2" tabindex="7">
                                            @if(!empty($errors->first('sub_date')))
                                                <p style="color: red;" >{{$errors->first('sub_date')}}</p>
                                            @endif
                                            {{-- <select class="form-control" name="day_index" id="day_index" tabindex="3" style="width: 100%">
                                                <option value="">Select day</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                                <option value="5">Friday</option>
                                                <option value="6">Saturday</option>
                                            </select>
                                            @if(!empty($errors->first('day_index')))
                                                <p style="color: red;" >{{$errors->first('day_index')}}</p>
                                            @endif --}}
                                        </div>
                                    </div>
                                    <div class="clearfix"></div><br>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2">
                                            <button type="reset" class="btn btn-default btn-block btn-flat"  value="reset" tabindex="10">Clear</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="4"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /.form end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Timetable : <b>{{ !empty($selectedTeacherName) ? $selectedTeacherName : "" }}</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 12%;"></th>
                                            @for($i=1; $i <=$noOfSession; $i++)
                                                <th style="width: {{ 88/$noOfSession }}%;"><b>{{ $i }}</b></th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sessions as $index => $session)
                                        @if( (($index +1)%$noOfSession) == 1)
                                            <tr>
                                                <td><b>{{ $session->day_name }}</b></td>
                                        @endif
                                        @foreach($timetable as $record)
                                            @if($session->id == $record->session_id)
                                            <?php $flag[$session->id] = 1; ?>
                                                <td>
                                                    <select class="form-control" name="teacher_id" id="teacher_id" tabindex="3" style="width: 100%">
                                                        <option value="">Select teacher</option>
                                                        @if(!empty($teachers) && (count($teachers) > 0))
                                                            @foreach($teachers as $teacher)
                                                                <option value="{{ $teacher->id }}" {{ ((old('teacher_id') == $teacher->id )) ? 'selected' : '' }}>{{ $teacher->teacher_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                            @endif
                                        @endforeach
                                        @if(empty($flag[$session->id]))
                                            <td></td>
                                        @endif
                                        @if( (($index +1)%$noOfSession) == 0)
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.boxy -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
    <script src="/js/results/timetable.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection