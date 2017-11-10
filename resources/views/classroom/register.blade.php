@extends('layouts.app')
@section('title', 'ClassRoom Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            ClassRoom
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">ClassRoom Registration</li>
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
                        <h3 class="box-title" style="float: left;">ClassRoom Registration</h3>
                            <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('subject-register-action')}}" method="post" class="form-horizontal">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="room_number" class="col-sm-2 control-label"><b style="color: red;">* </b> Room Number : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('room_number')) ? 'has-error' : '' }}">
                                            <input type="text" name="room_number" class="form-control" id="room_number" placeholder="Room number" value="{{ old('room_number') }}" tabindex="1">
                                            @if(!empty($errors->first('room_number')))
                                                <p style="color: red;" >{{$errors->first('room_number')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><b style="color: red;">* </b>Standard : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('standard_id')) ? 'has-error' : '' }}">
                                            <select class="form-control" name="standard_id" id="standard_id" tabindex="5">
                                                <option value="" {{ empty(old('standard_id')) ? 'selected' : '' }}>Select standard</option>
                                                @if(!empty($standards))
                                                    @foreach($standards as $standard)
                                                        <option value="{{ $standard->id }}" {{ (old('standard_id')== $standard->id) ? 'selected' : '' }}>{{ $standard->standard_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('standard_id')))
                                                <p style="color: red;" >{{$errors->first('standard_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><b style="color: red;">* </b>Division : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('division_id')) ? 'has-error' : '' }}">
                                            <select class="form-control" name="division_id" id="division_id" tabindex="5">
                                                <option value="" {{ empty(old('division_id')) ? 'selected' : '' }}>Select division</option>
                                                @if(!empty($divisions))
                                                    @foreach($divisions as $division)
                                                        <option value="{{ $division->id }}" {{ (old('division_id')== $division->id) ? 'selected' : '' }}>{{ $division->division_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('division_id')))
                                                <p style="color: red;" >{{$errors->first('division_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label"><b style="color: red;">* </b> Strength : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('strength')) ? 'has-error' : '' }}">
                                            <input type="text" name="strength" class="form-control" id="strength" placeholder="Strength" value="{{ old('strength') }}" tabindex="1">
                                            @if(!empty($errors->first('strength')))
                                                <p style="color: red;" >{{$errors->first('strength')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label"><b style="color: red;">* </b> No of Subjects : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('no_of_subjects')) ? 'has-error' : '' }}">
                                            <input type="text" name="no_of_subjects" class="form-control" id="no_of_subjects" placeholder="Number of subjects" value="{{ old('no_of_subjects') }}" tabindex="1">
                                            @if(!empty($errors->first('no_of_subjects')))
                                                <p style="color: red;" >{{$errors->first('no_of_subjects')}}</p>
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><b style="color: red;">* </b>Incharge : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('teacher_incharge_id')) ? 'has-error' : '' }}">
                                            <select class="form-control" name="teacher_incharge_id" id="teacher_incharge_id" tabindex="5">
                                                <option value="" {{ empty(old('teacher_incharge_id')) ? 'selected' : '' }}>Select incharge</option>
                                                @if(!empty($teachers))
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ (old('teacher_incharge_id')== $teacher->id) ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('teacher_incharge_id')))
                                                <p style="color: red;" >{{$errors->first('teacher_incharge_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="box-header with-border">
                                        <h3 class="box-title" style="float: left;">Subject - Teacher Assignment</h3>
                                        <p id="real_account_flag_message" style="color:blue;">&nbsp&nbsp&nbsp Select subject and teacher associated with class.</p>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Subject - Teacher : </label>
                                        <div class="col-sm-10">
                                            @if(!empty($subjects))
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 2%;">#</th>
                                                            <th style="width: 20%;">Subject</th>
                                                            <th style="width: 15%;">Teacher</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($subjects as $index=>$subject)
                                                            <tr>
                                                                <td>
                                                                    {{ $index+1 }}
                                                                </td>
                                                                <td>
                                                                    <label for="subject_{{ $index }}" class="form-control">{{ $subject->subject_name }}</label>
                                                                </td>
                                                                <td>
                                                                    <div class="col-lg-12">
                                                                        <select class="form-control" name="teacher_id[]" id="teacher_id" tabindex="5">
                                                                            <option value="" {{ empty(old('teacher_id')) ? 'selected' : '' }}>Select teacher</option>
                                                                            @if(!empty($teachers))
                                                                                @foreach($teachers as $teacher)
                                                                                    <option value="{{ $teacher->id }}" {{ (old('teacher_id')== $teacher->id) ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
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
    </section>
    <!-- /.content -->
</div>
@endsection