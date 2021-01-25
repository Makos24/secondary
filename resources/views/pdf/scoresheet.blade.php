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
<h2>{{$class}} Score Sheet</h2>
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
        <th>Grade</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $k => $student)
    <tr>
        <td>{{++$k}}</td>
        <td>{{$student->student_id}}</td>
        <td>{{$student->getName()}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
    </tbody>

</table>

</html>