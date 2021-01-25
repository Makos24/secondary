<!doctype>
<html lang="en">
@if(session()->get('section') == "primary")
    <head>
        <style type="text/css">
            hr {
                width:200px;
                color:#6279E5;
            }
            .noborder td strong
            {
                color:#6279E5;
                font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size:14px;
                font-weight:bold;
            }
            .page {
                width: 100%;
                margin: 0px auto;
            }
            .table {
                margin: 0px auto;
                width: 90%;
                border: 2px solid #6279E5;
                font-family: "Times New Roman", Times, serif;

            }
            .table tr, .table th, .table td {
                border: 1px solid #6279E5;
                padding:10px;
            }

            .log {
                float:left;
                width: 180px;
                height:180px;
            }
            .dtl {
                text-align:center;}
            h1, h2, h3, h4, h5 {
                text-align:center;}
            h1 {
                font-family: "Arial Black", Gadget, sans-serif;
                color:#6279E5;
                font-size:35px;
                margin:0px;
                font-stretch: expanded;
            }
            h2 {
                font-family: "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
                color:#D14B4D;
                font-size:22px;
                margin:0px;
            }
            h3 {
                font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
                Helvetica, Arial, sans-serif;
                color:#6279E5;
                margin:0px;
            }
            h5 {
                margin:0px;
                font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
                Helvetica, Arial, sans-serif;
                color:#D14B4D;
            }
            p {
                margin:0px;
                font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
                Helvetica, Arial, sans-serif;
                color:#6279E5;
                text-align:center;
                font-size:14px;
            }
            .pp {
                width:200px;

            }
            .pp p {
                text-align:left;
            }
            a {
                color: #000000;
                text-decoration: none;
            }
            .underline {
                border-bottom: 1px solid #6279E5;
                text-align: center;
                font-family: "DejaVu Sans Mono", monospace;
                font-size: 20px;
                font-weight: bolder;
            }

            .log {
                float:left;
                width: 120px;
                height:130px;
            }
            .bxx {
                width:900px;
                margin:0px auto;
            }
            .dtl {
                text-align:center;}

            th.rotate {
                /* Something you can count on */
                width:120px;
                color:#D14B4D;

            }

            th.rotate > div {

            }
            .subject {
                color:#6279E5;
            }
            .remark {
                width:70px;
            }

            .noborder {
                width: 100%;
                margin: 0px auto;
                border:0px solid white;
                border-spacing: 100px;
            }
            .noborder p {
                text-align:left;}
            .base {
                clear: both;
                margin:0px auto;
                border:2px solid #6279E5;
                padding:10px;
                width:1240px;
                font-size:14px;
                margin-top:40px;
            }
            .fail {
                color: red;
            }
            .fail tr, .fail td{
                color: red;
            }
        </style>
    </head>
    <body>
    <div class="page">
        @include('pdf.header')
        <table class="noborder">
            <tr>
                <td width="40px"><strong>TERM</strong></td>
                <td class="underline" >{{Auth::user()->ordinal($data['term'])}}</td>
                <td width="600px"> </td>
                <td class="underline" >{{$data['session']."/" . ++$data['session']}}</td>
                <td width="120px"><strong>ACADEMIC YEAR</strong></td>
            </tr>
        </table>
        <table class="noborder">
            <tr>
                <td width="140px"><strong>NAME OF STUDENT:</strong></td><td colspan="4" class="underline">
                    {{$stu['name']}}</td>
            </tr>
        </table>
        <table class="noborder">
            <tr>
                <td width="45px"><strong>CLASS:</strong></td>
                <td class="underline" >{{$stu['class'].''.$stu['level']}}</td>
                <td width="65px"><strong>ADM. NO.</strong></td>
                <td class="underline">{{$stu['adno']}}</td>

            </tr>
        </table>

        <br>
        <table cellspacing="0" class="table">
            <tr>
                <th style="color:#D14B4D;">SUBJECT</th>
                <th><div class="rotate">1ST CA</div><div>15%</div></th>
                <th><div class="rotate">2ND CA</div><div>15%</div></th>
                <th><div class="rotate">EXAM</div><div>70%</div></th>
                <th><div class="rotate">TOTAL</div><div>100%</div></th>
                <th><div class="rotate">COMMENT</div></th>

            </tr>
            @foreach($all as $k => $a)
                <tr  @if(($a['ca1']+$a['ca2']+$a['exam']) < 40) class="fail" @endif>
                    <td class="subject">{{$a['subject']}}</td>
                    <td class="dtl">{{$a['ca1']}}</td>
                    <td class="dtl">{{$a['ca2']}}</td>
                    <td class="dtl">{{$a['exam']}}</td>
                    <td class="dtl">{{$a['ca1']+$a['ca2']+$a['exam']}}</td>
                    <td class="dtl">{{$a['remark']}}</td>
                </tr>
            @endforeach

        </table>
        <div class="base">
            <table class="noborder">
                <tr>
                    <td width="160px"><strong>Maximum Attendance :</strong></td>
                    <td class="underline">
                        @if(isset($attendance->total))
                            {{$attendance->total}}
                        @endif
                    </td>
                    <td width="100px"><strong>Time Present :</strong></td>
                    <td class="underline">
                        @if(isset($attendance->present))
                            {{$attendance->present}}
                        @endif
                    </td>
                    <td width="90px"><strong>Time Absent:</strong></td>
                    <td class="underline" >
                        @if(isset($attendance->present) && isset($attendance->total) && isset($attendance->late))
                            {{($attendance->total-($attendance->present+$attendance->late))}}
                        @endif</td>
                    <td width="80px"><strong>Time Late:</strong></td>
                    <td class="underline" width="150px" >
                        @if(isset($attendance->late))
                            {{($attendance->late)}}
                        @endif</td>
                </tr>
            </table>
            <table class="noborder">
                <tr>

                    <td width="150px"><strong>General Behaviour:</strong></td>
                    <td class="underline" >
                        @if(isset($behaviour->behaviour))
                            {{Auth::user()->behaviour($behaviour->behaviour)}}
                        @endif
                    </td>
                    <td width="150px"><strong>General Appearance:</strong></td>
                    <td class="underline" >
                        @if(isset($behaviour->appearance))
                            {{Auth::user()->appearance($behaviour->appearance)}}
                        @endif
                    </td>
                </tr>
            </table>
            <table class="noborder">
                <tr>
                    @if($data['term'] && $data['term'] == 3)
                        <td width="50px"><strong>Average:</strong></td>
                        <td class="underline">{{round($data['cavg'], 2)}}</td>
                        <td width="40px"><strong>Total:</strong></td>
                        <td class="underline">{{$data['ctotal']}}</td>
                        <td width="40px"><strong>Grade:</strong></td>
                        <td class="underline">{{$data['cgrade']}}</td>
                        <td width="125px"><strong>Position in Class:</strong></td>
                        <td class="underline" width="200px">{{$data['position'].' out of '.$data['no']}}</td>
                    @else
                        <td width="50px"><strong>Average:</strong></td>
                        <td class="underline">{{round($data['average'], 2)}}</td>
                        <td width="40px"><strong>Total:</strong></td>
                        <td class="underline">{{$data['total']}}</td>
                        <td width="40px"><strong>Grade:</strong></td>
                        <td class="underline">{{$data['grade']}}</td>
                        <td width="123px"><strong>Position in Class:</strong></td>
                        <td class="underline" width="200px">{{$data['tposition'].' out of '.$data['no']}}</td>
                    @endif
                </tr>
            </table>
            @if($data['term'] && $data['term'] == 3)
                <table class="noborder">
                    <tr>
                        <td width="110px"><strong>1st Term Total:</strong></td>
                        <td class="underline" >
                            @if(isset($data['fsum']))
                                {{$data['fsum']}}
                            @endif
                        </td>
                        <td width="110px"><strong>2nd Term Total:</strong></td>
                        <td class="underline" >
                            @if(isset($data['ssum']))
                                {{$data['ssum']}}
                            @endif
                        </td>
                        <td width="110px"><strong>3rd Term Total:</strong></td>
                        <td class="underline" >
                            @if(isset($data['tsum']))
                                {{$data['tsum']}}</td>
                        @endif
                        <td width="140px"><strong>Cummulative Total:</strong></td>
                        <td class="underline" width="140px" >
                            @if(isset($data['ctotal']))
                                {{$data['ctotal']}}</td>
                        @endif
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="140px"><strong>1st Term Average:</strong></td>
                        <td class="underline" >
                            @if(isset($data['favg']))
                                {{$data['favg']}}
                            @endif
                        </td>
                        <td width="140px"><strong>2nd Term Average:</strong></td>
                        <td class="underline" >
                            @if(isset($data['savg']))
                                {{$data['savg']}}
                            @endif
                        </td>
                        <td width="140px"><strong>3rd Term Average:</strong></td>
                        <td class="underline" >{{$data['tavg']}}</td>
                        <td width="160px"><strong>Cummulative Average:</strong></td>
                        <td class="underline" >{{$data['tavg']}}</td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="130px"><strong>3rd Term Position:</strong></td>
                        <td class="underline" >
                            @if(isset($data['favg']))
                                {{$data['tposition']}}
                            @endif
                        </td>
                        <td width="120px"><strong>Annual Position:</strong></td>
                        <td class="underline" >
                            @if(isset($data['savg']))
                                {{$data['position']}}
                            @endif
                        </td>

                    </tr>
                </table>

            @endif
            <table class="noborder" >
                <tr>
                    <td width="210px"><strong>Class Teacher's Comment :</strong></td>
                    <td class="underline">{{Auth::user()->comment($data['position'])}}</td>
                    <td width="138px"><strong>Next Term Begins:</strong></td>
                    <td class="underline">
                        {{\Portal\Models\Termsetting::where('current',true)->first()->resume_date->format('d-M-Y')}}</td>
                </tr>
            </table>
            <table class="noborder">
                <tr>
                    <td width="200px"><strong>Class Teacher's Name :</strong></td>
                    <td class="underline">
                        @if(isset($data['teacher']))
                            {{$data['teacher']}}
                        @endif
                    </td>
                    <td width="100px"></td>
                    <td width="90"><strong>Signature</strong></td>
                    <td class="underline" width="200px"></td>
                </tr>
            </table>
            <table class="noborder" >
                <tr>
                    <td width="200px"><strong>Head Mistress's Comment :</strong></td>
                    <td class="underline">
                        @if($data['term'] && $data['term'] != 3)
                            {{Auth::user()->pComment($data['average'])}}
                        @endif</td>
                </tr>
            </table>
            <table class="noborder">
                <tr>
                    <td width="200px"><strong>Head Mistress's Signature :</strong></td>
                    <td class="underline"></td>
                    <td width="200px"></td>
                    <td width="40"><strong>Date :</strong></td>
                    <td class="underline"></td>
                </tr>
            </table>
        </div>
    </div>
    </body>
