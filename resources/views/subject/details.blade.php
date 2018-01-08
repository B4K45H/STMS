@extends('layouts.app')
@section('title', 'Subject - Standard Combination')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Subject - Standard
            <small>Association</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Association List</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @if (Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="alert-message">
                <h4>
                  {{ Session::get('message') }}
                  <?php session()->forget('message'); ?>
                </h4>
            </div>
        @endif
        @if(empty($subject) || empty($subject->standards))
            <div class="alert alert-info" id="alert-message">
                <h4>
                  No associations available to show!
                </h4>
            </div>
        @else
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header"></div>
                        <!-- /.box-header -->
                        <div class="box-body">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="classname" class="col-sm-2 control-label"><b>Subject : </b></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="classname" placeholder="Class" value="{{ $subject->subject_name }}" readonly>
                                    </div>
                                    <label for="category" class="col-sm-2 control-label"><b>Category : </b></label>
                                    <div class="col-sm-4">
                                        @if($subject->category_id == 1)
                                            <input type="text" class="form-control" id="category" placeholder="Language" value="Language" readonly>
                                        @elseif($subject->category_id == 2)
                                            <input type="text" class="form-control" id="category" placeholder="Science" value="Science" readonly>
                                        @elseif($subject->category_id == 6)
                                            <input type="text" class="form-control" id="category" placeholder="Extra Curricular" value="Extra Curricular" readonly>
                                        @elseif($subject->category_id == 7)
                                            <input type="text" class="form-control" id="category" placeholder="Moral" value="Moral" readonly>
                                        @else
                                            <b>Error! Invalid</b>
                                        @endif
                                    </div>
                                </div>
                                <br><br>
                                <div class="form-group">
                                    <label for="classname" class="col-sm-2 control-label"><b>Description: </b></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="classname" value="{{ $subject->description }}" readonly>
                                    </div>
                                </div>
                                <br><br>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">#</th>
                                                <th style="width: 45%;">Standard</th>
                                                <th style="width: 45%;">No Of Session Per Week</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($subject->standards as $index => $standard)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $standard->standard_name }}</td>
                                                    <td>{{ $standard->pivot->no_of_session_per_week }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="clearfix"> </div><br>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-3">
                                        <form action="{{ route('subject-edit', ['subject_id' => $subject->id]) }}" method="get">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat submit-button">
                                                <i class="fa fa-edit"> Edit</i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-xs-3">
                                        <form action="{{route('subject-delete', ['subject_id' =>$subject->id])}}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" id="delete_leave_btn" class="btn btn-primary btn-block btn-flat submit-button">
                                                <i class="fa fa-trash"> Delete</i>
                                            </button>
                                        </form>
                                    </div>
                                    <!-- /.col -->
                                </div><br>
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