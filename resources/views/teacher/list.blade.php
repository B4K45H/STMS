@extends('layouts.app')
@section('title', 'Subject List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Teacher
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Teacher List</li>
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
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Teachers</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 2%;">#</th>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 10%;">Category</th>
                                            <th style="width: 35%;">Description</th>
                                            <th style="width: 10%;">No of session per week</th>
                                            <th style="width: 23%;">Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($teachers))
                                            @foreach($teachers as $index => $teacher)
                                                <tr>
                                                    <td>{{ $index + $teachers->firstItem() }}</td>
                                                    <td>{{ $teacher->name }}</td>
                                                    <td>{{ $teacher->category }}</td>
                                                    <td>{{ $teacher->description }}</td>
                                                    <td>{{ $teacher->no_of_session_per_week }}</td>
                                                    <td>{{ $teacher->level }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row  no-print">
                            <div class="col-md-12">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        @if(!empty($subjects))
                                            {{ $subjects->links() }}
                                        @endif
                                    </div>
                                </div>
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