@elseif(session()->get('section') == "secondary")
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css">
            .page {
                width:100%;
                margin:0px auto;
                padding: 0;

            }.box {
                 width:100%;
                 margin:0px auto;
                 padding: 0;

             }
            hr {
                width:200px;
                color:#6279E5;

            }
            .noborder td strong
            {
                color:#6279E5;
                font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size:15px;
                font-weight:normal;
            }

            .table {
                font-size:17px;
            }
            .table tr, .table th, .table td {
                border: 1px solid #6279E5;
            }

            .log {
                float:left;
                width: 130px;
                height:150px;
            }
            .dtl {
                text-align:center;}
            /*h1, h2, h3, h4, h5 {*/
            /*text-align:center;}*/
            h1 {
                font-family: "Helvetica Neue", Helvetica, sans-serif;
                color:#6279E5;
                font-size:37px;
                margin:0px;
                text-align: center;
            }
            h2 {
                font-family: "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
                color:#D14B4D;
                font-size:20px;
                margin:0px;
                margin-left: 30px;
            }
            h3 {
                font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
                Helvetica, Arial, sans-serif;
                color:#6279E5;
                margin:0px;

            }
            h5 {
                margin:0px;
                font-family: "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
                color:#D14B4D;
                font-size: 17px;
            }
            p {
                margin:0px;
                font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed",
                Helvetica, Arial, sans-serif;
                color:#6279E5;
                text-align:center;
                font-size:20px;
            }
            .pp {
                width:200px;

            }
            .pp p {
                text-align:left;
            }
            a {
                color: #000000;
                text-decoration: none;
            }
            .underline {
                border-bottom: 1px solid #6279E5;
                text-align: center;
                font-family: "DejaVu Sans Mono", monospace;
                font-size: 20px;
                font-weight:bolder;
            }
            .noborder {
                width: 100%;
                margin: 0px auto;
                border:0px solid white;
                border-spacing: 7px;
                padding:0;
            }
            .bxx {
                width:100%;
                clear: right;
                margin-left: 150px;

            }

            .top {
                width:100%;
                text-align: center;
                font-size:17px;
                padding:0px;
                /*margin-bottom: -10px;*/
                border: 2px solid #6279E5;
                border-bottom:none;
                height: 58px;
            }
            .wrap {
                clear:both;
                border: 2px solid #6279E5;
                width:100%;

            }
            .fail {
                color: red;
            }
            .fail tr, .fail td{
                color: red;
            }

            .details {
                width: 100%;
                margin-top: 20px;
            }
            .results {
                width: 100%;
                margin-bottom: 20px;
                /*float: left;*/

            }

            .tdiv {
                width: 75%;
                margin-bottom:20px;
                font-family: "Times New Roman", Times, serif;
                float: left;
            }
            .sdiv {
                width: 25%;
                float: left;
            }

            .table {
                border: 2px solid #6279E5;
                border-right: none;
                /*max-width: 520px;*/
                text-align: center;
                margin-bottom:20px;
                font-family: "Times New Roman", Times, serif;
                width: 100%;


            }
            .small {
                border: 2px solid #6279E5;
                border-left:none;
                border-bottom:none;
                font-size: 19px;
                font-family: "Times New Roman", Times, serif;
                /*margin-bottom: -200px;*/

            }
            th.subject {
                color:#6279E5;
                width: 35%;
            }

            th.rotate {
                /* Something you can count on */
                height: 120px;
                width:45px;
                white-space: nowrap;
                color:#D14B4D;
            }

            th.rotate > div {
                float:left;
                position: relative;
                width: 30px;
                top: 40px;
                left:5px;
                border-style: none;
                font-size: 15px;
                -ms-transform:rotate(270deg); /* IE 9 */
                -moz-transform:rotate(270deg); /* Firefox */
                -webkit-transform:rotate(270deg); /* Safari and Chrome */
                -o-transform:rotate(270deg); /* Opera */
            }

            .remark {
                width:100px;
            }
            .sub {
                width: 160px;
            }
            .base {
                clear: both;
                border:2px solid #6279E5;
                padding:10px;
                width:98%;
                font-size:17px;

            }
            table.small tr td:nth-child(2) {
                line-height: 30px;
                text-align: center;
            }
            .base table {
               line-height: 35px;
            }


            @media (max-width: 1440px) {
                h1 {
                    font-size:29px;
                }
                h2 {
                    font-size:15px;
                    margin-left: 20px;
                }
                h5 {
                    font-size: 14px;
                }
                p {
                    font-size:15px;
                }
                .table {
                    font-size:16px;
                }
                .underline {
                    font-size: 15px;
                }
                .noborder {
                    border-spacing: 5px;
                }
                .small {
                    font-size: 16px;
                }
                .base {
                    padding:8px;
                    font-size:16px;

                }
                .base table {
                    line-height: 30px;
                }
                table.small tr td:nth-child(2) {
                    line-height: 25px;
                }
                .table {
                    margin-bottom:10px;

                }

            }


        </style>

    </head>
    <body>

    <div class="box">
        @if($term == 3)
            @include('pdf.header')

            <table class="noborder">
                <tr>
                    <td width="40px"><strong></strong></td>

                    <td width="700px"> </td>
                    <td class="underline" >{{$session."/" . ($session+1)}}</td>
                    <td width="65px"><strong>SESSION</strong></td>
                </tr>
            </table>
            <table class="noborder">
                <tr>
                    <td width="150px"><strong>Name of Student:</strong></td><td colspan="2" class="underline">
                        {{$student->name}}</td>
                    <td width="150px"></td>
                    <td width="40px"><strong>Term</strong></td>
                    <td width="120px" class="underline" >{{Auth::user()->ordinal($term)}}</td>
                </tr>
            </table>
            <table class="noborder">
                <tr id="{{$attendance = $student->attendances->where('term',$term)->where('class',$level)->where('session',$session)->first()}}">
                    <td width="175px"><strong>Maximum Attendance:</strong></td>
                    <td class="underline" width="120px">
                        @if(isset($attendance->total))
                            {{$attendance->total}}
                        @endif
                    </td>
                    <td width="100px"></td>
                    <td width="120px"><strong>Times Present:</strong></td>
                    <td class="underline" >
                        @if(isset($attendance->present))
                            {{$attendance->present}}
                        @endif
                    </td>
                    <td width="70px"><strong>Class:</strong></td>
                    <td class="underline" >{{$student->student_class}}</td>
                </tr>
            </table>
            <table class="noborder">
                <tr>
                    <td width="155px"><strong>Next Term Begins:</strong></td>
                    <td class="underline">
                        @if(null !== $pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                            {{$pos->resume_date->format('d-M-Y')}}
                        @endif
                    </td>
                    <td width="300px"></td>
                    <td width="60px"><strong>Date</strong></td>
                    <td class="underline" >
                        @if(null !== $pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                            {{$pos->close_date->format('d-M-Y')}}
                        @endif
                    </td>
                </tr>
            </table>

            <div class="results"  >
                <div class="tdiv">
                    <table cellspacing="0" class="table" id="{{$tsubjects = $results->groupBy('subject_id')}}">
                        <tr>
                            <th><div class="subject">SUBJECTS</div></th>
                            <th class="rotate"><div>1ST TERM<br> SCORE</div></th>
                            <th class="rotate"><div>2ND TERM <br> SCORE</div></th>
                            <th class="rotate"><div>3RD TERM <br> SCORE</div></th>
                            <th class="rotate"><div>CUM <br> AVERAGE</div></th>
                            <th class="rotate"><div>GRADE</div></th>
                            <th class="rotate" style="text-align: center;"><div>TEACHERS <br> REMARK</div></th>
                            <th  class="rotate" width="30px"><div>SIGNATURE</div></th>

                        </tr>

                        @foreach($tsubjects as $k => $subjects)
                            <tr style="line-height: 35px" id="{{$subject = $subjects->groupBy('term')}}{{$average=$subjects->sum('total')/count($subjects)}}"  @if($average < 40) class="fail" @endif>
                                <td style="text-align: left">{{$loop->iteration.'. '.$subject->first()->first()->subject_title}}</td>
                                <td>{{isset($subject[1]) ? $subject[1]->first()->total : ''}}</td>
                                <td>{{isset($subject[2]) ? $subject[2]->first()->total : ''}}</td>
                                <td>{{isset($subject[3]) ? $subject[3]->first()->total : ''}}</td>
                                <td>{{round($average, 2)}}</td>
                                <td>{{$subject->first()->first()->grade($average)}}</td>
                                <td class="remark">{{$subject->first()->first()->remark($average)}}</td>
                                <td width="100px"></td>

                            </tr>

                        @endforeach

                    </table>
                </div>


                <div class="sdiv">
                    <table cellspacing="0" border="1" class="small" id="{{$rate = $student->rates->where('term',$term)->where('class',$level)->where('session',$session)->first()}}">

                        <tr><th><div class="subject">RATE THESE TRAITS</div></th>
                            <th>5 Point<br>Rating<br>Scale<br>5-4-3-2-1<br></th></tr>
                        <tr><td>Punctuality</td><td>
                                @if(isset($rate->punctuality))
                                    {{$rate->punctuality}}
                                @endif
                            </td></tr>
                        <tr><td>Class Atendance</td><td>
                                @if(isset($rate->attendance))
                                    {{$rate->attendance}}
                                @endif
                            </td></tr>
                        <tr><td>Carrying out Assignment</td><td>
                                @if(isset($rate->assignments))
                                    {{$rate->assignments}}
                                @endif
                            </td></tr>
                        <tr><td>Perseverance</td><td>
                                @if(isset($rate->perseverance))
                                    {{$rate->perseverance}}
                                @endif
                            </td></tr>
                        <tr><td>Self Control</td><td>
                                @if(isset($rate->self_control))
                                    {{$rate->self_control}}
                                @endif
                            </td></tr>
                        <tr><td>Self Confidence</td><td>
                                @if(isset($rate->self_confidence))
                                    {{$rate->self_confidence}}
                                @endif
                            </td></tr>
                        <tr><td>Endurance</td><td>
                                @if(isset($rate->endurance))
                                    {{$rate->endurance}}
                                @endif
                            </td></tr>
                        <tr><td>Respect</td><td>
                                @if(isset($rate->respect))
                                    {{$rate->respect}}
                                @endif
                            </td></tr>
                        <tr><td>Relationship with others</td><td>
                                @if(isset($rate->relationship))
                                    {{$rate->relationship}}
                                @endif
                            </td></tr>
                        <tr><td>Leadership/Team Spirit</td><td>
                                @if(isset($rate->leadership))
                                    {{$rate->leadership}}
                                @endif
                            </td></tr>
                        <tr><td>Honesty</td><td>
                                @if(isset($rate->honesty))
                                    {{$rate->honesty}}
                                @endif
                            </td></tr>
                        <tr><td>Neatness</td><td>
                                @if(isset($rate->neatness))
                                    {{$rate->neatness}}
                                @endif
                            </td></tr>
                        <tr><td>Responsibilty</td><td>
                                @if(isset($rate->responsibility))

                                    {{$rate->responsibility}}
                                @endif
                            </td></tr>
                        <tr><td>Sport & Athletics</td><td>
                                @if(isset($rate->sports))
                                    {{$rate->sports}}
                                @endif
                            </td></tr>
                        <tr><td>Manual Skills</td><td>
                                @if(isset($rate->skills))
                                    {{$rate->skills}}
                                @endif
                            </td></tr>
                        <tr><td>Participation in Group Project</td><td>
                                @if(isset($rate->group_projects))
                                    {{$rate->group_projects}}
                                @endif
                            </td></tr>
                        <tr><td>Merit</td><td>
                                @if(isset($rate->merit))
                                    {{$rate->merit}}
                                @endif
                            </td></tr>

                    </table>

                </div>

            </div>

            <div class="base">
                <table class="noborder">
                    <tr>
                        <td width="110px"><strong>1st TERM TOTAL:</strong></td>
                        <td class="underline" width="100px" >{{$results->where('term',1)->sum('total')}}</td>
                        <td width="70px"><strong>2nd TERM:</strong></td>
                        <td class="underline" width="100px" >{{$results->where('term',2)->sum('total')}}</td>
                        <td width="70px"><strong>3rd TERM:</strong></td>
                        <td class="underline" width="100px">{{$results->where('term',3)->sum('total')}}</td>
                        <td width="100px"><strong>CUMM. TOTAL:</strong></td>
                        <td class="underline" width="100px" >{{$results->sum('total')}}</td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="90px"><strong>1st TERM AVG.:</strong></td>
                        <td class="underline" width="100px" id="{{$a1 = round($results->where('term', 1)->sum('total')/count($results->where('term',1)),2)}}">
                            {{$a1}}
                        </td>
                        <td width="70px"><strong>2nd TERM:</strong></td>
                        <td class="underline" width="100px" id="{{$a2 = round($results->where('term', 2)->sum('total')/count($results->where('term',2)),2)}} ">
                            {{$a2}}
                        </td>
                        <td width="70px"><strong>3rd TERM:</strong></td>
                        <td class="underline" width="100px" id="{{$a3 = round($results->where('term', 3)->sum('total')/count($results->where('term',3)),2)}}" >
                            {{$a3}}
                        </td>
                        <td width="70px"><strong>CUMM. AVG.:</strong></td>
                        <td class="underline" width="100px" >
                            {{$a1 == 0 || $a2 == 0 || $a3 == 0 ? round(($a1+$a2+$a3)/2,2) : round(($a1+$a2+$a3)/3,2)}}
                        </td>
                    </tr>
                </table>


                <table class="noborder">
                    <tr>
                        <td width="110px"><strong>1st TERM POSITION:</strong></td>
                        <td class="underline" width="70px" id="{{$p1=$student->positions->where('level',$level)->where('session',$session)->where('term',1)->first()}}" >{{$p1 ? $p1->position : ''}}</td>
                        <td width="70px"><strong>2nd TERM:</strong></td>
                        <td class="underline" width="70px" id="{{$p2=$student->positions->where('level',$level)->where('session',$session)->where('term',2)->first()}}" >{{$p2 ? $p2->position : ''}}</td>
                        <td width="70px"><strong>3rd TERM:</strong></td>
                        <td class="underline" width="70px" id="{{$p3=$student->positions->where('level',$level)->where('session',$session)->where('term',3)->first()}}" >{{$p3 ? $p3->position : ''}}</td>
                        <td width="110px"><strong>ANNUAL POSITION:</strong></td>
                        <td class="underline" width="170px" >{{$p3 ? $p3->overall_pos .' out of '. $p3->number_in_class : ''}}</td>
                    </tr>
                </table>

                <table class="noborder" >
                    <tr>
                        <td width="185px"><strong>Class Teacher's Comment :</strong></td>
                        <td class="underline">
                            @if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                {{$pos->comment}}
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="120px"><strong>Class Teacher's Name :</strong></td>
                        <td class="underline" width="280px">{{$student->class_teacher}}</td>

                        <td width="70px"><strong>Signature</strong></td>
                        <td class="underline" width="200px"></td>
                    </tr>
                </table>
                <table class="noborder" >
                    <tr>
                        <td width="150px"><strong>Principal's Comment :</strong></td>
                        <td class="underline">

                        </td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="155px"><strong>Principal's Signature</strong></td>
                        <td class="underline"></td>
                        <td width="200px"></td>
                        <td width="40"><strong>Date</strong></td>
                        <td class="underline"></td>
                    </tr>
                </table>
            </div>
    </div>


        @else


            @include('pdf.header')
            <div class="details">
                <table class="noborder">
                    <tr>
                        <td width="40px"><strong></strong></td>

                        <td width="700px"> </td>
                        <td class="underline" >{{$session."/" . ($session+1)}}</td>
                        <td width="65px"><strong>SESSION</strong></td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="150px"><strong>Name of Student:</strong></td><td colspan="2" class="underline">
                            {{$student->name}}</td>
                        <td width="180px"></td>
                        <td width="60px"><strong>Term</strong></td>
                        <td class="underline" >{{Auth::user()->ordinal($term)}}</td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr id="{{$attendance = $student->attendances->where('term',$term)->where('class',$level)->where('session',$session)->first()}}">
                        <td width="155px"><strong>Maximum Attendance:</strong></td>
                        <td class="underline" width="100px">
                            @if(isset($attendance->total))
                                {{$attendance->total}}
                            @endif
                        </td>
                        <td width="100px"></td>
                        <td width="150px"><strong>Times Present:</strong></td>
                        <td class="underline" >
                            @if(isset($attendance->present))
                                {{$attendance->present}}
                            @endif
                        </td>
                        <td width="60px"><strong>Class:</strong></td>
                        <td class="underline" >{{$student->student_class}}</td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="155px"><strong>Next Term Begins:</strong></td>
                        <td class="underline">
                            @if(null !== $pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                                {{$pos->resume_date->format('d-M-Y')}}
                            @endif
                        </td>
                        <td width="300px"></td>
                        <td width="60px"><strong>Date</strong></td>
                        <td class="underline" >
                            @if(null !== $pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                                {{$pos->close_date->format('d-M-Y')}}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <table cellspacing="0" class="top">
                <tr><td width="200px">Continuous Assessment 30%<br>Examination 70%</td>
                    <td>90-100 Excellent, 80-89 Very Good,<br> 50-79 Good, 40-49 Fair<br> 0-39 Poor</td>
                    <td width="50px"></td>
                </tr>
            </table>
            <div class="results">


                <div class="tdiv">
                    <table cellspacing="0" class="table">
                        <tr>
                            <th class="subject">SUBJECT</th>
                            <th class="rotate"><div>1ST CA TEST</div></th>
                            <th class="rotate"><div>2ND CA TEST</div></th>
                            <th class="rotate"><div>EXAM</div></th>
                            <th class="rotate"><div>TOTAL</div></th>
                            <th class="rotate"><div>CLASS<br> HIGHEST</div></th>
                            <th class="rotate"><div>CLASS<br> AVERAGE</div></th>
                            <th class="rotate"><div>CLASS<br> LOWEST</div></th>
                            <th class="rotate"><div>POSITION <br> IN CLASS</div></th>
                            <th class="rotate"><div>GRADE</div></th>
                            <th class="rotate"><div>TEACHERS <br> REMARK</div></th>

                        </tr>
                        @foreach($results as $k => $result)
                            <tr style="line-height: 35px" @if(($result->total) < 40) class="fail" @endif>
                                <td style="text-align: left">{{$loop->iteration.'. '.$result->subject_title}}</td>
                                <td>{{$result->ca1}}</td>
                                <td>{{$result->ca2}}</td>
                                <td>{{$result->exam}}</td>
                                <td>{{$result->total}}</td>
                                <td>{{$result->class_highest}}</td>
                                <td>{{$result->class_average}}</td>
                                <td>{{$result->class_lowest}}</td>
                                <td>{{$result->positions}}</td>
                                <td>{{$result->grade}}</td>
                                <td class="remark">{{$result->remark}}</td>

                            </tr>
                        @endforeach

                    </table>
                </div>

                <div class="sdiv">
                    <table class="small" cellspacing="0" border="1" >
                        <tr id="{{$rate = $student->rates->where('term',$term)->where('class',$level)->where('session',$session)->first()}}">
                            <th>RATE THESE TRAITS</th>
                            <th>5 Point<br>Rating<br>Scale<br>5-4-3-2-1</th></tr>
                        <tr><td>Punctuality</td><td>
                                @if(isset($rate->punctuality))
                                    {{$rate->punctuality}}
                                @endif
                            </td></tr>
                        <tr><td>Class Atendance</td><td>
                                @if(isset($rate->attendance))
                                    {{$rate->attendance}}
                                @endif
                            </td></tr>
                        <tr><td>Carrying out Assignment</td><td>
                                @if(isset($rate->assignments))
                                    {{$rate->assignments}}
                                @endif
                            </td></tr>
                        <tr><td>Perseverance</td><td>
                                @if(isset($rate->perseverance))
                                    {{$rate->perseverance}}
                                @endif
                            </td></tr>
                        <tr><td>Self Control</td><td>
                                @if(isset($rate->self_control))
                                    {{$rate->self_control}}
                                @endif
                            </td></tr>
                        <tr><td>Self Confidence</td><td>
                                @if(isset($rate->self_confidence))
                                    {{$rate->self_confidence}}
                                @endif
                            </td></tr>
                        <tr><td>Endurance</td><td>
                                @if(isset($rate->endurance))
                                    {{$rate->endurance}}
                                @endif
                            </td></tr>
                        <tr><td>Respect</td><td>
                                @if(isset($rate->respect))
                                    {{$rate->respect}}
                                @endif
                            </td></tr>
                        <tr><td>Relationship with others</td><td>
                                @if(isset($rate->relationship))
                                    {{$rate->relationship}}
                                @endif
                            </td></tr>
                        <tr><td>Leadership/Team Spirit</td><td>
                                @if(isset($rate->leadership))
                                    {{$rate->leadership}}
                                @endif
                            </td></tr>
                        <tr><td>Honesty</td><td>
                                @if(isset($rate->honesty))
                                    {{$rate->honesty}}
                                @endif
                            </td></tr>
                        <tr><td>Neatness</td><td>
                                @if(isset($rate->neatness))
                                    {{$rate->neatness}}
                                @endif
                            </td></tr>
                        <tr><td>Responsibilty</td><td>
                                @if(isset($rate->responsibility))
                                    {{$rate->responsibility}}
                                @endif
                            </td></tr>
                        <tr><td>Sport & Athletics</td><td>
                                @if(isset($rate->sports))
                                    {{$rate->sports}}
                                @endif
                            </td></tr>
                        <tr><td>Manual Skills</td><td>
                                @if(isset($rate->skills))
                                    {{$rate->skills}}
                                @endif
                            </td></tr>
                        <tr><td>Participation in Group Project</td><td>
                                @if(isset($rate->group_projects))
                                    {{$rate->group_projects}}
                                @endif
                            </td></tr>
                        <tr><td>Merit</td><td>
                                @if(isset($rate->merit))
                                    {{$rate->merit}}
                                @endif
                            </td></tr>

                    </table>
                </div>





            </div>
            <div class="base">
                <table class="noborder">
                    <tr>
                        <td width="70px"><strong>Average:</strong></td>
                        <td class="underline">{{round(($results->sum('total')/count($results)),2)}}</td>
                        <td width="60px"><strong>Total:</strong></td>
                        <td class="underline">{{$results->sum('total')}}</td>
                        <td width="60px"><strong>Grade:</strong></td>
                        <td class="underline" width="50px">
                            @if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                {{$pos->grade}}
                            @endif
                        </td>
                        <td width="120px"><strong>Position in Class:</strong></td>
                        <td class="underline" width="200px">
                            @if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                {{$pos->position .' out of '.$pos->number_in_class}}
                            @endif
                        </td>
                    </tr>

                </table>
                <table class="noborder">
                    <tr>
                        <td width="195px"><strong>Class Teacher's Comment :</strong></td>
                        <td class="underline">
                            @if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                {{$pos->comment}}
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="170px"><strong>Class Teacher's Name :</strong></td>
                        <td class="underline" width="500px">
                            {{$student->class_teacher}}
                        </td>
                        <td width="70px"><strong>Signature</strong></td>
                        <td class="underline"></td>
                    </tr>
                </table>
                <table class="noborder" >
                    <tr>
                        <td width="150px"><strong>Principal's Comment :</strong></td>
                        <td class="underline">
                            {{--            {{$data['term'] && $data['term'] != 3 ? Auth::user()->pComment($data['average']) : ''}}--}}
                        </td>
                    </tr>
                </table>
                <table class="noborder">
                    <tr>
                        <td width="150px"><strong>Principal's Signature</strong></td>
                        <td class="underline"></td>
                        <td width="150px"></td>
                        <td width="60"><strong>Date</strong></td>
                        <td class="underline"></td>
                    </tr>
                </table>
            </div>
    </div>

    @endif


    </body>
@endif

</html>
