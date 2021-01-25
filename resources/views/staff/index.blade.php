@extends('layouts.app')
@section('content')
    <div id="">
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
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
                    <li class="active-link">
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
                    @include('staff.modals.newstaff')
                    @include('staff.modals.edit')
                    @include('staff.modals.details')
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
        <div class="pull-right">

            <button type="button" class="btn btn-info" id="newStaff">
                <span class="fa fa-plus-square"></span>
                Add Staff</button>
            <!--<button type="button" class="btn btn-info" id="up">Import Staff List</button>
            <button type="button" class="btn btn-info" id="export">Export</button>
            <button type="button" class="btn btn-info" id="print">Print</button>-->
        </div>
        <div class="form-inline">
            <form class="" role="search" action="{{url('/searchstaff')}}" method="">
                <input type="text" name="search"
                       placeholder="Enter text to search" class="form-control" >
                <button type="submit" class="btn btn-default">Search</button>
            </form>

        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">

    @if(isset($staffs))
        <table class="table table-bordered table-hover">
            <thead style="font-weight: bold">
            <td>S/No</td>
            <td>Staff Name</td>
            <td>Email</td>
            <td>Phone Number</td>
            <td title="{{$i = 1}}">Actions</td>
            </thead>
            @foreach($staffs as $staff)
                <tbody>
                <tr>
                    <td>{{$i++}}</td>
                    <td><a id="sdetails" href="#" name="{{$staff->id}}">{{$staff->getName()}}</a></td>
                    <td>{{$staff->email}}</td>
                    <td>{{$staff->phone_number}}</td>
                    <td><div class="action">
                   <a href="#" class="fa fa-edit fa-2x"
                   title="Edit Staff Data" id="sedit" name="{{$staff->id}}"></a>
                   <a href="{{url("/staff/".$staff->id."/delete/")}}" class="fa fa-trash-o fa-2x"
                    title="Delete Staff" id="sdelete" name="{{$staff->id}}"></a></div></td>
                </tr>

                @endforeach
                </tbody>
        </table>
        <div class="pager">  {!! $staffs->appends(Request::get('search'))->links() !!}</div>
            @endif
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
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
                 $("#newStaff").click(function () {
                     $("#newstaff").modal('show');
                 })

				 $('tbody').delegate("#sdetails", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getStaff(val, 2);
                 $("#sdetails").modal('show');
             })

				$('tbody').delegate("#sedit", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getStaff(val, 1);
                 $("#updatestaff").modal('show');
             })
             function getStaff(id, op) {
                 $.post({
                     type: 'post',
                     url : '{{url("admin/staffJSON")}}',
                     data : {id: id},
                     success : function (data) {
						  console.log(data);
						  if(op === 1){
                        $("#sid").val(data.sid);
                         $("#sfname").val(data.fname);
                         $("#slname").val(data.lname);
                         $("#soname").val(data.oname);
                         $("#semail").val(data.email);
                         $("#sphone").val(data.phone);
                         $("#saddress").val(data.address);
						 $("#ssubject").val(data.sub);
						 $("#sclass").val(data.level);
						 $("#sdiv").val(data.div);
						  }else if(op === 2){
						$("#sname").html(data.name);
                         $("#sem").html(data.email);
                         $("#sph").html(data.phone);
                         $("#saddr").html(data.address);
						 $("#ssub").html(data.subject);
						 $("#scl").html(data.cl+data.div);



							  }

                     },
                     error : function (data) {
                         console.log(data);
                     },
                 });
             }

             $('tbody').delegate("#sdelete", 'click', function (e) {
                 var c = confirm('Are You sure you want to delete Staff Data');
                 if(!c == true){
                     e.preventDefault();
                 }
             })
             })
         </script>
    @stop
@stop
