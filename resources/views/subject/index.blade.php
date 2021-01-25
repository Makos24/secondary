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
                    <li class="active-link">
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
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    @include('subject.modals.newsubject')
                    @include('subject.modals.editsubject')
@if(isset($subjects))
<div class="row">
    <div class="col-lg-11" >
        <div class="panel-heading">
            <div class="">
                <button type="button" class="btn btn-info" id="addSub">Add Subject</button>
                <!--<button type="button" class="btn btn-info" id="up">Import Subjects</button>
                <button type="button" class="btn btn-info" id="export">Export</button>
                <button type="button" class="btn btn-info" id="print">Print</button>-->
            </div>
            </div>
    <div class="table-responsive center-block">
    <table class="table table-bordered">
        <thead>
        <td>S/No.</td>
        <td>Subject Name</td>
        <td>School Section</td>
        <td>Sub Section</td>
        <td>Actions</td>
        </thead>
        <tbody>
        @foreach($subjects as $k => $subject)
            <tr>
                <td>{{++$k}}</td>
                <td>{{$subject->title}}</td>
                <td>{{$subject->section}}</td>
                <td>
                @if($subject->sub_section == 1)
                {{'Junior'}}
                @elseif($subject->sub_section == 2)
                {{'Senior'}}
                @else
                {{' '}}
                @endif
                </td>
                <td>
                    <div class="action">
                        <a href="#" name="{{$subject->id}}" id="edit" class="fa fa-edit fa-2x" title="Edit subject Data">
                        </a><a href="{{url("/subject/delete/".$subject->id)}}" id="sdelete" class="fa fa-trash-o fa-2x" title="Delete subject" ></a>
                       </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
        </div>
    </div>
</div>

        @endif
                        <!-- /. PAGE INNER  -->
                </div>
            </div>
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
@section('footer')
     <script type="text/javascript">
         jQuery(document).ready(function () {
             $("#addSub").click( function () {
                 $("#addSubject").modal('show');
             });
             $('tbody').delegate("#edit", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getSubject(val);
                 $("#editSubject").modal('show');
             })
             function getSubject(id) {
                 $.post({
                     type: 'post',
                     url : '{{url("/subjectJSON")}}',
                     data : {id: id},
                     success : function (data) {
						  //console.log(data);
                         $("#stitle").val(data.title);
                         $("#subject_id").val(data.id);
                         $("#section").val(data.section);
						 $("#sub_section").val(data.sub_section);
                     },
                     error : function (data) {
                         console.log(data);
                     },
                 });
             }

             $('tbody').delegate("#sdelete", 'click', function (e) {
                 var c = confirm('Are You sure you want to delete Subject');
				// e.preventDefault();
                 if(!c == true){
                     e.preventDefault();
                 }
             })




         });
     </script>   
        
@stop
    <!-- /. WRAPPER  -->
@stop