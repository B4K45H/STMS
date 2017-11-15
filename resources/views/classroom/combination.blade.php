@extends('layouts.app')
@section('title', 'Subject - Teacher Combination')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Subject - Teacher
            <small>Combination</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Combination List</li>
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
                        <h3 class="box-title">Subject - Teacher combination of class : {{ $className }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 2%;">#</th>
                                            <th style="width: 28%;">Class</th>
                                            {{-- <th style="width: 18%;">Division</th> --}}
                                            <th style="width: 35%;">Subject</th>
                                            <th style="width: 35%;">Teacher</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($combinations))
                                            @foreach($combinations as $index => $combination)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $className }}</td>
                                                    {{-- <td>{{ $combination->classRoom->division->division_name }}</td> --}}
                                                    <td>{{ $combination->subject->subject_name }}</td>
                                                    <td>{{ $combination->teacher->name }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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