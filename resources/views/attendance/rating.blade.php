@extends('layouts.app')
@section('head')
	<style type="text/css">
		th.rotate {
    /* Something you can count on */
    height: 130px;
    width:45px;
    white-space: nowrap;
}

th.rotate > div {
    float:left;
    position: relative;
    width: 45px;
    top: -10px;
    font-size: 12px;
	font-weight:bold;
    -ms-transform:rotate(270deg); /* IE 9 */
    -moz-transform:rotate(270deg); /* Firefox */
    -webkit-transform:rotate(270deg); /* Safari and Chrome */
    -o-transform:rotate(270deg); /* Opera */
}
th.rotate1 > div {
    float:left;
    position: relative;
    width: 45px;
    top: 20px;
    height: 90px;
    font-size: 12px;
	font-weight:bold;
    -ms-transform:rotate(270deg); /* IE 9 */
    -moz-transform:rotate(270deg); /* Firefox */
    -webkit-transform:rotate(270deg); /* Safari and Chrome */
    -o-transform:rotate(270deg); /* Opera */
}
table tr{
    margin: 0;
    padding: 0;
}
.form-control {
	text-align:left;
	margin:0;
	padding:0;}
	</style>
@stop
@section('content')
    <div id="">
        
        <!-- /. NAV SIDE  -->
        
            <div id="page-inner">
            <div class="row">
            <div class="col-lg-12">
                <h1></h1>
<h2 style="text-align:center">{{$class}} Rating Sheet</h2>
<form method="post" action="{{url('/postrating')}}" id="bform">
<a id="finr" href="{{url('/checkrating')}}"></a>
 {{csrf_field()}}
<table style="margin: 0;" class="table table-bodered" cellspacing="0" cellpadding="0">

    <thead>
    <tr>
        <th>Student Name</th>
        <th class="rotate"><div>Punctuality</div></th>
        <th class="rotate"><div>Class Atendance</div></th>
        <th class="rotate"><div>Carrying out<br> Assignment</div></th>
        <th class="rotate"><div>Perseverance</div></th>
        <th class="rotate"><div>Self Control</div></th>
        <th class="rotate"><div>Self Confidence</div></th>
        <th class="rotate"><div>Endurance</div></th>
        <th class="rotate"><div>Respect</div></th>
        <th class="rotate"><div>Relationship<br> with others</div></th>
        <th class="rotate"><div>Leadership/Team<br> Spirit</div></th>
        <th class="rotate"><div>Honesty</div></th>
        <th class="rotate"><div>Neatness</div></th>
        <th class="rotate"><div>Responsibilty</div></th>
        <th class="rotate"><div>Sport & Athletics</div></th>
        <th class="rotate"><div>Manual Skills</div></th>
        <th class="rotate"><div>Participation in<br> Group Project</div></th>  
        <th class="rotate"><div>Merit</div></th>                 
    </tr>
    </thead>
    <tbody>
    @foreach($students as $k => $student)
    <tr>
        <td width="170px">
            <input type="hidden" value="{{$student->student_id}}" name="id[]" class="form-control">
            {{$student->name}}
        </td>
        
        <td>
        <select name="punctuality[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td><select name="attendance[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select></td>
        <td>
        	<select name="assignment[]" class="form-control" required>
            <option></option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            </select>
        </td>
        <td>
        	<select name="perseverance[]" class="form-control" required>
            <option></option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            </select>
        </td>
        <td>
        <select name="self_control[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="self_confidence[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="endurance[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="respect[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="relationship[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="leadership[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="honesty[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="neatness[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="responsibility[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="sports[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="skills[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="group_projects[]" class="form-control" required>
        <option></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <input type="number" name="merit[]" class="form-control" required>

        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>Student Name</th>
        <th class="rotate1"><div>Punctuality</div></th>
        <th class="rotate1"><div>Class Atendance</div></th>
        <th class="rotate1"><div>Carrying out<br> Assignment</div></th>
        <th class="rotate1"><div>Perseverance</div></th>
        <th class="rotate1"><div>Self Control</div></th>
        <th class="rotate1"><div>Self Confidence</div></th>
        <th class="rotate1"><div>Endurance</div></th>
        <th class="rotate1"><div>Respect</div></th>
        <th class="rotate1"><div>Relationship<br> with others</div></th>
        <th class="rotate1"><div>Leadership/Team<br> Spirit</div></th>
        <th class="rotate1"><div>Honesty</div></th>
        <th class="rotate1"><div>Neatness</div></th>
        <th class="rotate1"><div>Responsibilty</div></th>
        <th class="rotate1"><div>Sport & Athletics</div></th>
        <th class="rotate1"><div>Manual Skills</div></th>
        <th class="rotate1"><div>Participation in<br> Group Project</div></th>
        <th class="rotate1"><div>Merit</div></th>
    </tr>
    </tfoot>
</table>
<div class="row">
<input type="hidden" value="{{$student->level}}" name="class">
<input type="hidden" value="{{$student->class}}" name="div">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="control-label">Term</label>
                            <select name="term" class="form-control" required>
                                <option value=""></option>
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
                                <option value=""></option>
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

                </div>
                
                
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveRate">Save Rating</button>
</div>
</form>
</div>
</div>
                
            </div>
        </div>

     
@stop