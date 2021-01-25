
@foreach($store as $j => $value)
    <table cellspacing="0" class="top table-bordered">
    <tr>
        <td colspan="10" align="center"><h5>
                @if($j === 1){{"FIRST "}}
                @elseif($j === 2) {{"SECOND "}}
                @elseif($j === 3) {{"THIRD "}}
                @endif
                TERM
            </h5>
        </td>
    </tr>
    </table>
    @if(session()->get('section') == "primary")
        <table cellspacing="0" class="table">
            <tr>
                <th style="color:#D14B4D;">SUBJECT</th>
                <th class="rotate"><div>1ST CA</div><div>15%</div></th>
                <th class="rotate"><div>2ND CA</div><div>15%</div></th>
                <th class="rotate"><div>EXAM</div><div>70%</div></th>
                <th class="rotate"><div>TOTAL</div><div>100%</div></th>
                <th class="rotate"><div>REMARK</div></th>

            </tr>
            @foreach($value['all'] as $k => $a)
                <tr>
                    <td class="subject">{{$a['subject']}}</td>
                    <td class="dtl">{{$a['ca1']}}</td>
                    <td class="dtl">{{$a['ca2']}}</td>
                    <td class="dtl">{{$a['exam']}}</td>
                    <td class="dtl">{{$a['ca1']+$a['ca2']+$a['exam']}}</td>
                    <td class="dtl">{{$a['remark']}}</td>
                </tr>
            @endforeach

        </table>
    @elseif(session()->get('section') == "secondary")
    <table cellspacing="0" class="table table-bordered">

        <tr>
            <th class="subject">Subject</th>
            <th class="rotate"><div>1ST CA TEST</div></th>
            <th class="rotate"><div>2ND CA TEST</div></th>
            <th class="rotate"><div>EXAMINATION</div></th>
            <th class="rotate"><div>MARKS <br> OBTAINED 100%</div></th>
            <th class="rotate"><div>MAX <br> MARKS 100% </div></th>
            <th class="rotate"><div>CLASS<br> AVERAGE</div></th>
            <th class="rotate"><div>POSITION <br> IN CLASS</div></th>
            <th class="rotate"><div>GRADE</div></th>
            <th class="rotate"><div>TEACHERS <br> REMARK</div></th>
            
        </tr>
        @foreach($value['all'] as $k => $a)
            <tr>
                <td>{{$a['subject']}}</td>
                <td>{{$a['ca1']}}</td>
                <td>{{$a['ca2']}}</td>
                <td>{{$a['exam']}}</td>
                <td>{{$a['ca1']+$a['ca2']+$a['exam']}}</td>
                <td>100</td>
                <td>{{$a['average']}}</td>
                <td>{{$a['position']}}</td>
                <td>{{$a['grade']}}</td>
                <td class="remark">{{$a['remark']}}</td>
                
            </tr>
        @endforeach

    </table>
    <table cellspacing="0" class="table table-bordered small">
        <tr><th height="98px"><div class="subject">RATE THESE TRAITS</div></th>
            <th>5 Point<br>Rating<br>Scale<br>5-4-3-2-1<br></th></tr>
        <tr><td>Punctuality</td><td>
                @if(isset($value['rate']->punctuality))
                    {{$value['rate']->punctuality}}
                @endif
            </td></tr>
        <tr><td>Class Atendance</td><td>
                @if(isset($value['rate']->attendance))
                    {{$value['rate']->attendance}}
                @endif
            </td></tr>
        <tr><td>Carrying out Assignment</td><td>
                @if(isset($value['rate']->assignments))
                    {{$value['rate']->assignments}}
                @endif
            </td></tr>
        <tr><td>Perseverance</td><td>
                @if(isset($value['rate']->perseverance))
                    {{$value['rate']->perseverance}}
                @endif
            </td></tr>
        <tr><td>Self Control</td><td>
                @if(isset($value['rate']->self_control))
                    {{$value['rate']->self_control}}
                @endif
            </td></tr>
        <tr><td>Self Confidence</td><td>
                @if(isset($value['rate']->self_confidence))
                    {{$value['rate']->self_confidence}}
                @endif
            </td></tr>
        <tr><td>Endurance</td><td>
                @if(isset($value['rate']->endurance))
                    {{$value['rate']->endurance}}
                @endif
            </td></tr>
        <tr><td>Respect</td><td>
                @if(isset($value['rate']->respect))
                    {{$value['rate']->respect}}
                @endif
            </td></tr>
        <tr><td>Relationship with others</td><td>
                @if(isset($value['rate']->relationship))
                    {{$value['rate']->relationship}}
                @endif
            </td></tr>
        <tr><td>Leadership/Team Spirit</td><td>
                @if(isset($value['rate']->leadership))
                    {{$value['rate']->leadership}}
                @endif
            </td></tr>
        <tr><td>Honesty</td><td>
                @if(isset($value['rate']->honesty))
                    {{$value['rate']->honesty}}
                @endif
            </td></tr>
        <tr><td>Neatness</td><td>
                @if(isset($value['rate']->neatness))
                    {{$value['rate']->neatness}}
                @endif
            </td></tr>
        <tr><td>Responsibilty</td><td>
                @if(isset($value['rate']->responsibility))

                    {{$value['rate']->responsibility}}
                @endif
            </td></tr>
        <tr><td>Sport & Athletics</td><td>
                @if(isset($value['rate']->sports))
                    {{$value['rate']->sports}}
                @endif
            </td></tr>
        <tr><td>Manual Skills</td><td>
                @if(isset($value['rate']->skills))
                    {{$value['rate']->skills}}
                @endif
            </td></tr>
        <tr><td>Participation in Group Project</td><td>
                @if(isset($value['rate']->group_projects))
                    {{$value['rate']->group_projects}}
                @endif
            </td></tr>
        <tr><td>Merit</td><td>
                @if(isset($value['rate']->merit))
                    {{$value['rate']->merit}}
                @endif
            </td></tr>
    
    </table>
    @endif
    <table class="noborder">
    <tr>
    		<td width="115px"><strong>NO. IN CLASS:</strong></td>
            <td class="underline">
            @if(isset($value['data']['no']))
                    {{$value['data']['no']}}
                @endif</td>
            <td width="90px"><strong>POSITION:</strong></td>
            <td class="underline">
            @if(isset($value['data']['position']))
                    {{$value['data']['position']}}
                @endif
            </td>
            <td width="50px"><strong>AVERAGE:</strong></td>
            <td class="underline">
            @if(count($value['all']))
                    {{round($value['data']['total']/count($value['all']), 2)}}
                @endif
            </td>
            <td width="50px"><strong>TOTAL:</strong></td>
            <td class="underline">
            @if(isset($value['data']['total']))
                    {{$value['data']['total']}}
                @endif
            </td>
        </tr>
      
