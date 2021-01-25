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


    </style>

</head>
<h1>{{\Portal\Models\Setting::where('key','title')->first()->value}}</h1>
<h2>{{$data['subject'].' Results For '.$data['class'].' '.$data['session'].'/'.++$data['session'].' Session'}}</h2>
<table cellspacing="0">
    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>1ST CA</th>
        <th>2ND CA</th>
        <th>Exam</th>
        <th>Total</th>
        <th>Position</th>
        <th>Grade</th>
    </tr>
    </thead>
    <tbody>
    @foreach($res as $k => $r)
    <tr>
        <td>{{++$k}}</td>
        <td>{{$r['id']}}</td>
        <td>{{$r['name']}}</td>
        <td>{{$r['ca1']}}</td>
        <td>{{$r['ca2']}}</td>
        <td>{{$r['exam']}}</td>
        <td>{{$r['total']}}</td>
        <td>{{$r['position']}}</td>
        <td>{{$r['grade']}}</td>
    </tr>
    @endforeach
    </tbody>

</table>

</html>