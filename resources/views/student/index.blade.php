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
                    <li>
                        <a href="{{url('/admin')}}" ><i class="fa fa-desktop "></i>Dashboard <span class="badge">main</span></a>
                    </li>
                    <li class="active-link">
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
@endif
                </ul>
            </div>

        </nav>

        <!-- /. NAV SIDE  -->

                            <!-- /. NAV SIDE  -->
                            <div id="page-wrapper" >
                                <div id="page-inner">
                                    <div class="row">
                                        <div class="col-lg-11">
                                            <!-- /. ROW  -->
                                            <hr />
                                            <!-- /. ROW  -->
                <div class="container">
                    @include('student.modals.newstudent')
                    @include('student.modals.editstudent')
                    @include('student.modals.uploadstudents')
                    @include('student.modals.profile')
                    @include('student.modals.excel')
                    @include('student.modals.pdf')
                    @include('student.modals.export')
                    @include('student.modals.biodata')
                    @include('student.modals.classsheet')
                    @include('student.modals.addmany')



                    <div class="row" style="margin: 10px;">

                        <div class="pull-right">
                            <button type="button" class="btn btn-primary" id="add">Add Student</button>
                            <button type="button" class="btn btn-primary" id="addM">Add Many</button>
                            <button type="button" class="btn btn-primary" id="up">Import Students</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    Export <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a target="_blank" id="pdfBtn" href="#">Subject Score Sheet</a></li>
                                    <li><a target="_blank" id="classBtn" href="#">Class Score Sheet</a></li>
                                    <li><a target="_blank" href="#" id="excelBtn" >To Excel</a></li>
                                </ul>
                            </div>
                            <a target="_blank" class="btn btn-primary" id="bioData">Bio Data</a>
                        </div>
                    </div>


        <div>


        <table class="table table-bordered" id="admin-students-table">
            <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Parents Mobile</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Parents Mobile</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var oTable = $('#admin-students-table').DataTable({
            saveState: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url('students/data')}}',
                data: function (d) {
                    d.gender = $('select[name=genders]').val();
                    d.level = $('select[name=level]').val();
                    d.div = $('select[name=div]').val();
                }
            } ,
            columns: [
                { data: 'student_id'},
                { data: 'name'},
                { data: 'gender'},
                { data: 'class'},
                { data: 'dad_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            columnDefs: [
                { "width": "15%", "targets": 5 }
            ]
        });



        var c;

        $("#up").click(function () {
            $('#studentupload').modal('show');
        });
        $(document).on('click', "#btn-editStudent", 'click', function (e) {
            e.preventDefault();
            $("#idHid").val($(this).data('student_id'));
            if($(this).data('image')){
                var dee = $(this).data('image');
                $("#picture").attr('src', '{{url("/")}}'+"/student/view/"+dee);
            }else{
                $("#picture").attr('src', '{{url("/student/mm.jpg/view")}}');
            }
            $("#estudent_id").val($(this).data('student_id'));
            $("#efirst_name").val($(this).data('first_name'));
            $("#elast_name").val($(this).data('last_name'));
            $("#eother_name").val($(this).data('other_name'));
            $("#eaddress").html($(this).data('address'));
            $("#eclass").val($(this).data('class'));
            $("#elevel").val($(this).data('level'));
            //$("#elevel").selected($(this).data('level'));
            $("#eemail").val($(this).data('email'));
            $("#datepicker").val($(this).data('dob'));
            $("#egender").val($(this).data('gender'));
            //$("#egender").selected($(this).data('gender'));
            $("#ereligion").val($(this).data('religion'));
            //$("#ereligion").selected($(this).data('religion'));
            $("#edad_number").val($(this).data('dad_number'));
            $("#emum_number").val($(this).data('mum_number'));

            $('#editStudent').modal('show');
        });
        $('tbody').delegate("#details", 'click', function (e) {
            e.preventDefault();

            getProfile();
			console.log($("#picture").attr('src'));
            $("#profile").modal('show');
			
        });


        $('tbody').delegate("#deact", 'click', function (e) {
            var c = confirm('Are You sure you want to deactivate Student');
            if(!c == true){
                e.preventDefault();
            }
        });
		$("#bioData").click(function (e) {
            e.preventDefault();
            $("#biodata").modal('show');
        });
		$("#addM").click(function (e) {
            e.preventDefault();
            $("#addmany").modal('show');
        });
        $("#pdfBtn").click(function (e) {
            e.preventDefault();
            $("#pdf").modal('show');
        });
        $("#excelBtn").click(function (e) {
            e.preventDefault();
            $("#excel").modal('show');
        });
        $("#printBtn").click(function (e) {
            e.preventDefault();
            $("#print").modal('show');
        });
		$("#classBtn").click(function (e) {
            e.preventDefault();
            $("#classSheet").modal('show');
        });
        $( "#datepicker" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
        });
        $( "#dobdatepicker" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
        });
        $( "#regdatepicker" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#picture').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#uploadFile").change(function(){
            readURL(this);
        });

        $('#frmPic').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                complete: function(xhr) {
					alert(xhr.responseJSON.info);
                    console.log(xhr.responseJSON.info);
                }
            })
            $("#uploadFile").val('');
        });
//        $('#eStd').on('submit', function(e) {
//            e.preventDefault(); // prevent native submit
//            $(this).ajaxSubmit({
//                success: function(xhr) {
//                    //alert(xhr.responseJSON.info);
//                    console.log(xhr);
//                }
//            })
//        });




});
</script>
@stop
<!-- /. PAGE INNER  -->
<!-- /. WRAPPER  -->
@stop