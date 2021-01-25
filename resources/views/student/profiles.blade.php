@extends('layouts.app')
@section('content')
    <div id="">
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="{{url('/admin')}}" ><i class="fa fa-desktop "></i>Dashboard <span class="badge">main</span></a>
                    </li>
                    <li>
                        <a href="{{url('/students/all')}}"><i class="fa fa-users "></i>Students  <span class="badge">all</span></a>
                    </li>
                    <li class="col-md-offset-1 active-link">
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
                        <a href="{{url("/subjects")}}"><i class="fa fa-file-text "></i>Subjects</a>
                    </li>
                    <li>
                        <a href="{{url("/staff")}}"><i class="fa fa-users"></i>Staff</a>
                    </li>
                    <li>
                        <a href="{{url("/termsettings")}}"><i class="fa fa-gears"></i>Settings</a>
                    </li>

                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
                            <div id="page-wrapper" >
                                <div id="page-inner">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><h3>Search for Students</h3></div>
                                                    <div class="panel-body">
                                                        <form class="form-inline" role="search" action="{{url("/searchprofile")}}" method="">
                                                            <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
                                                                @if ($errors->has('search'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('search') }}</strong>
                                    </span>
                                                                @endif
                                                                <label for="search" class="form-group"></label>
                                                                <input type="text" name="search" class="form-control input-lg" value="{{old('search')}}"
                                                                       placeholder="Enter Student's name or ID to search" size="50" >
                                                                <button type="submit" class="btn btn-default btn-lg">Search</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                @if(isset($students))
                                                @foreach($students as $student)
                                                @include('student.block')
                                                @endforeach


                                                        <!-- /. ROW  -->

                                                <!-- /. ROW  -->
                                            </div>
                                            <div class="pager">  {!! $students->render() !!}</div>
                                            @else
                                            <h3>No Profiles Found</h3>
                                            @endif
                                            <!-- /. PAGE INNER  -->
                                        </div>
                                        <!-- /. PAGE WRAPPER  -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /. PAGE INNER  -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>

    <!-- /. WRAPPER  -->
@stop