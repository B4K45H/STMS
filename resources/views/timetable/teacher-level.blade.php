@extends('layouts.app')
@section('title', 'Teacher Level Timetable')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Teacher Level
            <small>Timetable</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Teacher Level</li>
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
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="col-sm-12 {{ !empty($errors->first('teacher_id')) ? 'has-error' : '' }}">
                                            <label for="teacher_id" class="control-label">Teacher : </label>
                                            <select class="form-control select_2" name="teacher_id" id="teacher_id" tabindex="3" style="width: 100%">
                                                <option value="">Select teacher</option>
                                                @if(!empty($teachers) && (count($teachers) > 0))
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ (($selectedTeacherId == $teacher->id )) ? 'selected' : '' }}>{{ $teacher->teacher_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('teacher_id')))
                                                <p style="color: red;" >{{$errors->first('teacher_id')}}</p>
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
        @if(empty($noOfSession) || $noOfSession == 0)
            <div class="alert alert-danger">
                <h4>&emsp;&emsp;Settings changed! Current timetable is invalid.&emsp;Please regenerate timetable with new settings.</h4>
            </div>
        @else
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">
                                Teacher's Timetable : &emsp;<b><i>{{ !empty($selectedTeacherName) ? $selectedTeacherName : "" }}</i></b>
                            </h3>
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
                                                    <th style="width: {{ (88/$noOfSession) }}%;"><b>{{ $i }}</b></th>
                                                @endfor
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sessions as $index => $session)
                                            @if( (($index +1)%$noOfSession) == 1 )
                                                <tr>
                                                    <td><div style="height: 50px; overflow:auto;"><b>{{ $session->day_name }}</b></div></td>
                                            @endif
                                            <td>
                                                @foreach($timetable as $record)
                                                    @if($session->id == $record->session_id)
                                                        <b>{{ $record->combination->classRoom->standard->standard_name }}-{{ $record->combination->classRoom->division->division_name }}</b> / {{ $record->combination->subject->subject_name }}{{-- </td> --}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            @if( (($index +1)%$noOfSession) == 0 )
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
        @endif
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
    <script src="/js/results/timetable.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection