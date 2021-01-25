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

        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- /. ROW  -->
                        <hr />
                        <!-- /. ROW  -->
                        <div class="container">
                            @include('class.newclass')
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <button type="button" class="btn btn-info" id="aClass">Add Class</button>
                                                <button type="button" class="btn btn-info" id="upClass">Add Class List</button>
                                                <button type="button" class="btn btn-info" id="export">Export</button>
                                                <button type="button" class="btn btn-info" id="print">Print</button>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">

                                                @if(isset($classes))
                                                    <table class="table table-bordered table-hover">
                                                        <thead style="font-weight: bold">
                                                        <td>S/No</td>
                                                        <td>Class Name</td>
                                                        <td>Section</td>
                                                        <td>Actions</td>
                                                        </thead>
                                                        @foreach($classes as $k => $class)
                                                            <tbody>
                                                            <tr>
                                                                <td>{{++$k}}</td>
                                                                <td>{{$class->name}}</td>
                                                                <td>{{$class->section}}</td>
                                                                <td><div class="action">
                                                                        <a href="{{url("/class/".$class->id."/edit")}}" class="fa fa-edit fa-2x" title="Edit Class Data">
                                                                        </a><a href="{{url("/class/".$class->id."/delete")}}" class="fa fa-recycle fa-2x" title="Delete Class" name="{{$class->id}}"></a></div></td>
                                                            </tr>

                                                            @endforeach
                                                            </tbody>
                                                    </table>
                                                    <div class="pager"></div>
                                                @endif
                                            </div>

                                        </div>
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
            $("#aClass").click( function () {
                $("#addClass").modal('show');
            })
        });
    </script>
    @stop
            <!-- /. PAGE INNER  -->
    <!-- /. WRAPPER  -->
@stop