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
                    <li class="col-md-offset-1 active-link">
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
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <div class="">

                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Search for Students to Promote</h3></div>
                    <div class="panel-body">
                        <form class="form-inline" role="search" action="{{url("/searchpromote")}}" method="">
                            <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
                                    <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                        <select name="class" class="form-control" required>
                                            <option value="">Select Class</option>
                                            @if(session()->get('section') == "primary")
                                                <option value="4">Primary 1</option>
                                                <option value="5">Primary 2</option>
                                                <option value="6">Primary 3</option>
                                                <option value="7">Primary 4</option>
                                                <option value="8">Primary 5</option>
                                                <option value="9">Primary 6</option>
                                            @elseif(session()->get('section') == "secondary")
                                                <option value="10">JSS 1</option>
                                                <option value="11">JSS 2</option>
                                                <option value="12">JSS 3</option>
                                                <option value="13">SS 1</option>
                                                <option value="14">SS 2</option>
                                                <option value="15">SS 3</option>
                                            @endif
                                        </select>
                                        @if ($errors->has('class'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                <button type="submit" class="btn btn-info">Load</button>
                            </div>
                            <button type="button" class="btn btn-info pull-right" id="pBtn">Promote By Class</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /. ROW  -->

    <!-- /. ROW  -->
    <div class="container">
        @include("student.modals.promoteoption")
        @include("student.modals.promote")
        <div class="row">
            <div class="col-md-9">

                @if(isset($students))
                    <table class="table table-bordered">
                        <thead>
                        <td width="20px">
                            <div class="checkbox-inline">
                                <input type="checkbox" name="all" class="checkbox-inline" id="all">
                                <label for="all" class="label label-primary">Check All</label>
                            </div>

                        </td>
                        <td>S/No</td>
                        <td>Student Name</td>
                        <td>Student ID No.</td>
                        <td>Class</td>
                        <td>Promote</td>
                        </thead>
                        <form action="{{url("/students/promote")}}" method="post" name="" id="promform">
                            {{csrf_field()}}
                        @foreach($students as $student)
                            <tr>
                                <td><input type="checkbox" name="names[]" value="{{$student->id}}"></td>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$student->getName()}}</td>
                                <td>{{$student->student_id}}</td>
                                <td>{{$student->getClass()}}</td>
                                <td><div class="action">
                                    </a><a href="#" name="{{$student->id}}" class="fa fa-chevron-up fa-2x" title="Promote Student" id="sprom"></a>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                    </table>
                    {{--<div class="pager">  {!! $students->appends(Request::get('search'))->links() !!}</div>--}}
                    @include('partials.level')
                    <button type="submit" id="promote" class="btn btn-primary">Promote Selected</button>
                    </form>
                @endif

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
@section('footer')
<script type="text/javascript">
jQuery(document).ready(function ($) {
    var all = $("input:checkbox#all");
    var c = $("input:checkbox:not(input:checkbox#all)");

    all.on('click', function () {
        console.log(all.prop("checked"));
        if(all.prop("checked") === true){
            c.attr("checked", "checked");
            //all.val(["off"]);
        }else{
            c.removeAttr("checked")
        }
    });
    $("#promote").on('click', function (e) {
        var id = [];
        //c.each( function () {
        id = $("input:checkbox:checked:not(input:checkbox#all)");
        data = id.serialize();
        if(data === ""){
            e.preventDefault();
            alert('No Student selected');
        }
    });

    $("#pBtn").click( function () {
        $("#promoteupload").modal('show');
    });
    $('tbody').delegate("#sprom", 'click', function (e) {
        e.preventDefault();
            $("#id").val($(this).attr('name'));
            $("#promoteopt").modal('show');
    })
	 

});
</script>
@stop
<!-- /. PAGE INNER  -->
</div>
</div>
</div>
</div>
        <!-- /. PAGE WRAPPER  -->
    </div>

    <!-- /. WRAPPER  -->
@stop