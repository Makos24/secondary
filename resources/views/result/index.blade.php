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
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    @include('result.modals.addresult')
                     @include('result.modals.view')
                     @include('result.modals.bulk')
                     @include('result.modals.attendance')
                     @include('result.modals.vattendance')
                     @include('result.modals.editattendance')
                     @include('result.modals.rating')
                     @include('result.modals.erating')
                     @include('result.modals.vrating')
                     @include('result.modals.behaviour')
                     @include('result.modals.ebehaviour')
                     @include('result.modals.vbehaviour')
                     @include('result.modals.ca1')
                     @include('result.modals.ca2')
                     @include('result.modals.ca12')
                     @include('result.modals.exam')
                     @include('result.modals.editca')
                     @include('result.modals.editresult')
            <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Find Results</h3></div>
                <div class="panel-body">
            <div class="row pull-right">
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Results <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="addR">Import Results</a>
                      </li>
                    <li><a id="ca1">Add 1ST CA</a></li>
                    <li><a id="ca2">Add 2ND CA</a></li>
                    <li><a id="ca12">Add 1ST and 2ND CA</a></li>
                    <li><a id="exam">Add Exam</a></li>
                    <li><a id="editcabtn">Edit CA</a></li>
                    <li><a id="editresultbtn">Edit Results</a></li>
                    <li><a id="bulkR">Add Results</a></li>
                    <li><a id="classR">View Result</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Attendance <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="Abtn">Add Attendance</a></li>
                    <li><a id="EAbtn">Edit Attendance</a></li>
                    <li><a id="VAbtn">View Attendance</a></li>
                </ul>
            </div>
                        @if(session()->get('section') == "primary")
                        <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Behaviour <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="Bbtn">Add Behaviour</a></li>
                    <li><a id="EBbtn">Edit Behaviour</a></li>
                    <li><a id="VBbtn">View Behaviour</a></li>
                </ul>
            </div>
                        @elseif(session()->get('section') == "secondary")
                        <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Rating <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="Rbtn">Add Rating</a></li>
                    <li><a id="ERbtn">Edit Rating</a></li>
                    <li><a id="VRbtn">View Rating</a></li>
                </ul>
            </div>
                   
                        @endif
                    </div>
                    <form class="form-inline" role="search" action="{{url('/searchresult')}}" method="">
                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            @if ($errors->has('student_id'))
                                <span class="help-block">
                    <strong>{{ $errors->first('student_id') }}</strong>
                </span>
                            @endif
                         
                            <input type="text" name="student_id" class="form-control" placeholder="Student ID">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                    </form>
                </div>
            </div>
                    </div>


                            @if(isset($all))

                                <div class="col-lg-12 center-block">
                                <div class="" id="{{$student = $all[4]}}">
                                    @include('student.block')
                                    @include('result.show')

                                    </div>
                                    </div>

                        @endif
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
				 $("#classR").click(function () {
                     $("#viewresult").modal('show');
                 })
				 $("#bulkR").click(function () {
                     $("#bulkresult").modal('show');
                 })
				 $("#ca1").click(function () {
                     $("#firstCa").modal('show');
                 })
				 $("#ca2").click(function () {
                     $("#secondCa").modal('show');
                 })
				 $("#ca12").click(function () {
                     $("#allCa").modal('show');
                 })
				 $("#exam").click(function () {
                     $("#Exam").modal('show');
                 })
				 $("#Abtn").click(function () {
                     $("#attendance").modal('show');
                 })
				 $("#VAbtn").click(function () {
                     $("#vattendance").modal('show');
                 })
				  $("#EAbtn").click(function () {
                     $("#editattendance").modal('show');
                 })
				 $("#Rbtn").click(function () {
                     $("#rating").modal('show');
                 })
				 $("#ERbtn").click(function () {
                     $("#erating").modal('show');
                 })
				 $("#VRbtn").click(function () {
                     $("#vrating").modal('show');
                 })
				 $("#Bbtn").click(function () {
                     $("#behaviour").modal('show');
                 })
				  $("#EBbtn").click(function () {
                     $("#ebehaviour").modal('show');
                 })
				  $("#VBbtn").click(function () {
                     $("#vbehaviour").modal('show');
                 })
				 $("#editcabtn").click(function () {
                     $("#editca").modal('show');
                 })
				 $("#editresultbtn").click(function () {
                     $("#editresult").modal('show');
                 })
				 
		$('#vlevel').on('change', function(e){
        console.log(e);
        var level = e.target.value;
 
        $.get('{{ url('subjectssecondary') }}/?level=' + level, function(data) {
            
            $('#vsubjects').empty();
			$('#vsubjects').append('<option></option>');
            $.each(data, function(index,subCatObj){
			 $('#vsubjects').append('<option value="' + subCatObj.id +'">' + subCatObj.title + '</option>');
            });
        });
    });
			
			
	$('#elevel').on('change', function(e){
        console.log(e);
        var level = e.target.value;
 
        $.get('{{ url('subjectssecondary') }}/?level=' + level, function(data) {
            
            $('#esubjects').empty();
			$('#esubjects').append('<option></option>');
            $.each(data, function(index,subCatObj){
			 $('#esubjects').append('<option value="' + subCatObj.id +'">' + subCatObj.title + '</option>');
            });
        });
    });			 
				 
			
	$('#ulevel').on('change', function(e){
        console.log(e);
        var level = e.target.value;
 
        $.get('{{ url('subjectssecondary') }}/?level=' + level, function(data) {
            
            $('#usubjects').empty();
			$('#usubjects').append('<option></option>');
            $.each(data, function(index,subCatObj){
			 $('#usubjects').append('<option value="' + subCatObj.id +'">' + subCatObj.title + '</option>');
            });
        });
    });					 
				 
				 
				 $("#saveR").click( function(e){
					 e.preventDefault();
					 var form = $("#Rform");
					 var formData = form.serialize();
					 var url = $("#find").attr("href");
					 console.log(formData);
					 $.ajax({
							type: 'post',
							url: url,
							data: formData,
							success: function(data){
								console.log(data);
								if(data == "exists"){
									var c = confirm('This Result Exists do you wish to update it?');
								if(c == true){
									form.submit();
								}
									}else if(data == "not"){
										form.submit();
										}
							},
							error: function(data) {
								console.log(data);
							}
						})
						
					 })
             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop