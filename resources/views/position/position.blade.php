
@extends('layouts.app')
@section('content')
<div id="">
<nav class="navbar-default navbar-side" role="navigation">
<div class="sidebar-collapse">
    <ul class="nav" id="main-menu">
        @if(Auth::user()->is_staff)
            <li>
                <a href="{{url('/staff/students')}}"><i class="fa fa-users "></i>Students</a>
            </li>
            <li>
                <a href="{{url('/result')}}"><i class="fa fa-clipboard "></i>Student Results </a>
            </li>
            <li>
                <a href="{{url('/collate')}}"><i class="fa fa-circle-o-notch"></i>Collate Results</a>
            </li>
            <li>
                <a href="{{url('/results/manageclass')}}"><i class="fa fa-circle-o-notch"></i>Manage Results</a>
            </li>
            <li>
                <a href="{{url('/staff/pwdchange')}}"><i class="fa fa-key"></i>Change Password</a>
            </li>
        @else
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
        @endif
    </ul>
</div>

</nav>
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
<div id="page-inner">
<!-- /. ROW  -->
<div class="container">
<div class="row">
    <div class="col-md-9">
        <h2>Collate Student Results</h2>
        <form class="form-vertical" role="form" method="post"
              action="{{url('/position')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include('partials.level')
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                        <label for="term" class="control-label">Term</label>
                        <select name="term" class="form-control" required>
                            <option value=""></option>
                            <option value="1">First Term</option>
                            <option value="2">Second Term</option>
                            <option value="3">Third Term</option>
                        </select>
                        @if ($errors->has('term'))
                            <span class="help-block">
            <strong>{{ $errors->first('term') }}</strong>
        </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                        <label for="session" class="control-label">Session</label>
                        <select name="session" class="form-control" required>
                            <option value=""></option>
                            @for($i = 2015; $i<= date('Y'); $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        @if ($errors->has('session'))
                            <span class="help-block">
            <strong>{{ $errors->first('session') }}</strong>
        </span>
                        @endif
                    </div>


                </div>
            </div>

            <div class="modal-footer">
                <input type="submit" value="Calculate" id="calc" class="btn btn-primary">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>

    </div>
</div>
</div>


<!-- /. ROW  -->

<!-- /. ROW  -->
</div>
<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>

@section('footer')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

        });
    </script>
    @stop

    <!-- /. WRAPPER  -->
@stop