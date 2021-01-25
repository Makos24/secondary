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
                  
                     @include('admin.modals.newuser')
                      @include('admin.modals.edit')
            <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Search </h3></div>
                <div class="panel-body">
                    <div class="pull-right">
                        <button type="button" class="btn btn-info" id="newAdmin">Create New</button>
                        
                        <!--<button type="button" class="btn btn-info" id="subjectR">Subject Result</button>
                        <button type="button" class="btn btn-info" id="print">Print</button>-->
                    </div>
                    <form class="form-inline" role="search" action="{{url('/searchadmin')}}" method="">
                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                    <strong>{{ $errors->first('student_id') }}</strong>
                </span>
                            @endif
                            <label for="name" class="form-group">Name </label>
                            <input type="text" name="name" class="form-control " placeholder="">
                            <button type="submit" class="btn btn-default ">Search</button>
                        </div>
                    </form>
                </div>
            </div>

                @if(isset($users))

                    <div class="row">

                        <div class="col-md-10">
                            <table class="table table-bordered table-hover">
                                <thead style="font-weight: bold">
                                <td>S/No</td>
                                <td>Admin Name</td>
                                <td>Email</td>

                                <td title="{{$i = 1}}">Actions</td>
                                </thead>
                                @foreach($users as $user)
                                    <tbody>
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td><a href="#" name="{{$user->id}}">{{$user->name}}</a></td>
                                        <td>{{$user->email}}</td>

                                        <td><div class="action">
                                                <a href="{{url("/admin/".$user->id."/edit")}}" class="btn btn-info" title="Edit Admin Data" name="{{$user->id}}" id="aedit">Edit</a>
                                                <a href="{{url("/admin/".$user->id."/delete")}}" class="btn btn-danger" title="Delete Admin" id="adelete" name="{{$user->id}}">Delete</a></div></td>
                                    </tr>

                                    @endforeach
                                    </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="pager">  </div>


                @endif
                    </div>



                        <!-- /. PAGE INNER  -->
            </div>
                </div>
            </div>
        </div>
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
                 $("#newAdmin").click(function () {
                     $("#newadmin").modal('show');
                 })
				$('tbody').delegate("#aedit", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getAdmin(val);
                 $("#updateadmin").modal('show');
             })
             function getAdmin(id) {
                 $.post({
                     type: 'post',
                     url : '{{url("admin/adminJSON")}}',
                     data : {id: id},
                     success : function (data) {
                         $("#aname").val(data.name);
                         $("#aemail").val(data.email);
                         
                     },
                     error : function (data) {
                         console.log(data);
                     },
                 });
             }

             $('tbody').delegate("#adelete", 'click', function (e) {
                 //var c = confirm('Are You sure you want to delete User');
				 //e.preventDefault();
                 if(c = confirm('Are You sure you want to delete User')){
                     //e.preventDefault();
                 }else {
                     e.preventDefault();
                 }
             })
             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop