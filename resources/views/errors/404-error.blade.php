@extends('layouts.app')
@section('title', '404-Page Not Found')
@section('content')
<div class="content-wrapper no-print">
    <section class="content-header">
        <h1>
            404 Error Page
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">404 error</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                <p>
                    {{-- "You don't have the power to upset me" --}}<br>
                    <b><i>"Stay calm... We got it covered."</i></b>
                    <br>
                    You may return to <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> dashboard</a> or use options from the left side menu.
                </p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->
</div>
@endsection