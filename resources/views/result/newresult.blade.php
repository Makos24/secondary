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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h3>Add Student Result</h3></div>
            <div class="panel-body">
                <form class="form-vertical" role="form" method="post" action="{{url('/result/add')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_id" value="{{$student->student_id}}" />
                    <input type="hidden" name="class" value="{{$student->level}}" />
                    <input type="hidden" name="div" value="{{$student->class}}" />
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                <label for="full_name" class="control-label">Student Name</label>
                                <input type="text" name="full_name" class="form-control" id="full_name"
                                       value="{{old('full_name') ? : $student->getName() }}" required readonly>
                                @if ($errors->has('full_name'))
                                    <span class="help-block">
            <strong>{{ $errors->first('full_name') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('classN') ? ' has-error' : '' }}">
                                <label for="classN" class="control-label">Class</label>
                                <input type="text" name="classN" class="form-control" id="class"
                                       value="{{old('classN') ? : $student->getClass() }}" required readonly>
                                @if ($errors->has('classN'))
                                    <span class="help-block">
            <strong>{{ $errors->first('classN') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group{{ $errors->has('ca') ? ' has-error' : '' }}">
                                <label for="ca1" class="control-label">1ST CA Score</label>
                                <input type="number" name="ca1" class="form-control" id="ca1"
                                       value="{{old('ca1') }}" required>
                                @if ($errors->has('ca1'))
                                    <span class="help-block">
            <strong>{{ $errors->first('ca1') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group{{ $errors->has('ca') ? ' has-error' : '' }}">
                                <label for="ca2" class="control-label">2ND CA Score</label>
                                <input type="number" name="ca2" class="form-control" id="ca2"
                                       value="{{old('ca2') }}" required>
                                @if ($errors->has('ca2'))
                                    <span class="help-block">
            <strong>{{ $errors->first('ca2') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group{{ $errors->has('exam') ? ' has-error' : '' }}">
                                <label for="exam" class="control-label">Exam Score</label>
                                <input type="number" name="exam" class="form-control" id="exam"
                                       value="{{old('exam') }}" required>
                                @if ($errors->has('exam'))
                                    <span class="help-block">
            <strong>{{ $errors->first('exam') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>
                        

                                                </div>

                    <div class="row">
                    <div class="col-lg-4">
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                <label for="subject" class="control-label">Subject</label>
                                <select name="subject" class="form-control" required>
                                    <option value=""></option>
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}">{{$subject->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('subject'))
                                    <span class="help-block">
            <strong>{{ $errors->first('subject') }}</strong>
        </span>
                                @endif
                            </div>
                                                    </div>
                        <div class="col-lg-4">
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
                        <div class="col-lg-4">
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
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary pull-right">Save</button>
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