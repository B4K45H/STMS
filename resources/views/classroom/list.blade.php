@extends('layouts.app')
@section('title', 'Class Room List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Class Room
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Class Room List</li>
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
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Class Rooms</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 2%;">#</th>
                                            <th style="width: 20%;">Room No</th>
                                            <th style="width: 10%;">Class</th>
                                            <th style="width: 25%;">Incharge</th>
                                            <th style="width: 25%;">Strength</th>
                                            <th style="width: 18%;">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($classRooms))
                                            @foreach($classRooms as $index => $classroom)
                                                <tr>
                                                    <td>{{ $index + $classRooms->firstItem() }}</td>
                                                    <td>{{ $classroom->room_id }}</td>
                                                    <td>{{ $classroom->standard->standard_name }} - {{ $classroom->division->division_name }}</td>
                                                    <td>{{ $classroom->incharge->teacher_name }}</td>
                                                    <td>{{ $classroom->strength }}</td>
                                                    <td>
                                                        <a href="{{ route('class-room-combination-list', ['id'=> $classroom->id]) }}">
                                                            <button class="btn btn-block btn-default btn-flat">View</button>
                                                        </a>
                                                    </td>
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
                                        @if(!empty($classRooms))
                                            {{ $classRooms->links() }}
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