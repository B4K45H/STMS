@extends('layouts.app')
@section('title', 'Teacher Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Teacher
            <small>Registartion</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Teacher Registration</li>
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
                        <h3 class="box-title" style="float: left;">Teacher Registration</h3>
                            <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('teacher-register-action')}}" method="post" class="form-horizontal">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="teacher_name" class="col-sm-2 control-label"><b style="color: red;">* </b> Teacher Name : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('teacher_name')) ? 'has-error' : '' }}">
                                            <input type="text" name="teacher_name" class="form-control" id="teacher_name" placeholder="Teacher name" value="{{ old('teacher_name') }}" tabindex="1">
                                            @if(!empty($errors->first('teacher_name')))
                                                <p style="color: red;" >{{$errors->first('teacher_name')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><b style="color: red;">* </b>Teaching Category : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('category_id')) ? 'has-error' : '' }}">
                                            <select class="form-control" name="category_id" id="category_id" tabindex="2">
                                                <option value="" {{ empty(old('category_id')) ? 'selected' : '' }}>Select teaching category</option>
                                                <option value="1" {{ old('category_id')==1 ? 'selected' : '' }}>Language</option>
                                                <option value="2" {{ old('category_id')==2 ? 'selected' : '' }}>Science</option>
                                                <option value="3" {{ old('category_id')==3 ? 'selected' : '' }}>Extra Curricular</option>
                                                <option value="4" {{ old('category_id')==4 ? 'selected' : '' }}>Moral</option>
                                            </select>
                                            @if(!empty($errors->first('category_id')))
                                                <p style="color: red;" >{{$errors->first('category_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('description')) ? 'has-error' : '' }}">
                                            @if(!empty(old('description')))
                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description" style="resize: none;" tabindex="3">{{ old('description') }}</textarea>
                                            @else
                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description" style="resize: none;" tabindex="4"></textarea>
                                            @endif
                                            @if(!empty($errors->first('description')))
                                                <p style="color: red;" >{{$errors->first('description')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label"><b style="color: red;">* </b> No of Session per Week : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('no_of_session_per_week')) ? 'has-error' : '' }}">
                                            <input type="text" name="no_of_session_per_week" class="form-control" id="no_of_session_per_week" placeholder="Number of sessions per week" value="{{ old('no_of_session_per_week') }}" tabindex="5">
                                            @if(!empty($errors->first('no_of_session_per_week')))
                                                <p style="color: red;" >{{$errors->first('no_of_session_per_week')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><b style="color: red;">* </b>Experience Level   : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('experience_level')) ? 'has-error' : '' }}">
                                            <select class="form-control" name="experience_level" id="experience_level" tabindex="6">
                                                <option value="" {{ empty(old('experience_level')) ? 'selected' : '' }}>Select experience level</option>
                                                <option value="1" {{ old('experience_level')==1 ? 'selected' : '' }}>Level A</option>
                                                <option value="2" {{ old('experience_level')==2 ? 'selected' : '' }}>Level B</option>
                                                <option value="3" {{ old('experience_level')==3 ? 'selected' : '' }}>Level C</option>
                                            </select>
                                            @if(!empty($errors->first('experience_level')))
                                                <p style="color: red;" >{{$errors->first('experience_level')}}</p>
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
    <!-- /.content -->
</div>
@endsection