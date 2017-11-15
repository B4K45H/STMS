@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="/css/plugins/fullcalendar/fullcalendar.min.css">
@endsection
@section('content')
<style type="text/css">
#calendar td {
    text-align: center;
}
.fc-unthemed .fc-today {
  background-color: lightgoldenrodyellow;
}
</style>
<div class="content-wrapper no-print">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Teacher's</h3>

              <p>Timetable</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="{{ route('timetable-teacher') }}" class="small-box-footer">View Timetable <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>Student's</h3>

              <p>Timetable</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="{{ route('timetable-teacher') }}" class="small-box-footer">View Timetable <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ !empty($teacherCount) ? $teacherCount : 0 }}</h3>

              <p>Registered Teachers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('teacher-register') }}" class="small-box-footer">Add Teacher <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ !empty($classCount) ? $classCount : 0 }}</h3>

              <p>Classes</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('class-room-register') }}" class="small-box-footer">Add Class <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('scripts')
<!-- fullCalendar 2.2.5-->
<script src="/js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="/js/dashboard.js?rndstr={{ rand(1000,9999) }}"></script>
@endsection