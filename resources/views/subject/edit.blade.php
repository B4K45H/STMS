@extends('layouts.app')
@section('title', 'Subject Registration')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Subject
            <small>Updation</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Subject Updation</li>
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
        @if (!empty($errors->first('standard')))
            <div class="alert alert-danger" id="alert-message">
                <ul>
                    <li>{{ $errors->first('standard') }}</li>
                </ul>
            </div>
        @endif
        <!-- Main row -->
        <div class="row  no-print">
            <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row no-print">
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            <h4>
                                <i class="fa fa-warning">&emsp;Warning!</i>
                            </h4>
                            <h5>Updating some fields would invalidate the current timetable.</h5>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="float: left;">Subject Updation</h3>
                            <p>&nbsp&nbsp&nbsp(Fields marked with <b style="color: red;">* </b>are mandatory.)</p>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('subject-edit-action')}}" method="post" class="form-horizontal">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="subject_name" class="col-sm-2 control-label"><b style="color: red;">* </b> Subject Name : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('subject_name')) ? 'has-error' : '' }}">
                                            <input type="text" name="subject_name" class="form-control" id="subject_name" placeholder="Subject name" value="{{ !empty(old('subject_name')) ? old('subject_name') : $subject->subject_name }}" tabindex="1" maxlength="50">
                                            @if(!empty($errors->first('subject_name')))
                                                <p style="color: red;" >{{$errors->first('subject_name')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject_category_id" class="col-sm-2 control-label"><b style="color: red;">* </b>Subject Category : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('subject_category_id')) ? 'has-error' : '' }}">
                                            <select class="form-control select_2" name="subject_category_id" id="subject_category_id" tabindex="2">
                                                <option value="" {{ empty(old('subject_category_id')) ? 'selected' : '' }}>Select subject category</option>
                                                <option value="1" {{ !empty(old('subject_category_id')) ? (old('subject_category_id')== 1 ? 'selected' : '') : ($subject->category_id == 1 ? "selected" : "") }}>Language</option>
                                                <option value="2" {{ !empty(old('subject_category_id')) ? (old('subject_category_id')== 2 ? 'selected' : '') : ($subject->category_id == 2 ? "selected" : "") }}>Science</option>
                                                <option value="6" {{ !empty(old('subject_category_id')) ? (old('subject_category_id')== 6 ? 'selected' : '') : ($subject->category_id == 6 ? "selected" : "") }}>Extra Curricular</option>
                                                <option value="7" {{ !empty(old('subject_category_id')) ? (old('subject_category_id')== 7 ? 'selected' : '') : ($subject->category_id == 7 ? "selected" : "") }}>Moral</option>
                                            </select>
                                            @if(!empty($errors->first('subject_category_id')))
                                                <p style="color: red;" >{{$errors->first('subject_category_id')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">Description : </label>
                                        <div class="col-sm-10 {{ !empty($errors->first('description')) ? 'has-error' : '' }}">
                                            @if(!empty(old('description')))
                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description" style="resize: none;" tabindex="3">{{ old('description') }}</textarea>
                                            @else
                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description" style="resize: none;" tabindex="3">{{ $subject->description }}</textarea>
                                            @endif
                                            @if(!empty($errors->first('description')))
                                                <p style="color: red;" >{{$errors->first('description')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="box-header with-border">
                                        <h3 class="box-title" style="float: left;">Subject - Standard Assignment</h3>
                                        <p id="real_account_flag_message" style="color:blue;">&nbsp&nbsp&nbsp Select standards associated with the subject.</p>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label"><b style="color: red;">* </b>Options : </label>
                                        <div class="col-sm-10">
                                            @if(!empty($standards))
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 4%;">&emsp;&emsp;#</th>
                                                        <th style="width: 48%;">Standard</th>
                                                        <th style="width: 48%;">Maximum Sessions Per Week</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($standards as $index=>$standard)
                                                        <tr>
                                                            <td>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <input type="checkbox" class="standard" id="standard_checkbox_{{ $standard->id }}" value="{{ $standard->id }}" {{ in_array($standard->id, $subject->standards->pluck('id')->toArray()) ? "checked" : "" }}>
                                                                            <input type="hidden" id="standard_{{ $standard->id }}" name="standard[{{ $standard->id }}]" value="{{ $standard->id }}" {{ !in_array($standard->id, $subject->standards->pluck('id')->toArray()) ? "disabled" : "" }}>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="standard_checkbox_{{ $standard->id }}" class="form-control">{{ $standard->standard_name }}</label>
                                                                @if(!empty($errors->first('standard.'.$standard->id)))
                                                                    <p style="color: red;" >{{$errors->first('standard.'. $standard->id )}}</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="col-lg-12">
                                                                    <input type="text" name="no_of_session_per_week[{{ $standard->id }}]" id="no_of_session_per_week_{{ $standard->id }}" class="form-control number_only" value="{{ !empty($subject->standards->where('id', $standard->id)->first()->pivot->no_of_session_per_week) ? ($subject->standards->where('id', $standard->id)->first()->pivot->no_of_session_per_week) : "" }}" {{ !in_array($standard->id, $subject->standards->pluck('id')->toArray()) ? "disabled" : "" }} >
                                                                    @if(!empty($errors->first('no_of_session_per_week.'.$standard->id)))
                                                                        <p style="color: red;" >{{ $errors->first('no_of_session_per_week.'.$standard->id) }}</p>
                                                                    @endif
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
                            </div>
                            <div class="clearfix"> </div><br>
                            <div class="row">
                                <div class="col-xs-3"></div>
                                <div class="col-xs-3">
                                    <button type="reset" class="btn btn-default btn-block btn-flat">Clear</button>
                                </div>
                                <div class="col-xs-3">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat submit-button">Update</button>
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
@section('scripts')
    <script src="/js/registrations/subject-registration.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection