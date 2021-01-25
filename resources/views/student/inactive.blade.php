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

        <!-- /. NAV SIDE  -->
<div id="page-wrapper" >
<div id="page-inner">
<div class="row">
<div class="col-lg-12">
<!-- /. ROW  -->
<hr />
<!-- /. ROW  -->
<div class="container">
    @include('student.modals.profile')
    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row pull-right">
                        <button type="button" class="btn btn-info" id="export">Export</button>
                        <button type="button" class="btn btn-info" id="print">Print</button>
                    </div>
                    <div class="form-inline">
                        <form class="" role="search" action="{{url("/searchinactive")}}" method="">
                            <input type="text" name="search"
                                   placeholder="Enter text to search" class="form-control" >
                            <button type="submit" class="btn btn-default">Search</button>

                        </form>

                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">

                        @if(count($students))
        <table class="table table-bordered table-hover">
            <thead style="font-weight: bold">
            <td>S/No</td>
            <td>Student Name</td>
            <td>Class</td>
            <td>Phone Number</td>
            <td title="{{$i = 1}}">Actions</td>
            </thead>
            @foreach($students as $k => $student)
                <tbody>
                <tr>
                    <td>{{++$k}}</td>
                    <td><a href="#" name="{{$student->id}}" id="details">{{$student->getName()}}</a></td>
                    <td>{{$student->getClass()}}</td>
                    <td>{{$student->phone_number}}</td>
                    <td><div class="action">
                            <a href="{{url("/profile/".$student->id)}}" class="fa fa-file-text fa-2x" title="View Student Profile" ></a>
                            <a href="{{url("/activate/".$student->id)}}" class="fa fa-adn fa-2x" title="Activate Student" id="active" ></a>
                            <a href="{{url("/delete/".$student->id)}}" class="fa fa-trash-o fa-2x" title="Delete Student" id="delete" ></a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
        </table>
                            <div class="pager">  {!! $students->appends(Request::get('search'))->links() !!}</div>
                        @else
                            <h4>No Inactive Students Found!!</h4>
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

            <!-- /. PAGE INNER  -->
    <!-- /. WRAPPER  -->
@stop
@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('tbody').delegate("#details", 'click', function (e) {
                e.preventDefault();
                var val = $(this).attr("name");
                getProfile(val);
                $("#profile").modal('show');
            });
            function getProfile(id) {
                $.post({
                    type: 'post',
                    url : '/profileJSON',
                    data : {id: id},
                    success : function (data) {
                        console.log(data);
                        $("#name").html(data.name);
                        $("#id").html(data.student_id);
                        $("#clas").html(data.clas);
                        $("#email").html(data.email);
                    },
                    error : function (data) {
                        console.log(data);
                    },
                });
            }
            $('tbody').delegate("#active", 'click', function (e) {
                var c = confirm('Are You sure you want to activate Student');
                if(!c == true){
                    e.preventDefault();
                }
            })
            $('tbody').delegate("#delete", 'click', function (e) {
                var c = confirm('Are You sure you want to delete Student and all His/Her Records?');
                if(!c == true){
                    e.preventDefault();
                }
            })
        });
    </script>
@stop