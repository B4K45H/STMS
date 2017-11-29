<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/user/default_user.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $currentUser->name }}</p>
                <a href="{{ Request::is('my/profile') ? '#' : route('user-profile') }}"><i class="fa fa-hand-o-right"></i> View Profile</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview {{ Request::is('dashboard')? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if($currentUser->role == 0)
                <li class="treeview {{ Request::is('user/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span>Users</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('user/register')? 'active' : '' }}">
                            <a href="{{ route('user-register') }}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('user/list')? 'active' : '' }}">
                            <a href="{{ route('user-list') }}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>   
                    </ul>
                </li>
            </li>
            @endif
            @if($currentUser->role == 0 || $currentUser->role == 1)
                <li class="treeview {{ Request::is('timetable/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span>Timetable</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('timetable/teacher')? 'active' : '' }}">
                            <a href="{{ route('timetable-teacher') }}">
                                <i class="fa fa-circle-o"></i> Teacher Level
                            </a>
                        </li>
                        <li class="{{ Request::is('timetable/student')? 'active' : '' }}">
                            <a href="{{ route('timetable-student') }}">
                                <i class="fa fa-circle-o"></i> Student Level
                            </a>
                        </li>
                        <li class="{{ Request::is('timetable/settings')? 'active' : '' }}">
                            <a href="{{ route('timetable-settings') }}">
                                <i class="fa fa-circle-o"></i> Settings
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('substitution/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-recycle"></i>
                        <span>Substitution System</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('substitution/leave/register')? 'active' : '' }}">
                            <a href="{{ route('substitution-leave-register') }}">
                                <i class="fa fa-circle-o"></i> Leave Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('substitution/register')? 'active' : '' }}">
                            <a href="{{ route('substitution-register') }}">
                                <i class="fa fa-circle-o"></i> Substitution
                            </a>
                        </li>
                        <li class="{{ Request::is('substitution/temp/timetable')? 'active' : '' }}">
                            <a href="{{ route('substituted-timetable') }}">
                                <i class="fa fa-circle-o"></i> Substituted Timetable
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('subject/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>Subject</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('subject/register')? 'active' : '' }}">
                            <a href="{{ route('subject-register') }}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('subject/list')? 'active' : '' }}">
                            <a href="{{ route('subject-list') }}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('teacher/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-user-md"></i>
                        <span>Teacher</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('teacher/register')? 'active' : '' }}">
                            <a href="{{ route('teacher-register') }}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('teacher/list')? 'active' : '' }}">
                            <a href="{{ route('teacher-list') }}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('classroom/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-group"></i>
                        <span>Class</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('classroom/register')? 'active' : '' }}">
                            <a href="{{ route('class-room-register') }}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('classroom/list')? 'active' : '' }}">
                            <a href="{{ route('class-room-list') }}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </section>
<!-- /.sidebar -->
</aside>