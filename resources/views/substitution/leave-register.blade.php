@extends('layouts.app')
@section('title', 'Leave Registration')
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
                    </div><br>
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
                                            <select class="form-control select_2" name="teacher_id" id="teacher_id" tabindex="3" style="width: 100%">
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
                                    </div><br>
                                    <div class="form-group">
                                        <label for="leave_date" class="col-sm-2 control-label"><b style="color: red;">* </b>Leave Date : </label>
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
                                    <button type="submit" class="btn btn-primary btn-block btn-flat" tabindex="7">Submit</button>
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
        <div class="row no-print">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Upcoming Leave Records</h3>
                    </div>
                    <div class="box-body">
                        @if(!empty($leaves))
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 6%;">#</th>
                                        <th style="width: 32%;">Date</th>
                                        <th style="width: 32%;">Teacher Name</th>
                                        <th style="width: 15%;">Substitute</th>
                                        <th style="width: 15%;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaves as $index => $leave)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ Carbon\Carbon::parse($leave->leave_date)->format('d-m-Y') }}</td>
                                            <td>{{ $leave->teacher->teacher_name }}</td>
                                            <td>
                                                <div class="col-md-12">
                                                    <form action="{{ route('substitution-register') }}" method="get">
                                                        <input type="hidden" name="leave_teacher_id" value="{{ $leave->teacher_id }}">
                                                        <input type="hidden" name="sub_date" value="{{ Carbon\Carbon::parse($leave->leave_date)->format('d-m-Y') }}">
                                                        <button type="submit" class="btn btn-block btn-success btn-flat">
                                                            <i class="fa fa-recycle"> Substitute</i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-12">
                                                    <form action="{{route('substitution-leave-deletion')}}" method="post" id="leave_deletion_form">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="leave_id" value="{{ $leave->id }}">
                                                        <button type="button" id="delete_leave_btn" class="btn btn-block btn-danger btn-flat">
                                                            <i class="fa fa-trash"> Delete</i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="col-sm-5"></div>
                            <div class="col-sm-4">
                                <label>No records available to show!!</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
        <div class="modal modal-danger" id="confirm_leave_delete_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-exclamation-circle"></i> Confirm Delete
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure to delete the selected leave record and related substitution records?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn_leave_delete_modal_submit" class="btn btn-outline">Delete</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
</div>
@endsection
@section('scripts')
    <script src="/js/results/timetable.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection