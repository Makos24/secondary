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
@include('result.modals.editresultform')
    <div class="col-lg-12">
        <div class="container">

<div class="row">
    <div class="col-lg-11" id="{{$levels = $results->where('term',$term)->groupBy('class')}}">
        <a class="btn btn-info" target="_blank" href="{{url("/resulttpdf/".$student->id."/".$level."/".$term."/".$session)}}">To PDF</a></li>

        {{--<div class="btn-group">--}}
            {{--<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">--}}
                {{--Export <span class="caret"></span></button>--}}
            {{--<ul class="dropdown-menu" role="menu">--}}
                {{--<li>--}}{{--<li><a target="_blank" href="{{url("/resulttexcel/".$student->id."/".$level."/".$term."/".$session)}}" >To Excel</a></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        <a target="_blank" href="{{url("/termprint/".$student->id."/".$level."/".$term."/".$session)}}" class="btn btn-primary">Print</a>
        <a name="{{url("/termedit/".$student->id."/".$level."/".$term)}}" class="btn btn-primary" id="editTermResult" >Edit</a>
                    @include('student.block')
                    @foreach($levels as $k => $level)
                        @include('student.show')
                    @endforeach
                </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
</div>
</div>
</div>
        <!-- /. PAGE WRAPPER  -->
    </div>
</div>
    <!-- /. WRAPPER  -->
    @stop
     @section('footer')
         <script type="text/javascript">
		 	jQuery(document).ready(function(e) {
                $("#editTermResult").click(function () {
			$("#formdiv").empty();
			$.get(this.name, function(data){
				$.each(data, function(index, result){
					$("#formdiv").append('<tr><td>'+result.subject+'</td><td><input class="form-control" size="7" type="text" value="'+result.ca1+'" name="ca1[]" /></td><td><input class="form-control" size="7" type="text" value="'+result.ca2+'" name="ca2[]" /></td><td><input class="form-control" type="text" size="6" value="'+result.exam+'" name="exam[]"/></td><input type="hidden" value="'+result.subject_id+'" name="subject[]" /><input type="hidden" value="'+result.class+'" name="class[]" /><input type="hidden" value="'+result.term+'" name="term[]" /><input type="hidden" value="'+result.student_id+'" name="student_id[]" /></tr>');
					});
				});

                     $("#editResultForm").modal('show');

                 })
            });
		 </script>

      @stop
