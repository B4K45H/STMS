<!-- Logo -->
<div class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>STMS</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>STMS</b></span>
</div>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="/images/user/default_user.jpg" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ $currentUser->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="/images/user/default_user.jpg" class="img-circle" alt="User Image">
                        <p>
                            {{ $currentUser->name }}
                            <small>
                                {{ $currentUser->user_name }}
                            </small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ route('lockscreen') }}" class="btn btn-default btn-flat">Lockscreen</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('logout-action')}}" class="btn btn-default btn-flat">Logout</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>