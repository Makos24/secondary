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
                        <a href="{{url('/settings')}}"><i class="fa fa-gears"></i>Settings</a>
                    </li>
            @endif
                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
            <div class="row">
            <div class="col-lg-10">
                <h1></h1>
<h2>{{$class}} Score Sheet</h2>
<form method="post" action="{{url('/results/postca1')}}" id="bulkform">
<a id="finb" href="{{url('/results/check')}}"></a>
 {{csrf_field()}}
<table class="table table-responsive">

    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>CA 1 Score</th>
      
    </tr>
    </thead>
    <tbody>
    @foreach($students as $k => $student)
    <tr>
        <td>{{++$k}}</td>
        <td width="150px"><input type="hidden" value="{{$student->student_id}}" name="id[]">
            {{$student->student_id}}
        </td>
        <td><input type="hidden" value="{{$student->getName()}}" name="names[]">
            {{$student->getName()}}
        </td><td width="120px"><input type="text" name="ca1[]" class="form-control" required></td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
<input type="hidden" value="{{$student->level}}" name="class">
<input type="hidden" value="{{$student->class}}" name="div">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="control-label">Term</label>
                            <select name="term" class="form-control" required>
                                <option ></option>
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
                                <option ></option>
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
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="control-label">Subject</label>
                            <select name="subject" class="form-control" required>
                                <option ></option>
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
                    
                </div>
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveB">Save Results</button>
</div>
</form>
</div>
</div>
                </div>
            </div>
        </div>
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
               
//				 $("#saveB").click( function(e){
//					 e.preventDefault();
//					 var form = $("#bulkform");
//					 var formData = form.serialize();
//					 var url = $("#finb").attr("href");
//					 $.ajax({
//							type: 'post',
//							url: url,
//							data: formData,
//							success: function(data){
//								console.log(data);
//								if(data == "exists"){
//									var c = confirm('This Result Exists do you wish to update it?');
//								if(c == true){
//									form.submit();
//								}
//									}else if(data == "not"){
//										form.submit();
//										}
//							},
//							error: function(data) {
//								console.log(data);
//							}
//						})
//
//					 })
//
					//console.log(ca1);
             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop