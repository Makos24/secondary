<!DOCTYPE html>
<html lang="en">
<head>
    <style type="text/css">
        body {

        }
        table {
            border: 1px solid black;
        }
        tr,th,td {
            border: 1px solid black;
        }
        tr td:first-child{
            column-span: 1;
        }
        h1,h2,h4 {
            text-align: center;
            font-family: "DejaVu Sans Mono", monospace;
        }
        th.rotate {
            /* Something you can count on */
            height: 70px;
            width:10px;
            white-space: nowrap;
        }

        th.rotate > div {
            float:left;
            position: relative;
            width: 20px;
            top: 30px;
            border-style: none;
            font-size: 15px;
            -ms-transform:rotate(270deg); /* IE 9 */
            -moz-transform:rotate(270deg); /* Firefox */
            -webkit-transform:rotate(270deg); /* Safari and Chrome */
            -o-transform:rotate(270deg); /* Opera */
        }
    </style>

</head>
<h1>{{\Portal\Models\Setting::where('key','title')->first()->value}}</h1>
<h4 style="text-transform: uppercase; text-align: center;">
{{$dat['ttitle']." Examination Results For ".$dat['ctitle'].
                " ".$dat['session']."/".++$dat['session']." Academic Session"}}</h4>

<table cellspacing="0">
    <tr>
        <td></td>
        <td></td>
    @foreach($data[1] as $value)
        @if($value != "  ")
        <td colspan="3">{{$value}}</td>
        @endif
    @endforeach
    </tr>
    <tr>
        <td>S/NO.</td>
        @foreach($data[2] as $value)
            <td>{{$value}}</td>
        @endforeach
    </tr>
    @for($i = 3; $i <= (count($data)); $i++)
        <tr>
            <td>{{($i-2)}}</td>
            @for($j = 0; $j < count($data[$i]); $j++)
                <td>{{$data[$i][$j]}}</td>
            @endfor
        </tr>
    @endfor
</table>
</html>