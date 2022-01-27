<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-dark" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar admin-sidebar-dark-primary elevation-4">
    <div class="brand-link">
        <img src="{{(isset($site['favicon']) && !empty($site['favicon']) && File::exists('uploads/favicon/'.$site['favicon'])) ? asset('uploads/favicon/'.$site['favicon']):asset('uploads/favicon/favicon.png')}}" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{(isset($site['site_title']) && !empty($site['site_title']) ) ? $site['site_title'] : "Invoxi"}}</span>
        </div>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{(isset(Auth::user()->avatar) && !empty(Auth::user()->avatar) && File::exists('uploads/profile/'.Auth::user()->avatar)) ? asset('uploads/profile/'.Auth::user()->avatar):asset('uploads/profile/default.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('qc/dashboard')}}" class="nav-link  {{ Request::is('qc/dashboard') ? 'active-admin' : null }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{__('all.dashboard')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('qc/call-center*') || Request::is('qc/call-center/all-call*')  ? 'menu-open ' : null }}">
                    <a href="#" class="nav-link {{ Request::is('qc/call-center/all-call*') || Request::is('qc/call-center/all-call*')  ? 'active-admin-1 admin-text-white' : null }}">
                        <i class="nav-icon fas fa-phone-alt"></i>
                        <p>
                            LDS-Acquisition
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge admin-white right">1</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item">
                            <a href="{{url('qc/call-center/qc-visit')}}" class="nav-link  {{ Request::is('qc/call-center/qc-visit*') ? 'active-admin' : null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('QC Visit')}}</p>
                            </a>
                        </li>

                    </ul>
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
