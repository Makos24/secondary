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
                        <a href="{{url('/settings')}}"><i class="fa fa-gears"></i>Settings</a>
                    </li>

                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
            <div class="row">
            <div class="col-lg-10">
                <h1></h1>
<h2 style="text-align:center">{{$data['class']}} BEHAVIOUR/APPEARANCE FOR {{$data['term']}} TERM {{$data['session']}}</h2>
<form method="post" action="{{url('/updatebehaviour')}}" id="bform">
<a id="fina" href="{{url('/checkattendance')}}"></a>
 {{csrf_field()}}
<table class="table table-responsive">

    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>Appearance</th>
        <th>Behaviour</th>       
    </tr>
    </thead>
    <tbody>
    @foreach($behaviours as $k => $behave)
    <tr>
        <td>{{++$k}}</td>
        <td width="150px">{{$behave['student_id']}}</td>
        <td width="250px">{{$behave['name']}}</td>
        <td>{{$behave['app']}}</td>
        <td>{{$behave['be']}}</td>
    </tr>
    @endforeach
    </tbody>
</table>    
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveBhv">Update Behaviour/Appearance</button>
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
              
//				 $("#saveAtt").click( function(e){
//					 e.preventDefault();
//					 var form = $("#bform");
//					 var formData = form.serialize();
//					 var url = $("#fina").attr("href");
//					 console.log(formData);
//					 $.ajax({
//							type: 'post',
//							url: url,
//							data: formData,
//							success: function(data){
//								console.log(data);
//								if(data == "exists"){
//									var c = confirm('This Attendance Exists do you wish to update it?');
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
             })
         </script>   
    @stop
     
@stop