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
<h2>{{$class}} Bio Data</h2>
<table cellspacing="0">
    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>Class</th>
        <th>Religion</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Reg. Date</th>
        <th>Parents Mobile</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $k => $student)
    <tr>
        <td>{{++$k}}</td>
        <td>{{$student->student_id}}</td>
        <td>{{$student->getName()}}</td>
        <td>{{$student->getClass()}}</td>
        <td>
        @if($student->religion == 1)
        {{'CHRISTIAN'}}
        @elseif($student->religion == 2)
        {{'ISLAM'}}
        @endif
        </td>
        <td>
        @if($student->gender == 1)
        {{'Male'}}
        @elseif($student->gender == 2)
        {{'Female'}}
        @endif
        </td>
        <td>{{$student->dob}}</td>
        <td>{{$student->reg_date}}</td>
        <td>
        @if(($student->dad_number) || ($student->mum_number))
        {{'Dad: '.$student->dad_number.' Mum: '.$student->mum_number}}
        @endif
        </td>
    </tr>
    @endforeach
    </tbody>

</table>

</html>