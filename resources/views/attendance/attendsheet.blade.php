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
            <div class="col-lg-12">
            
            <h2>{{$data['class'].' Attendance For '.$data['term'].' Term '.$data['session'].'/'.++$data['session'].' Session'}}</h2>
<table cellspacing="0" class="table table-bodered">
    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>Present</th>
        <th>Absent</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($res as $k => $r)
    <tr>
        <td>{{++$k}}</td>
        <td>{{$r['id']}}</td>
        <td>{{$r['name']}}</td>
        <td>{{$r['present']}}</td>
        <td>{{$r['total']-$r['present']}}</td>
        <td>{{$r['total']}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
             </div>
           <!-- /. PAGE INNER  -->
            </div>
                </div>
            </div>
        </div>
        
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
                 $("#addR").click(function () {
                     $("#addresult").modal('show');
                 })
				 
             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop