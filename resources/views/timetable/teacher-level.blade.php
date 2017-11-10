@extends('layouts.app')
@section('title', 'Teacher Level Timetable')
@section('content')
<div class="content-wrapper">
     <section class="content-header">
        <h1>
            Teacher Level
            <small>Timetable</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Teacher Level</li>
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
                                            <label for="account_id" class="control-label">Teacher : </label>
                                            <select class="form-control" name="account_id" id="account_id" tabindex="3" style="width: 100%">
                                                <option value="">Select teacher</option>
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
                        <h3 class="box-title">Timetable for teacher : <b>Hema</b></h3>
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
                                            <td>LKG B / <i style="color: blue;">English</i></td>
                                            <td>II A / <i style="color: blue;">Social Science</i></td>
                                            <td>III B / <i style="color: blue;">Mathematics</i></td>
                                            <td>LKG B / <i style="color: blue;">Malayalam</i></td>
                                            <td>I B / <i style="color: blue;">Moral Science</i></td>
                                            <td>IV A / <i style="color: blue;">Science</i></td>
                                            <td>II A / <i style="color: blue;">P.T.</i></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tuesday</b></td>
                                            <td>II A / <i style="color: blue;">English</i></td>
                                            <td>I B / <i style="color: blue;">Science</i></td>
                                            <td>LKG B / <i style="color: blue;">Mathematics</i></td>
                                            <td>II A / <i style="color: blue;">G.K.</i></td>
                                            <td>III B / <i style="color: blue;">Malayalam</i></td>
                                            <td>II A / <i style="color: blue;">C.E.</i></td>
                                            <td>IV A / <i style="color: blue;">Social Scienc</i>e</td>
                                        </tr>
                                        <tr>
                                            <td><b>Wednesday</b></td>
                                            <td>II A / <i style="color: blue;">Science</i></td>
                                            <td>LKG B / <i style="color: blue;">Malayalam</i></td>
                                            <td>IV A / <i style="color: blue;">Mathematics</i></td>
                                            <td>III B / <i style="color: blue;">Social Science</i></td>
                                            <td>I B / <i style="color: blue;">Moral Science</i></td>
                                            <td>IV A / <i style="color: blue;">English</i></td>
                                            <td>II A / <i style="color: blue;">Hindi</i></td>
                                        </tr>
                                        <tr>
                                            <td><b>Thursday</b></td>
                                            <td>III B / <i style="color: blue;">Mathematics</i></td>
                                            <td>IV A / <i style="color: blue;">Science</i></td>
                                            <td>I B / <i style="color: blue;">English</i></td>
                                            <td>II A / <i style="color: blue;">Hindi</i></td>
                                            <td>II A / <i style="color: blue;">Malayalam</i></td>
                                            <td>III B / <i style="color: blue;">C.E.</i></td>
                                            <td>LKG B / <i style="color: blue;">Social Science</i></td>
                                        </tr>
                                        <tr>
                                            <td><b>Friday</b></td>
                                            <td>LKG B / <i style="color: blue;">Science</i></td>
                                            <td>IV A / <i style="color: blue;">Mathematics</i></td>
                                            <td>II A / <i style="color: blue;">English</i></td>
                                            <td>I B / <i style="color: blue;">Hindi</i></td>
                                            <td>II A / <i style="color: blue;">Malayalam</i></td>
                                            <td>III B / <i style="color: blue;">Moral Science</i></td>
                                            <td>III B / <i style="color: blue;">Social Science</i></td>
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