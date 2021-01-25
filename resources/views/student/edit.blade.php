@extends('layouts.app')
@section('content')
    <div id="">
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="{{url('/admin')}}" ><i class="fa fa-desktop "></i>Dashboard <span class="badge">main</span></a>
                    </li>
                    <li class="active-link">
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
                        <div class="container">
                            <div class="row">
        <div class="col-lg-6 ">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Update Student Record</h3></div>
                <div class="panel-body">
                    <form class="form-vertical" role="form" method="post"
                          action="{{url("/student/".$student->first_name."/picture")}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="btn btn-default col-lg-offset-3 " style="padding: 8px 20px;">Browse File</label>
                            <input type="file" name="image" class="btn btn-default" id="image" style="display: none" required/>
                            @if ($errors->has('image'))
                                <span class="help-block">
<strong>{{ $errors->first('image') }}</strong>
</span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary col-lg-offset-3" style="padding: 7px 20px;">Save Picture</button>
                        <div class="clearfix"></div>

                    </form>
                    @if(Storage::disk('students')->has($student->first_name . '-' . $student->id . '.jpg'))
                        <div class="media">

                            <div class="col-md-6">
                                <img src="{{url("/student/".$student->first_name . "-" . $student->id . ".jpg/view")}}"
                                     alt="" class="img-responsive" />
                            </div>
                        </div>
                    @else
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" alt="{{$student->first_name}}" src="{{url("/student/mm.jpg/view")}}"
                                     width="120" height="120">
                            </a>
                        </div>
                    @endif
                        <div class="clearfix"></div>

                    <form class="form-vertical" role="form" method="post" action="/student/{{$student->id}}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="first_name" class="control-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                           value="{{old('first_name') ? : $student->first_name }}" required>
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                <strong>{{ $errors->first('first_name') }}</strong>
            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="last_name" class="control-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                           value="{{old('last_name') ? : $student->last_name }}" required>
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('other_name') ? ' has-error' : '' }}">
                                    <label for="other_name" class="control-label">Other Name</label>
                                    <input type="text" name="other_name" class="form-control" id="other_name"
                                           value="{{old('other_name') ? : $student->other_name }}" >
                                    @if ($errors->has('other_name'))
                                        <span class="help-block">
                <strong>{{ $errors->first('other_name') }}</strong>
            </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="location" class="control-label">Address</label>
    <textarea name="address" class="form-control" id="address" required>
        {{old('address') ? : $student->address}}</textarea>
                            @if ($errors->has('address'))
                                <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="control-label">Class</label>
                            <select name="level" class="form-control" required>
                                <option value="{{$student->level}}">
                                    @if($student->level > 3)
                                        {{"SS ".($student->level-3)}}
                                    @else
                                        {{"JSS ".$student->level}}
                                    @endif
                                </option>
                                <option value="1">JSS 1</option>
                                <option value="2">JSS 2</option>
                                <option value="3">JSS 3</option>
                                <option value="4">SS 1</option>
                                <option value="5">SS 2</option>
                                <option value="6">SS 3</option>
                            </select>
                            @if ($errors->has('level'))
                                <span class="help-block">
                <strong>{{ $errors->first('level') }}</strong>
            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                            <label for="class" class="control-label">Division (A,B,C)</label>
                            <input id="class" type="text" class="form-control" name="class"
                                   value="{{old('class') ? : $student->class }}" required>
                            @if ($errors->has('class'))
                                <span class="help-block">
                <strong>{{ $errors->first('class') }}</strong>
            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail</label>
                            <input id="email" type="text" class="form-control" name="email"
                                   value="{{old('email') ? : $student->email }}" >
                            @if ($errors->has('email'))
                                <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number" class="control-label">Phone Number</label>
                            <input id="phone_number" type="text" class="form-control" name="phone_number"
                                   value="{{old('phone_number') ? : $student->phone_number }}" >
                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                <strong>{{ $errors->first('phone_number') }}</strong>
            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">Update</button>
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