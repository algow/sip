<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sinkron SPM</title>

    <!-- Styles -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel='stylesheet' type='text/css' property='stylesheet'>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" property='stylesheet'>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" property='stylesheet'>
    <link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet" property='stylesheet'>
    <link href="{{ asset('css/dataTables.bootstrap.css') }}" rel="stylesheet" property='stylesheet'>
    <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet" property='stylesheet'>
    <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet" property='stylesheet'>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" property='stylesheet'>
    {!! Charts::styles() !!}
    
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title"><i class="fa fa-location-arrow"></i> <span>Sinkron SPM</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>Navigasi</h3>
                            <ul class="nav side-menu">
                              @role('admin')
                                <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Beranda </a></li>
                                <li><a href="{{route('admin.filter')}}"><i class="fa fa-filter"></i> Filter </a></li>
                                <li><a href="{{route('satker.index')}}"><i class="fa fa-users"></i> Daftar Satker </a></li>								
                                <li class="active"><a><i class="fa fa-plus-square"></i> Rekam Penolakan <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: block">
                                        <li><a href="{{route('kontrak.create')}}">Kontrak</a></li>
                                        <li><a href="{{route('spm.create')}}">SPM</a></li>
                                    </ul>
                                </li>
                              @endrole
                              @role('front_office')
                                <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Beranda </a></li>
                                <li><a href="{{route('fo.filter')}}"><i class="fa fa-filter"></i> Filter </a></li>
                                <li><a href="{{route('fo.satker')}}"><i class="fa fa-users"></i> Daftar Satker </a></li>								
                                <li class="active"><a><i class="fa fa-expand"></i> Telusuri <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: block">
                                        <li><a href="{{route('fo.supplier')}}">SPM</a></li>
                                        <li><a href="{{route('fo.kontrak')}}">Kontrak</a></li>
                                    </ul>
                                </li>
                              @endrole
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                          @if (Auth::guest())
                            <li clas=''><a href="{{ url('/login') }}">Login</a></li>
                          @else
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out pull-right"></i>
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    </li>
                                </ul>
                            </li>
                          @endif
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @include('layouts._flash')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {!! $chart->html() !!}
                    <!--
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
            <!-- /page content -->

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/dashboard.js') }}"></script>
    <script src="{{ asset('admin/js/users/edit.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}
</body>
</html>