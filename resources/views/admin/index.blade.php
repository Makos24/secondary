@extends('layouts.app')
@section('content')
    <div id="">
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li class="active-link">
                    <a href="{{url('/admin')}}" ><i class="fa fa-desktop "></i>Dashboard <span class="badge">main</span></a>
                </li>
                <li>
                    <a href="{{url('/students/all')}}"><i class="fa fa-users "></i>Students  <span class="badge">all</span></a>
                </li>
                <li class="col-md-offset-1">
                    <a href="{{url('/profiles')}}"><i class="fa fa-user "></i>Student Profiles</a>
                </li>
                <li class="col-md-offset-1">
                    <a href="{{url('/graduate')}}"><i class="fa fa-graduation-cap "></i>Graduate Students</a>
                </li>
                <li class="col-md-offset-1">
                    <a href="{{url('/promote')}}"><i class="fa fa-plus "></i>Promote Students</a>
                </li>
                <li class="col-md-offset-1">
                    <a href="{{url('/graduates')}}"><i class="fa fa-graduation-cap "></i>Alumni </a>
                </li>
                <li class="col-md-offset-1">
                    <a href="{{url('/inactive')}}"><i class="fa fa-ban "></i>Inactive Students</a>
                </li>
                <li>
                    <a href="{{url('/result')}}"><i class="fa fa-clipboard "></i>Results  <span class="badge">all</span></a>
                </li>
                <li class="col-md-offset-1">
                    <a href="{{url('/results/upload')}}"><i class="fa fa-upload "></i>Upload Student Results </a>
                </li>
                <li class="col-md-offset-1">
                    <a href="{{url('/collate')}}"><i class="fa fa-circle-o-notch "></i>Collate Student Results </a>
                </li>
                <li>
                    <a href="{{url('/subjects')}}"><i class="fa fa-file-text "></i>Subjects</a>
                </li>
                <li>
                    <a href="{{url('/staff')}}"><i class="fa fa-users"></i>Staff</a>
                </li>
                <li>
                    <a href="{{url('/termsettings')}}"><i class="fa fa-gears"></i>Settings</a>
                </li>

            </ul>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2> @if(session()->get('section') == "primary")
                                PRIMARY SECTION
                        @elseif(session()->get('section') == "secondary")
                                SECONDARY SECTION
                     @endif
                        ADMIN DASHBOARD
                    </h2>
                </div>
            </div>
            <!-- /. ROW  -->
            <hr />
            <!-- /. ROW  -->
            {{--<div class="col-lg-6 col-xs-6">--}}
                {{--<div class="col-lg-3 well">Students</div>--}}
                {{--</div><!-- /.info-box -->--}}

            <div style="margin: 20px">
            <div class="row text-center ">
                <div class="col-xs-4 well">
                    <span class="fa fa-users fa-3x pull-left pad-top"></span>
                    <h1 class="pull-left">Classes</h1>
                    <h1 class="badge">{{$c}}</h1>
                </div>
                <div class="col-xs-4 well">
                    <span class="fa fa-user fa-3x pull-left pad-top"></span>
                    <h1 class="pull-left">Students</h1>
                    <h1 class="badge">{{$snum}}</h1>
                </div>
                <div class="col-lg-4 col-xs-4 well ">
                    <span class="fa fa-male fa-3x pull-left pad-top"></span>
                    <h1 class="pull-left">Teachers</h1>
                    <h1 class="badge">{{$staff}}</h1>
                </div>
            </div>
            </div>
            <div class="row text-center pad-top">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/students/all')}}" >
                            <i class="fa fa-database fa-5x"></i>
                            <h4>Student Data</h4>
                        </a>
                    </div>


                </div>

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/profiles')}}" >
                            <i class="fa fa-users fa-5x"></i>
                            <h4>View Profiles</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/graduate')}}" >
                            <i class="fa fa-graduation-cap fa-5x"></i>
                            <h4>Graduation</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/result')}}" >
                            <i class="fa fa-file fa-5x"></i>
                            <h4>Results</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/promote')}}" >
                            <i class="fa fa-plus-square fa-5x"></i>
                            <h4>Promote</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/graduates')}}" >
                            <i class="fa fa-graduation-cap fa-5x"></i>
                            <h4>Alumni</h4>
                        </a>
                    </div>


                </div>
            </div>
            <!-- /. ROW  -->
            <!-- /. ROW  -->
            <div class="row text-center pad-top">

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/collate')}}" >
                            <i class="fa fa-bar-chart-o fa-5x"></i>
                            <h4>Reports</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/scoresheets')}}" >
                            <i class="fa fa-table fa-5x"></i>
                            <h4>Score Sheets</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/subjects')}}" >
                            <i class="fa fa-thumb-tack fa-5x"></i>
                            <h4>Subjects</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/staff')}}" >
                            <i class="fa fa-briefcase fa-5x"></i>
                            <h4>Staff Data</h4>
                        </a>
                    </div>

                </div>

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/admin/users')}}" >
                            <i class="fa fa-key fa-5x"></i>
                            <h4>Admin</h4>
                        </a>
                    </div>


                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/termsettings')}}" >
                            <i class="fa fa-gear fa-5x"></i>
                            <h4>Settings</h4>
                        </a>
                    </div>


                </div>
            </div>
            
            <div class="row text-center pad-top">
            	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="{{url('/results/manage')}}" >
                            <i class="fa fa-file fa-5x"></i>
                            <h4>Manage Results</h4>
                        </a>
                    </div>


                </div>
            </div>
            <!-- /. ROW  -->


        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>

<!-- /. WRAPPER  -->
@stop