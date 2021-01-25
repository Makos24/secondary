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
                        <a href="{{url('/termsettings')}}"><i class="fa fa-gears"></i>Settings</a>
                    </li>

                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12 center-block">
    <div id="{{$levels=$results->groupBy('class')}}">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Export <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a target="_blank" href="{{url("/resultpdf/".$results[0]->class."/".$student->id."/".$results[0]->session)}}">To PDF</a></li>
                        {{--<li><a target="_blank" href="{{url("/resultexcel/".$r[1][0]->class."/".$student->id."/".$session)}}" >To Excel</a></li>--}}
                    </ul>
                </div>
            <a target="_blank" href="{{url("/classprint/".$results->first()->class."/".$student->id."/".$results->first()->session)}}" class="btn btn-primary">Print</a>
        @include('student.block')
        {{--<h4 style="margin-left: 320px">{{$student->student_class}} RESULTS</h4>--}}
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

    <!-- /. WRAPPER  -->
@stop