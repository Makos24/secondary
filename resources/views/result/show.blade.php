
@if(isset($r))
    <div class="row">
        <div class="col-md-10">
        <table class="table table-bordered table-responsive" cellspacing="0">
            <span class="{!! $total = 0  !!}" id="{!! $count = 0 !!}" style="{!! $i = 1 !!}"></span>
        @for($j = 1; $j <= count($r); $j++)
            @if(count($r[$j]))
                <tr>
                    <th colspan="10" class="text-center">
                        @if($j == 1)
                            <a href="{{url("result/".$student->id."/".$r[1][0]->class."/".$j."/".$session)}}">{{'First '}}
                        @elseif($j == 2)
                            <a href="{{url("result/".$student->id."/".$r[1][0]->class."/".$j."/".$session)}}"> {{'Second '}}
                        @elseif($j == 3)
                            <a href="{{url("result/".$student->id."/".$r[1][0]->class."/".$j."/".$session)}}">{{'Third '}}
                        @endif
                        Term </a></a></a></th>
                </tr>
                    <tr>
                    	<th>Subject</th>
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
            @endif
           @for($i = 0; $i < count($r[$j]); $i++)

                    <tr>
                    <td width="300px">{{$r[$j][$i]->title}}</td>
                    <td>{{$r[$j][$i]->ca1}}</td>
                    <td>{{$r[$j][$i]->ca2}}</td>
                    <td>{{$r[$j][$i]->exam}}</td>
                    <td>{{($r[$j][$i]->exam+$r[$j][$i]->ca1+$r[$j][$i]->ca2)}}</td>
                    <td>100</td>
                    <td>{{$all[6][$j][$i]}}</td>
                    <td>{{$student->ordinal($r[$j][$i]->position)}}</td>
                    <td>{{$all[1][$j][$i]}}</td>
                    <td width="150px">{{$all[2][$j][$i]}}</td>
                    </tr>
            @endfor
            <tr>
                @if(count($r[$j]))
                <span class="{!! $total += array_sum($all[3][$j])  !!}" id="{!! $count += count($all[3][$j]) !!}"></span>
                <td colspan="3">Total = {{array_sum($all[3][$j])}}</td>
                <td colspan="3">Average = {{round(array_sum($all[3][$j])/count($all[3][$j]), 2)}}</td>
            </tr>
            <tr>
                <td colspan="3">No. In Class =
                    @if(isset($data['no'][0][$j]))
                        {{$data['no'][0][$j]}}
                    @endif
                </td>
                <td colspan="3">Position = @if(isset($data['position'][0][$j]))
                        {{$data['position'][0][$j]}}
                    @endif</td>


            </tr>
                @endif
        @endfor
            <tr>
                @if(count($r[3]))
                <td colspan="3">Cumulative Total = {!! $total !!} </td>
                <td colspan="3">Total Average = {!! round($total/$count, 2) !!} </td>
                @endif
            </tr>
        </table>
        </div>
    </div>
@endif