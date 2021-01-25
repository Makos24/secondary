@extends('layouts.app')
@section('head')
	<style type="text/css">
		th.rotate {
    /* Something you can count on */
    height: 100px;
    width:30px;
    white-space: nowrap;
}

th.rotate > div {
    float:left;
    position: relative;
    width: 30px;
    top: -10px;
    border-style: none;
    font-size: 12px;
	font-weight:bold;
    -ms-transform:rotate(270deg); /* IE 9 */
    -moz-transform:rotate(270deg); /* Firefox */
    -webkit-transform:rotate(270deg); /* Safari and Chrome */
    -o-transform:rotate(270deg); /* Opera */
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
<h2 style="text-align:center">EDIT {{$data['class']}} RATING FOR {{$data['term']}} TERM {{$data['session']}}</h2>
<form method="post" action="{{url('/updaterating')}}" id="bform">
<a id="finr" href="{{url('/checkrating')}}"></a>
 {{csrf_field()}}
<table class="table table-bodered" cellspacing="0" cellpadding="0">

    <thead>
    <tr>
        <th>Admission Number</th>
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
    @foreach($rating as $k => $rate)
    <tr>
        <td width="130px"><input value="{{$rate->student_id}}" name="id[]" class="form-control" readonly></td>
        
        <td>
        <select name="punctuality[]" class="form-control" required>
        <option value="{{$rate->punctuality}}">{{$rate->punctuality}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td><select name="attendance[]" class="form-control" required>
        <option value="{{$rate->attendance}}">{{$rate->attendance}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select></td>
        <td>
        	<select name="assignment[]" class="form-control" required>
            <option value="{{$rate->assignments}}">{{$rate->assignments}}</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            </select>
        </td>
        <td>
        	<select name="perseverance[]" class="form-control" required>
            <option value="{{$rate->perseverance}}">{{$rate->perseverance}}</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            </select>
        </td>
        <td>
        <select name="self_control[]" class="form-control" required>
        <option value="{{$rate->self_control}}">{{$rate->self_control}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="self_confidence[]" class="form-control" required>
        <option value="{{$rate->self_confidence}}">{{$rate->self_confidence}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="endurance[]" class="form-control" required>
        <option value="{{$rate->endurance}}">{{$rate->endurance}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="respect[]" class="form-control" required>
        <option value="{{$rate->respect}}">{{$rate->respect}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="relationship[]" class="form-control" required>
        <option value="{{$rate->relationship}}">{{$rate->relationship}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="leadership[]" class="form-control" required>
        <option value="{{$rate->leadership}}">{{$rate->leadership}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="honesty[]" class="form-control" required>
        <option value="{{$rate->honesty}}">{{$rate->honesty}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="neatness[]" class="form-control" required>
        <option value="{{$rate->neatness}}">{{$rate->neatness}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="responsibility[]" class="form-control" required>
        <option value="{{$rate->responsibility}}">{{$rate->responsibility}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="sports[]" class="form-control" required>
        <option value="{{$rate->sports}}">{{$rate->sports}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="skills[]" class="form-control" required>
        <option value="{{$rate->skills}}">{{$rate->skills}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <select name="group_projects[]" class="form-control" required>
        <option value="{{$rate->group_projects}}">{{$rate->group_projects}}</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        </td>
        <td>
        <input type="number" name="merit[]" value="{{$rate->merit}}" class="form-control" required>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
<input type="hidden" value="{{$data['class_id']}}" name="class">
<input type="hidden" value="{{$data['div']}}" name="div">
<input type="hidden" value="{{$data['term_id']}}" name="term">
<input type="hidden" value="{{$data['session']}}" name="session"> 
                    
                   

                </div>
                
                
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveRate">Update Rating</button>
</div>
</form>
</div>
</div>
                
            </div>
        </div>
     
@stop