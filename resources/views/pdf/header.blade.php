<table class="noborder">
<tr>

<td colspan="3">
@if(session()->get('section') == "primary")
<h1>SUNSHINE INTERNATIONAL PRIMARY SCHOOL BAUCHI</h1>
@elseif(session()->get('section') == "secondary")
<h1>SUNSHINE INTERNATIONAL SECONDARY SCHOOL BAUCHI</h1>
@endif
</td>
</tr>
<tr>
<td>
<div class="log" id="{!! 
$link = url('/logo/logo.jpg');
if($student->image == null){
$pic = url("/student/mm.jpg/view");
}else{
$pic = url("/student/".$student->image."/view");
}  !!}">
<span id="{!!
 $do = str_replace('/logo/', '/public/storage/', $link);
 $pic = str_replace('/student/', '/public/storage/students/', $pic);
 $pic = str_replace('/view', '', $pic); 
!!}"></span>
{{--@if(substr($_SERVER['SCRIPT_URL'], 8, 10) != "resulttexc" && --}}
{{--substr($_SERVER['SCRIPT_URL'], 8, 10) != "resultexce" && substr($_SERVER['SCRIPT_URL'], 8, 11) != "transcripte")--}}
<img src="{{$do}}" width="120px" height="120px"/>
{{--@endif--}}
</div>
</td>
<td>
<h3></h3>
<div class="bxx">
<h5 style="text-align: left;">Motto: {{\Portal\Models\Setting::where('key','motto')->first()->value}}</h5><br>
<h5 style="text-align: left;">ADDRESS : <span style="color:#6279E5; font-weight:200;">{{\Portal\Models\Setting::where('key','address')->first()->value}}</span></h5>

<h5 style="text-align: left;">TEL/GSM: <span style="color:#6279E5; font-weight:normal;">{{\Portal\Models\Setting::where('key','phone')->first()->value}}</span></h5>
<br>

<h2 style="text-decoration:underline; margin: 0;">
    @if(session()->get('section') == "secondary")
    TERMLY REPORT SHEET
@elseif(session()->get('section') == "primary")
        PUPIL'S REPORT SHEET
    @endif
</h2>
</div>
</td>
<td>
<div class="log">
{{--@if(substr($_SERVER['SCRIPT_URL'], 8, 10) != "resulttexc" && substr($_SERVER['SCRIPT_URL'], 8, 10) != "resultexce" && substr($_SERVER['SCRIPT_URL'], 8, 11) != "transcripte")--}}
<img src="{{$pic}}" width="120px" height="120px"/>
{{--@endif--}}
</div>
</td>
</tr>
</table>