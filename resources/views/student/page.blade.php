@extends('layouts.app')
@section('content')
<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    
        <li>
            <a href="{{url('/user/profile')}}"><i class="fa fa-users "></i>Profile</a>
        </li>
        <li>
            <a href="{{url('/student/academics')}}"><i class="fa fa-circle-o "></i>Academic History </a>
        </li>
        <li>
            <a href="{{url('/user/changepass')}}"><i class="fa fa-admin "></i>Change Password</a>
        </li>
        <li>
            <a href="{{url('/logout')}}"><i class="fa fa-sign-out "></i>Logout</a>
        </li>
                </ul>
            </div>

        </nav>
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-lg-8">
            <!-- /. ROW  -->
            <hr />
                                            <!-- /. ROW  -->
                <div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Student Profile</div>
                <div class="panel-body">
                <div class="row">
                <div class="col-lg-6">
                   <div class="col-md-6">
                  
                   <img id="spicture" 
                   @if(!Auth::user()->image)
                   src="{{url("/student/mm.jpg/view")}}"
                   @else 
                    src="{{url("/student/view/".Auth::user()->image)}}"
                   @endif
                   class="media-object" width="140px" height="150px">
                   </div>
                    <form id="sfrmPic" enctype="multipart/form-data" name="picForm" method="post"
                    action="{{url("/upload/picture")}}">
                        {{csrf_field()}}
                        <input type="hidden" id="idHid" name="id" value="{{Auth::user()->student_id}}">
                        <input type="file" class="form-group" id="suploadFile" name="image" required>
                        <button type="submit" class="btn btn-primary" id="savePic">Update Image</button>
                    </form>
                </div>
                </div>
                <br>
                    <form class="form-vertical" role="form" method="POST" action="">
                        {{ csrf_field() }}
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" class="col-lg-6 form-control" id="name"
                               value="{{old('name') ? : Auth::user()->getName() }}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                        
					<div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="gDIv">
                                <label for="gender" class="control-label">Gender</label>
                                <select name="gender" id="egender" class="form-control" >
                                    <option value=""></option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                                <span class="help-block" id="gError"><strong></strong></span>
                            </div>
                        </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email"
                           value="{{old('email') ? : Auth::user()->email }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
            </div><div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Phone Number</label>
                    <input id="phone_number" type="text" class="form-control" name="phone_number"
                           value="{{old('phone_number') ? : Auth::user()->phone_number }}">

                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                    @endif
            </div>

                        <div class="row">
                        <div class="col-lg-12">
                        <div class="form-group" id="addDiv">
                            <label for="location" class="control-label">Address</label>
                            <textarea name="address" class="form-control" id="eaddress" required>
                            {{Auth::user()->address}}
                            </textarea>
                            <span class="help-block" id="addError"><strong></strong></span>
                        </div>
                        </div>
                    </div>

                        

                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Update
                                </button>
                            </div>
                        </div>
                    </form>
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
@section('footer')
<script>
jQuery(document).ready(function(e) {
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#spicture').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#suploadFile").change(function(){
            readURL(this);
        });

        $('#sfrmPic').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                complete: function(xhr) {
					alert(xhr.responseJSON.info);
                    console.log(xhr.responseJSON.info);
                }
            })
            $("#suploadFile").val('');
        });
});
</script>
@stop
<!-- /. PAGE INNER  -->
<!-- /. WRAPPER  -->
@stop