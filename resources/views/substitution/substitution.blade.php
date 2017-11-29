@extends('layouts.app')
@section('title', 'Substitution')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Teacher Substitution
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Substitution</li>
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
        @if (count($errors) > 0)
            <div class="alert alert-danger" id="alert-message">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                                        <div class="col-sm-6">
                                            <label for="sub_date" class="control-label">Date : </label>
                                            <input type="text" name="sub_date" class="form-control datepicker" placeholder="select date." value="{{ !empty($substitutionDate) ? $substitutionDate : '' }}" id="datepicker2" tabindex="7">
                                            @if(!empty($errors->first('sub_date')))
                                                <p style="color: red;" >{{$errors->first('sub_date')}}</p>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="leave_teacher_id" class="control-label">Teacher Name : </label>
                                            <select class="form-control" name="leave_teacher_id" id="leave_teacher_id" tabindex="3" style="width: 100%">
                                                <option value="">Select teacher</option>
                                                @if(!empty($teacherCombo) && (count($teacherCombo) > 0))
                                                    @foreach($teacherCombo as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ (!empty($teacherId) && ($teacherId == $teacher->id) ) ? 'selected' : '' }}>{{ $teacher->teacher_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('leave_teacher_id')))
                                                <p style="color: red;" >{{$errors->first('leave_teacher_id')}}</p>
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
                        <h3 class="box-title">Substitution for : <b>{{ !empty($leaveTeacherName) ? $leaveTeacherName : "" }}</b> &emsp;&emsp;Date : <b>{{ !empty($substitutionDate) ? $substitutionDate : "" }}</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{route('substitution-register-action')}}" method="post" class="form-horizontal">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="sub_date" value="{{ !empty($substitutionDate) ? $substitutionDate : "" }}">
                                    <input type="hidden" name="leave_teacher_id" value="{{ !empty($teacherId) ? $teacherId : "" }}">
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
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" value="Class : {{ $record->combination->classRoom->standard->standard_name }} - {{ $record->combination->classRoom->division->division_name }}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" name="session_id[]" value="{{ $record->session_id }}">
                                                                <select class="form-control teacher_select" name="combination_id[{{ $record->session_id }}]" tabindex="3" style="width: 100%">
                                                                    <option value="">Select teacher</option>
                                                                    @if(!empty($classCombinations[$record->combination->class_room_id]) && (count($classCombinations[$record->combination->class_room_id]) > 0))
                                                                        @foreach($classCombinations[$record->combination->class_room_id] as $comb)
                                                                            @if(!in_array($comb->teacher_id, $engageExcludeArr[$record->session_id]) && !in_array($comb->teacher_id, $leaveExcludeArr))
                                                                                <option value="{{ $comb->id }}" {{ (!empty($substituted[$record->session_id]) && $substituted[$record->session_id] == $comb->id) ? 'selected disabled' : '' }}>{{ $comb->teacher->teacher_name }} - {{ $comb->subject->subject_name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
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
                                    <div class="clearfix"> </div><br>
                                    <div class="row">
                                        <div class="col-xs-5"></div>
                                        <div class="col-xs-2">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat" tabindex="7" {{ (empty($teacherId) || empty($substitutionDate)) ? "disabled" : "" }}>Submit</button>
                                        </div>
                                        <!-- /.col -->
                                    </div><br>
                                </form>
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