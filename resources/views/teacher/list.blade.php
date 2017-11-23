@extends('layouts.app')
@section('title', 'Teacher List')
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
                                            <th style="width: 23%;">Experience Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($teachers))
                                            @foreach($teachers as $index => $teacher)
                                                <tr>
                                                    <td>{{ $index + $teachers->firstItem() }}</td>
                                                    <td>{{ $teacher->teacher_name }}</td>
                                                    @if($teacher->category_id == 1)
                                                        <td>Language</td>
                                                    @elseif($teacher->category_id == 2)
                                                        <td>Science</td>
                                                    @elseif($teacher->category_id == 3)
                                                        <td>Extra Curricular</td>
                                                    @else
                                                        <td>Moral</td>
                                                    @endif
                                                    <td>{{ !empty($teacher->description) ? $teacher->description : "Nil" }}</td>
                                                    <td>{{ $teacher->no_of_session_per_week }}</td>
                                                    @if($teacher->experience_level == 1)
                                                        <td>Level A</td>
                                                    @elseif($teacher->experience_level == 2)
                                                        <td>Level B</td>
                                                    @elseif($teacher->experience_level == 3)
                                                        <td>Level C</td>
                                                    @else
                                                        <td>Level D</td>
                                                    @endif
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
                                        @if(!empty($teachers))
                                            {{ $teachers->links() }}
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