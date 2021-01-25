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
                    <li>
                        <a href="{{url('/staff')}}"><i class="fa fa-users"></i>Staff</a>
                    </li>
                    <li class="active-link">
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
                @include('setting.modals.addlogo')
                    <!-- /. ROW  -->
                <h2>Application Settings</h2>
            <hr />
                    <form method="post" action="{{url('/settings')}}" class="form-vertical">
                        {{csrf_field()}}
                        <div class="col-lg-10">
                            <label for="title" class="control-label">NAME OF SCHOOL</label>
                            <input type="text" name="title" class="form-control"
                                  placeholder="Name of School Here" id="title"
                                   value="{{$setting[0]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="address" class="control-label">ADDRESS</label>
                            <textarea class="form-control" name="address">{{$setting[1]}}</textarea>
                        </div>
                        <div class="col-lg-10">
                            <label for="phone" class="control-label">PHONE NUMBER</label>
                            <input type="text" name="phone" class="form-control"
                                   placeholder="Phone Number" id="title"
                                   value="{{$setting[2]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="email" class="control-label">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="Email Address" id="title"
                                   value="{{$setting[3]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="footer" class="control-label">SCHOOL MOTTO</label>
                            <input type="text" name="footer" class="form-control"
                                   placeholder="School motto" id="title"
                                   value="{{$setting[4]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="icon" class="control-label">SCHOOL LOGO</label>
                            <div class="form-inline">
                            <input type="text" name="icon" class="form-control"
                                   placeholder="School logo" id="title"
                                   value="{{$setting[5]}}" size="79" disabled required>
                            <button type="button" class="btn btn-primary" id="icon">Upload Logo</button>
                            </div>
                        </div>
                        <div class="col-lg-3 pull-right pad-top">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Setting</button>
                        </div>
                        </div>
                    </form>
            </div>
                <!-- /. PAGE INNER  -->
        </div>
            <!-- /. PAGE WRAPPER  -->
    </div>
</div>
</div>
@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function (){
            $("#icon").click( function () {
                $("#iconprev").attr('src', '{{url("/logo/logo.jpg")}}');
                $("#addlogo").modal('show');
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#iconprev').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#logoFile").change(function(){
                readURL(this);
            });
            $('#frmLogo').on('submit', function(e) {
                e.preventDefault(); // prevent native submit
                $(this).ajaxSubmit({
                    complete: function(xhr) {
                        alert(xhr.responseJSON.info);
                        console.log(xhr.responseJSON.info);
                    }
                })
                $("#logoFile").val('');
            });

        });
    </script>
@stop
@stop