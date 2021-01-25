@extends('layouts.app')
@section('head')
	<style>
		select {
			text-align:left;
			font-size:10px;}
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
<h2 style="text-align:center">Add Multiple Student Records </h2>
<form method="post" action="{{url('/students/postmany')}}" id="bform">
 {{csrf_field()}}
<table class="table table-bodered" cellspacing="0" cellpadding="0">

    <thead>
    <tr>
    	<th>S/N</th>
        <th>Admission Number</th>
        <th ><div>First Name</div></th>
        <th ><div>Last Name</div></th>
        <th ><div>Other Name</div></th>
        <th ><div>Class</div></th>
        <th ><div>Division</div></th>
        <th ><div>Religion</div></th>
        <th ><div>Gender</div></th>
        <th ><div>Date of Birth</div></th>
        <th ><div>Father's Mobile</div></th>
        <th ><div>Mother's Mobile</div></th>
        <th ><div>Address</div></th>
                        
    </tr>
    </thead>
    <tbody>
    @for($i=1; $i <= $no; $i++)
    <tr>
    <td>{{$i}}</td>
        <td width="100px"><input value="" name="id[]" class="form-control" required></td>
        
        <td>
        <input type="text" name="first_name[]" class="form-control" >
        </td>
        <td><input type="text" name="last_name[]" class="form-control" ></td>
        <td>
        	<input type="text" name="other_name[]" class="form-control" ></td>
        <td width="80px">
        	<select name="level[]" class="form-control" required>
            <option value=""></option>
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
        </td>
        <td width="30px">
        <select name="div[]" class="form-control" required>
        <option value=""></option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        </select>
        </td>
        <td>
        <select name="religion[]" class="form-control" required>
        <option></option>
        <option value="1">CHRISTIAN</option>
        <option value="2">ISLAM</option>
        </select>
        </td>
        <td>
        <select name="gender[]" class="form-control" required>
        <option></option>
        <option value="1">Male</option>
        <option value="2">Female</option>
        </select>
        </td>
        <td width="100px">
        <input type="text" name="dob[]" class="form-control" ></td>
        <td width="110px"><input type="text" name="fathers_mobile[]" class="form-control" ></td>
        <td width="110px"><input type="text" name="mothers_mobile[]" class="form-control" ></td>
        <td>
        <textarea name="address[]" class="form-control"></textarea>
        </td>
        
    </tr>
    @endfor
    </tbody>
</table>

                
                
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveRate">Save Students</button>
</div>
</form>
</div>
</div>
                
            </div>
        </div>
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
              
//				 $("#saveRate").click( function(e){
//					 //e.preventDefault();
//					 var form = $("#bform");
//					 var formData = form.serialize();
//					 var url = $("#finr").attr("href");
//					 console.log(formData);
//					 $.ajax({
//							type: 'post',
//							url: url,
//							data: formData,
//							success: function(data){
//								console.log(data);
//								if(data == "exists"){
//									var c = confirm('This Rating Exists do you wish to update it?');
//								if(c == true){
//									form.submit();
//								}
//									}else if(data == "not"){
//										form.submit();
//										}
//							},
//							error: function(data) {
//								console.log(data);
//							}
//						})
//
//					 })
//
            })
         </script>   
    @stop
     
@stop