</table>
		@if($j === 3)
        <table class="noborder">
         <tr>
            <td width="180px"><strong>CUMMULATIVE TOTAL</strong></td>
            <td class="underline"> {{ $value['data']['ctotal'] }} </td>
            <td width="210px"><strong>CUMMULATIVE AVERAGE</strong></td>
            <td class="underline"> {{ $value['data']['cavg'] }} </td>
         </tr>
            </table>
        @endif
    <br>
@endforeach
    @if(substr($_SERVER['SCRIPT_URL'], 8, 10) == "resultpdf/")
        <table class="noborder" >
            <tr>
                <td width="220px"><strong>Class Teacher's Comment :</strong></td>
                <td class="underline"></td>
            </tr>
        </table>
        <table class="noborder">
            <tr>
                <td width="60px"><strong>Signature</strong></td>
                <td class="underline"></td>
                <td width="200px"></td>
                <td width="40"><strong>Date</strong></td>
                <td class="underline"></td>
            </tr>
        </table>
        <table class="noborder" >
            <tr>
                <td width="160px"><strong>Principal's Comment :</strong></td>
                <td class="underline"></td>
            </tr>
        </table>
        <table class="noborder">
            <tr>
                <td width="180px"><strong>Principal's Signature</strong></td>
                <td class="underline"></td>
                <td width="200px"></td>
                <td width="40"><strong>Date</strong></td>
                <td class="underline"></td>
            </tr>
        </table>
    @endif
<br>
<br>