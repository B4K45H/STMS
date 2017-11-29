@extends('layouts.app')
@section('title', 'Substituted Timetable')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Substituted Timetable
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Substituted Timetable</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @if (Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="alert-message">
                <h4>
                  {!! Session::get('message') !!}
                  <?php session()->forget('message'); ?>
                </h4>
            </div>
        @endif
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <form action="#" method="get" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label for="substitution_date" class="control-label">Date : </label>
                                            <input type="text" name="substitution_date" class="form-control datepicker" placeholder="select date." value="{{ !empty($substitutionDate) ? $substitutionDate : '' }}" id="datepicker2" tabindex="7">
                                            @if(!empty($errors->first('substitution_date')))
                                                <p style="color: red;" >{{$errors->first('substitution_date')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="substitution_teacher_id" class="control-label">Teacher Name : </label>
                                            <select class="form-control select_2" name="substitution_teacher_id" id="substitution_teacher_id" tabindex="3" style="width: 100%">
                                                <option value="">Select teacher</option>
                                                @if(!empty($teacherCombo) && (count($teacherCombo) > 0))
                                                    @foreach($teacherCombo as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ (!empty($teacherId) && ($teacherId == $teacher->id) ) ? 'selected' : '' }}>{{ $teacher->teacher_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('substitution_teacher_id')))
                                                <p style="color: red;" >{{$errors->first('substitution_teacher_id')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="class_room_id" class="control-label">Class : </label>
                                            <select class="form-control select_2" name="class_room_id" id="class_room_id" tabindex="3" style="width: 100%">
                                                <option value="">Select class room</option>
                                                @if(!empty($classRooms) && (count($classRooms) > 0))
                                                    @foreach($classRooms as $classRoom)
                                                        <option value="{{ $classRoom->id }}" {{ (!empty($classRoomId) && ($classRoomId == $classRoom->id) ) ? 'selected' : '' }}>{{ $classRoom->standard->standard_name. " ". $classRoom->division->division_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('class_room_id')))
                                                <p style="color: red;" >{{$errors->first('class_room_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="clearfix"></div><br>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2">
                                            <button type="reset" class="btn btn-default btn-block btn-flat"  value="reset" tabindex="10">Clear</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat" tabindex="4"><i class="fa fa-search"></i> Search</button>
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
                        <h3 class="box-title"><b>{{ (empty($teacherName) && empty($classRoomName)) ? "Substitutions" : ("Temporary timetable for : ". (!empty($teacherName) ? $teacherName : $classRoomName )) }}</b> &emsp;&emsp; Date : <b>{{ !empty($substitutionDate) ? $substitutionDate : "" }}</b></h3>
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
                                        @if(!empty($sessions) && count($sessions) > 0)
                                            @foreach($sessions as $index => $session)
                                                @if( (($index +1)%$noOfSession) == 1)
                                                    <tr>
                                                        <td><b>{{ $session->day_name }}</b></td>
                                                @endif
                                                <td>
                                                    @foreach($substitutions as $substitution)
                                                        @if($session->id == $substitution->session_id)
                                                            @if(!empty($teacherId) || !empty($classRoomId))
                                                                @if($substitution->combination->teacher_id == $teacherId || $substitution->combination->class_room_id == $classRoomId)
                                                                <?php $flag[$session->id] = 1; ?>
                                                                    <u style="color: red;"><b>{{ $substitution->combination->classRoom->standard->standard_name }}
                                                                    {{ $substitution->combination->classRoom->division->division_name }} /</b>
                                                                    {{ $substitution->combination->subject->subject_name }}
                                                                    <b>[{{ $substitution->combination->teacher->teacher_name }}]</b>
                                                                    </u>
                                                                @endif
                                                            @else
                                                                <u style="color: red;"><b>{{ $substitution->combination->teacher->teacher_name }}</b> [
                                                                {{ $substitution->combination->classRoom->standard->standard_name }}
                                                                {{ $substitution->combination->classRoom->division->division_name }} /
                                                                {{ $substitution->combination->subject->subject_name }} ]</u><br>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    @if(empty($flag[$session->id]))
                                                        @foreach($timetable as $record)
                                                            @if($session->id == $record->session_id)
                                                                <b>{{ $record->combination->classRoom->standard->standard_name }}-{{ $record->combination->classRoom->division->division_name }}</b> / {{ $record->combination->subject->subject_name }}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                @if( (($index +1)%$noOfSession) == 0)
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
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