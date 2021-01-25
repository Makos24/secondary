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
               
<h3 style="text-align:center">EDIT {{$data['class']}} BEHAVIOUR/APPEARANCE FOR {{$data['term']}} TERM {{$data['session']}}</h3>
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
        <td width="150px"><input value="{{$behave['student_id']}}" name="id[]" class="form-control" readonly></td>
        <td width="250px"><input value="{{$behave['name']}}" name="name[]" class="form-control" readonly></td>
        <td>
 		<select name="appearance[]" class="form-control" required>
        <option value="{{$behave['appearance']}}">{{$behave['app']}}</option>
        <option value="1">SMART</option>
        <option value="2">NEAT</option>
        <option value="3">GOOD</option>
        <option value="4">DIRTY</option>
        <option value="5">ROUGH</option>
        </select>	       
        </td>
        <td>
        <select name="behaviour[]" class="form-control" required>
        <option value="{{$behave['behaviour']}}">{{$behave['be']}}</option>
        <option value="1">WELL BEHAVED</option>
        <option value="2">GOOD CONDUCT</option>
        <option value="3">GOOD</option>
        <option value="4">SATISFACTORY</option>
        <option value="5">NAUGHTY</option>
        </select>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<input type="hidden" value="{{$data['class_id']}}" name="class">
<input type="hidden" value="{{$data['div']}}" name="div">
<input type="hidden" value="{{$data['term_id']}}" name="term">
<input type="hidden" value="{{$data['session']}}" name="session">   
               
               
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveBhv">Update Behaviour/Appearance</button>
</div>
</form>
</div>
</div>
                </div>
            </div>
        </div>

     
@stop