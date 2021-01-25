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
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h3>Upload Student Details</h3></div>
                                        <div class="panel-body">

                <form class="form-vertical" role="form" method="post"
                      action="{{url("/students/upload")}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                <label for="class" class="control-label">Class</label>
                                <select name="class" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">Nursery 1</option>
                                    <option value="2">Nursery 2</option>
                                    <option value="3">Nursery 3</option>
                                    <option value="4">Primary 1</option>
                                    <option value="5">Primary 2</option>
                                    <option value="6">Primary 3</option>
                                    <option value="7">Primary 4</option>
                                    <option value="8">Primary 5</option>
                                    <option value="9">Primary 6</option>
                                    <option value="10">JSS 1</option>
                                    <option value="11">JSS 2</option>
                                    <option value="12">JSS 3</option>
                                    <option value="13">SS 1</option>
                                    <option value="14">SS 2</option>
                                    <option value="15">SS 3</option>
                                </select>
                                @if ($errors->has('class'))
                                    <span class="help-block">
            <strong>{{ $errors->first('class') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('div') ? ' has-error' : '' }}">
                                <label for="div" class="control-label">Division (A,B,C)</label>
                                <input type="text" name="div" class="form-control" id="div" required>
                                @if ($errors->has('div'))
                                    <span class="help-block">
            <strong>{{ $errors->first('div') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="form-group{{ $errors->has('students') ? ' has-error' : '' }}">
                        <label for="students" class="control-label">Upload File</label>
                        <input type="file" name="students" class="btn btn-default" id="students" required>
                        @if ($errors->has('students'))
                            <span class="help-block">
            <strong>{{ $errors->first('students') }}</strong>
        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">Upload</button>
                    </div>
                </form>
                                        </div>
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