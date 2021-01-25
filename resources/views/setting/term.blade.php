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
                        <a href="{{url('/termsettings')}}"><i class="fa fa-gears"></i>Settings</a>
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
                <h2>Term Settings</h2>
            <hr />
                    <form method="post" action="{{url('/termsettings')}}" class="form-vertical">
                        {{csrf_field()}}
                        
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="control-label">Term</label>
                            <select name="term" class="form-control" required>
                                <option value="{{old('term') ? : $term_setting->term}}">
                                @if($term_setting->term == 1)
                                {{'First Term'}}
                                @elseif($term_setting->term == 2)
                                {{'Second Term'}}
                                @elseif($term_setting->term == 3)
                                {{'Third Term'}}
                                @endif
                                </option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                            </select>
                            @if ($errors->has('term'))
                                <span class="help-block">
        <strong>{{ $errors->first('term') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="session" class="control-label">Session</label>
                            <select name="session" class="form-control" required>
                                <option value="{{old('session') ? : $term_setting->session}}">{{$term_setting->session}}</option>
                                @for($i = 2015; $i<= date('Y'); $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @if ($errors->has('session'))
                                <span class="help-block">
        <strong>{{ $errors->first('session') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>

                
                        <div class="col-lg-6">
                            <label for="close_date" class="control-label">Term Ends</label>
                            <input type="text" name="close_date" class="form-control" id="dateP"
                                   value="{{old('close_date') ? : $term_setting->close_date}}" required>
                        </div>
                       
                       <div class="col-lg-6">
                            <label for="resume_date" class="control-label">Next Term Begins</label>
                            <input type="text" name="resume_date" class="form-control" id="datePi"
                                   value="{{old('resume_date') ? : $term_setting->resume_date}}" required>
                        </div>
                        
                        <div class="col-lg-2 pull-right pad-top">
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
            $( "#dateP" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "dd-mm-yy",
            changeMonth:true,
            changeYear:true,
        });
		
		$( "#datePi" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "dd-mm-yy",
            changeMonth:true,
            changeYear:true,
        });
        });
    </script>
@stop
@stop