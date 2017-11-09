<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $currentUser->image }}" class="img-circle" alt="User Image">
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
            @if($currentUser->role == 0 || $currentUser->role == 1 || $currentUser->role == 2)
                <li class="treeview {{ Request::is('sale/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-arrow-up"></i>
                        <span>Sales</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('sale/register')? 'active' : '' }}">
                            <a href="{{route('sale-register')}}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('sale/list')? 'active' : '' }}">
                            <a href="{{route('sale-list')}}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('purchase/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-arrow-down"></i>
                        <span>Purchase</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('purchase/register')? 'active' : '' }}">
                            <a href="{{route('purchase-register')}}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('purchase/list')? 'active' : '' }}">
                            <a href="{{route('purchase-list')}}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('voucher/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-tags"></i>
                        <span>Vouchers</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('voucher/register')? 'active' : '' }}">
                            <a href="{{route('voucher-register')}}">
                                <i class="fa fa-circle-o"></i> Register
                            </a>
                        </li>
                        <li class="{{ Request::is('voucher/list/*')? 'active' : '' }}">
                            <a href="{{route('voucher-list')}}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ (Request::is('statement/*'))? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-dollar"></i>
                        <span>Statements</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('statement/account-statement')? 'active' : '' }}">
                            <a href="{{route('account-statement')}}">
                                <i class="fa fa-circle-o"></i> Account Statement
                            </a>
                        </li>
                        <li class="{{ Request::is('statement/sale')? 'active' : '' }}">
                            <a href="{{route('sale-statement')}}">
                                <i class="fa fa-circle-o"></i> Sales Statement
                            </a>
                        </li>
                    </ul>

                </li>
                <li class="treeview {{ Request::is('account/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>Accouts</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('account/register')? 'active' : '' }}">
                            <a href="{{route('account-register')}}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('account/list')? 'active' : '' }}">
                            <a href="{{route('account-list')}}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('product/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-industry"></i>
                        <span>Products</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('product/register')? 'active' : '' }}">
                            <a href="{{route('product-register')}}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('product/list')? 'active' : '' }}">
                            <a href="{{route('product-list') }}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('product-category/*')? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-flag-o"></i>
                        <span>Product Category</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('product-category/register')? 'active' : '' }}">
                            <a href="{{route('product-category-register')}}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('product-category/list')? 'active' : '' }}">
                            <a href="{{route('product-category-list') }}">
                                <i class="fa fa-circle-o"></i> List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ Request::is('hr/employee/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-male"></i>
                        <span>Employees</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('hr/employee/register')? 'active' : '' }}">
                            <a href="{{route('employee-register')}}">
                                <i class="fa fa-circle-o"></i> Registration
                            </a>
                        </li>
                        <li class="{{ Request::is('hr/employee/list')? 'active' : '' }}">
                            <a href="{{route('employee-list')}}">
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