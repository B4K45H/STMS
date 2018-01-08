@extends('layouts.app')
@section('title', 'Subject List')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Subject
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Subject List</li>
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
                        <h3 class="box-title">Subjects</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">#</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($subjects))
                                            @foreach($subjects as $index => $subject)
                                                <tr>
                                                    <td>{{ $index + $subjects->firstItem() }}</td>
                                                    <td>{{ $subject->subject_name }}</td>
                                                    @if($subject->category_id == 1)
                                                        <td>Language</td>
                                                    @elseif($subject->category_id == 2)
                                                        <td>Science</td>
                                                    @elseif($subject->category_id == 6)
                                                        <td>Extra Curricular</td>
                                                    @elseif($subject->category_id == 7)
                                                        <td>Moral</td>
                                                    @else
                                                        <td>Error! Invalid</td>
                                                    @endif
                                                    <td>{{ !empty($subject->description) ? $subject->description : "Nil" }}</td>
                                                    <td>
                                                        <a href="{{ route('subject-details', ['id'=> $subject->id]) }}">
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