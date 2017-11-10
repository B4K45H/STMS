@extends('layouts.app')
@section('title', 'Student Level Timetable')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Student Level
            <small>Timetable</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Student Level</li>
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
        <div class="row  no-print">
            <div class="col-md-12">
                <div class="box">
                    {{-- <div class="box-header">
                        <h3 class="box-title">Filter List</h3>
                    </div> --}}
                    <!-- /.box-header -->
                    <div class="box-header">
                        <form action="#" method="get" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-10 {{ !empty($errors->first('account_id')) ? 'has-error' : '' }}">
                                            <label for="account_id" class="control-label">Class : </label>
                                            <select class="form-control" name="account_id" id="account_id" tabindex="3" style="width: 100%">
                                                <option value="">Select class</option>
                                                @if(!empty($accounts) && (count($accounts) > 0))
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->id }}" {{ ((old('account_id') == $account->id ) || $accountId == $account->id) ? 'selected' : '' }}>{{ $account->account_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if(!empty($errors->first('account_id')))
                                                <p style="color: red;" >{{$errors->first('account_id')}}</p>
                                            @endif
                                            <div class="clearfix"></div><br>
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-2">
                                                <button type="reset" class="btn btn-default btn-block btn-flat"  value="reset" tabindex="10">Clear</button>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat submit-button" tabindex="4"><i class="fa fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /.form end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Timetable for class : <b>VI A</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 16%;"></th>
                                            <th style="width: 12%;"><b>1</b></th>
                                            <th style="width: 12%;"><b>2</b></th>
                                            <th style="width: 12%;"><b>3</b></th>
                                            <th style="width: 12%;"><b>4</b></th>
                                            <th style="width: 12%;"><b>5</b></th>
                                            <th style="width: 12%;"><b>6</b></th>
                                            <th style="width: 12%;"><b>7</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Monday</b></td>
                                            <td>English</td>
                                            <td>Social Science</td>
                                            <td>Mathematics</td>
                                            <td>Malayalam</td>
                                            <td>Moral Science</td>
                                            <td>Science</td>
                                            <td>P.T.</td>
                                        </tr>
                                        <tr>
                                            <td><b>Tuesday</b></td>
                                            <td>English</td>
                                            <td>Science</td>
                                            <td>Mathematics</td>
                                            <td>G.K.</td>
                                            <td>Malayalam</td>
                                            <td>C.E.</td>
                                            <td>Social Science</td>
                                        </tr>
                                        <tr>
                                            <td><b>Wednesday</b></td>
                                            <td>Science</td>
                                            <td>Malayalam</td>
                                            <td>Mathematics</td>
                                            <td>Social Science</td>
                                            <td>Moral Science</td>
                                            <td>English</td>
                                            <td>Hindi</td>
                                        </tr>
                                        <tr>
                                            <td><b>Thursday</b></td>
                                            <td>Mathematics</td>
                                            <td>Science</td>
                                            <td>English</td>
                                            <td>Hindi</td>
                                            <td>Malayalam</td>
                                            <td>C.E.</td>
                                            <td>Social Science</td>
                                        </tr>
                                        <tr>
                                            <td><b>Friday</b></td>
                                            <td>Science</td>
                                            <td>Mathematics</td>
                                            <td>English</td>
                                            <td>Hindi</td>
                                            <td>Malayalam</td>
                                            <td>Moral Science</td>
                                            <td>Social Science</td>
                                        </tr>
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