<!DOCTYPE html>
<html lang="en">
<head>
    <style type="text/css">
        table {
            border: 1px solid black;
            width: 100%;
        }
        tr,th,td {
            border: 1px solid black;
        }
        h1,h2,h3,h4 {
            text-align: center;
            font-family: "DejaVu Sans Mono", monospace;
			font-size:24px;
        }
		th.rotate {
            /* Something you can count on */
            height: 170px;
            width:20px;
            white-space: nowrap;
			text-align:center;
        }

        th.rotate > div {
			margin:0px auto;
            text-align:center;
            position: relative;
            width: 20px;
            top: 60px;
            border-style: none;
            font-size: 12px;
			font-weight:bold;
            -ms-transform:rotate(270deg); /* IE 9 */
            -moz-transform:rotate(270deg); /* Firefox */
            -webkit-transform:rotate(270deg); /* Safari and Chrome */
            -o-transform:rotate(270deg); /* Opera */
        }

    </style>

</head>
<h1>{{\Portal\Models\Setting::where('key','title')->first()->value}}</h1>
<h2>{{$class}} Score Sheet</h2>
<table cellspacing="0">
    <thead>
    <tr>
        <th>S/No</th>
        <th>NAMES</th>
        @foreach($subjects as $subject)
        	<th class="rotate" colspan="3"><div>{{$subject->title}}</div></th>
        @endforeach
        <th class="rotate"><div>TOTAL</div></th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $k => $student)
    <tr>
        <td width="40px">{{++$k}}</td>
        <td width="300px" height="30px">{{$student->getName()}}</td>
        @foreach($subjects as $subject)
        	<td></td>
            <td></td>
            <td></td>
        @endforeach
        <td width="100px"></td>
    </tr>
    @endforeach
    </tbody>

</table>

</html>