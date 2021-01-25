@extends('layouts.app')
@section('content')
<div>
<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    
        <li>
            <a href="{{url('/user/profile')}}"><i class="fa fa-users "></i>Profile</a>
        </li>
        <li>
            <a href="{{url('/student/academics')}}"><i class="fa fa-clipboard "></i>Academic History </a>
        </li>
        <li>
            <a href="{{url('/user/changepass')}}"><i class="fa fa-password "></i>Change Password</a>
        </li>
        <li>
            <a href="{{url('/logout')}}"><i class="fa fa-sign-out "></i>Logout</a>
        </li>
                </ul>
            </div>

        </nav>
<div id="page-wrapper" >
<div id="page-inner" class="col-lg-8">
    <div class="row">
        <div class="col-lg-8">
            <!-- /. ROW  -->
            <hr />
                                            <!-- /. ROW  -->
                <div class="container">
    <div class="row">
        <div class="col-lg-10 center-block">
            <div class="" id="{{$student = $all[4]}}">
                
                @include('student.block')
                @foreach($results as $k => $r)
                    @if(isset($results[$k][1][0]))
                    @include('student.show')
                    @endif
                @endforeach
                        <!-- /. ROW  -->
                <!-- /. ROW  -->
            </div>
                                            <!-- /. PAGE INNER  -->
                    </div>
    </div>
</div>
                            <!-- /. ROW  -->

                            <!-- /. ROW  -->
                        </div>
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
                    $('#apicture').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#auploadFile").change(function(){
            readURL(this);
        });

        $('#afrmPic').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                complete: function(xhr) {
					alert(xhr.responseJSON.info);
                    console.log(xhr.responseJSON.info);
                }
            })
            $("#auploadFile").val('');
        });
});
</script>
@stop
<!-- /. PAGE INNER  -->
<!-- /. WRAPPER  -->
@stop