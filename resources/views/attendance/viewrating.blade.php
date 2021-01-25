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
td {
	border:1px solid grey;}
	</style>
@stop
@section('content')
    <div id="">
        
        <!-- /. NAV SIDE  -->
        
            <div id="page-inner">
            <div class="row">
            <div class="col-lg-12">
                <h1></h1>
<h2 style="text-align:center">{{$data['class']}} RATING FOR {{$data['term']}} TERM {{$data['session']}}</h2>
<form method="post" action="{{url('/postrating')}}" id="bform">
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
        <td width="130px">{{$rate->student_id}}</td>
        
        <td>{{$rate->punctuality}}
        </td>
        <td>{{$rate->attendance}}</td>
        <td>{{$rate->assignments}}
        	</td>
        <td>{{$rate->perseverance}}
        	</td>
        <td>{{$rate->self_control}}</td>
        <td>{{$rate->self_confidence}}</td>
        <td>{{$rate->endurance}}</td>
        <td>{{$rate->respect}}</td>
        <td>{{$rate->relationship}}</td>
        <td>{{$rate->leadership}}</td>
        <td>{{$rate->honesty}}</td>
        <td>{{$rate->neatness}}</td>
        <td>{{$rate->responsibility}}</td>
        <td>{{$rate->sports}}</td>
        <td>{{$rate->skills}}</td>
        <td>{{$rate->group_projects}}</td>
        <td>{{$rate->merit}}</td>
    </tr>
    @endforeach
    </tbody>
</table>

</div>
</div>
                
            </div>
        </div>

     
@stop