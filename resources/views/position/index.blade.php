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

        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- /. ROW  -->
                        <hr />
                        <!-- /. ROW  -->
                        <div class="container">
                            @include('position.modals.class')

                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

<div>
    <button type="button" class="btn btn-primary" id="pos">Collate Results</button>
    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            Export <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li><a target="_blank" @if(isset($data))
        href="{{url("/positionpdf/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
                   @else
                   href="#"
                   @endif
                >To PDF</a></li>
            <li><a target="_blank" @if(isset($data))
                   href="{{url("/positionexcel/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
                   @else
                   href="#"
                        @endif>To Excel</a></li>
        </ul>
    </div>
    <a target="_blank" class="btn btn-primary" id="print" @if(isset($data))
    href="{{url("/positionprint/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
        @else
        href="#"
            @endif>Print</a>
    <a target="_blank" class="btn btn-primary" id="print" @if(isset($data))
    href="{{url("/bulkterm/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
       @else
       href="#"
            @endif>All Term Reports</a>
    {{--<a target="_blank" class="btn btn-primary" id="print" @if(isset($data))--}}
    {{--href="{{url("/bulkclass/".$data['class']."/".$data['div']."/".$data['session'])}}"--}}
       {{--@else--}}
       {{--href="#"--}}
            {{--@endif>All Session Reports</a>--}}
</div>

            </div>


                @if(isset($allPos))
            <div class="panel-body center-block">
                <h1 style="text-align: center">{{\Portal\Models\Setting::where('key','title')->first()->value}} </h1>
                <h4 style="text-transform: uppercase; text-align: center;">{{$data['ttitle']." Examination Results For ".$data['ctitle'].$data['div'].
                " ".$data['session']."/".++$data['session']." Academic Session"}}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        
                        <thead>
                        <td>NAMES</td>
                        
                        <td>T.MRKS</td>
                        <td>AVERAGE</td>
                        <TD>POSITION</TD>
                        </thead>
                        @foreach($allPos as $k => $student)
                        <tr>
                            <td>{{strtoupper($student['name'])}}</td>
                        
                            <td>{{$student['total_score']}}</td>
                            <td>
                                @if(count($student['results']))
                                    {{round($student['total_score']/count($student['results']), 2)}}
                                @endif
                            </td>
                            <td>{{$student['position']}}</td>
                        </tr>

                        @endforeach
                    </table>
                </div>
            </div>
                @endif
        </div>
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
        </div>
    </div>
@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function () {
            $("#pos").click( function () {
                $("#position").modal('show');
            })
        });
    </script>
    @stop
            <!-- /. PAGE INNER  -->
    <!-- /. WRAPPER  -->
@stop