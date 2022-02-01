<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-dark" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar admin-sidebar-dark-primary elevation-4">
    <div class="brand-link">
        <span class="brand-text font-weight-light">{{(isset($site['site_title']) && !empty($site['site_title']) ) ? $site['site_title'] : "Invoxi"}}</span>
        </div>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('admin/dashboard')}}" class="nav-link  {{ Request::is('admin/dashboard') ? 'active-admin' : null }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{__('all.dashboard')}}
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('admin/masters/tax*') || Request::is('admin/masters/payment-mode*') || Request::is('admin/masters/expense-category*')  ? 'menu-open' : null }}">
                    <a href="#" class="nav-link {{ Request::is('admin/masters/tax*') || Request::is('admin/masters/payment-mode*') || Request::is('admin/masters/expense-category*')  ? 'active-admin-1 admin-text-white' : null }}">
                        <i class="nav-icon fas fa-arrow-alt-circle-right"></i>
                        <p>Master Data
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge admin-white right">3</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('admin/customers')}}" class="nav-link  {{ Request::is('admin/customers*') ? 'active-admin' : null }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Projects
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/masters/expense-category')}}" class="nav-link  {{ Request::is('admin/masters/expense-category*') ? 'active-admin' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('all.expense_category')}}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('admin/masters/expense-sub-category')}}" class="nav-link  {{ Request::is('admin/masters/expense-sub-category*') ? 'active-admin' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense Subcategory</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('expense-report')}}" class="nav-link ">
                        <i class="nav-icon fas fa-signal"></i>
                        <p>
                            Expense Report
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('admin/expenses')}}" class="nav-link  {{ Request::is('admin/expenses*') ? 'active-admin' : null }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            {{__('all.expense')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin-logout')}}" class="nav-link ">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            {{__('all.signout')}}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
