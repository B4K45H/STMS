@extends('layouts.app')
@section('title', 'Student Level Timetable')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Student Level
            <small>Timetable</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Student Level</li>
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
                                        <div class="col-sm-10 {{ !empty($errors->first('class_room_id')) ? 'has-error' : '' }}">
                                            <label for="class_room_id" class="control-label">Class : </label>
                                            <select class="form-control" name="class_room_id" id="class_room_id" tabindex="3" style="width: 100%">
                                                <option value="">Select class</option>
                                                @if(!empty($classRooms) && (count($classRooms) > 0))
                                                    @foreach($classRooms as $classRoom)
                                                        <option value="{{ $classRoom->id }}" {{ ((old('class_room_id') == $classRoom->id )) ? 'selected' : '' }}>{{ $classRoom->standard->standard_name }} - {{ $classRoom->division->division_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('class_room_id')))
                                                <p style="color: red;" >{{$errors->first('class_room_id')}}</p>
                                            @endif
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
                        <h3 class="box-title">Timetable for class : {{ !empty($selectedClassRoomName) ? $selectedClassRoomName : "Nil" }}<b></b></h3>
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
                                        @if((($index +1)%$noOfSession) == 1)
                                            <tr>
                                                <td><b>{{ $session->day_name }}</b></td>
                                        @endif
                                        @foreach($timetable as $record)
                                            @if($session->id == $record->session_id)
                                            <?php $flag[$session->id] = 1; ?>
                                                <td><b>{{ $record->combination->subject->subject_name }}</b> / {{ $record->combination->teacher->name }}</td>
                                            @endif
                                        @endforeach
                                        @if(empty($flag[$session->id]))
                                            <td>-</td>
                                        @endif
                                        @if((($index +1)%$noOfSession) == 0)
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