@if(isset($level))
    <div class="row" id="{{$terms = $level->sortBy('term')->groupBy('term')}}">
        <div class="col-md-10">
                <h4 class="text-center"><a href="{{url("result/".$k."/".$student->id)}}">
                    {{$student->getClassName($k)}}
                    </a></h4>

        <table class="table table-bordered table-responsive" cellspacing="0">
            <span class="{!! $total = 0  !!}" id="{!! $count = 0 !!}" style="{!! $i = 1 !!}"></span>
            @foreach($terms as $j => $term)

                    <tr>
                    <th colspan="12" class="text-center">
                        @if($j == 1)
                            <a href="{{url('result/'.$student->id.'/'.$k.'/'.$j.'/'.$term[0]->session)}}">{{'First '}}
                                @elseif($j == 2)
                                    <a href="{{url('result/'.$student->id.'/'.$k.'/'.$j.'/'.$term[0]->session)}}"> {{'Second '}}
                                        @elseif($j == 3)
                                            <a href="{{url('result/'.$student->id.'/'.$k.'/'.$j.'/'.$term[0]->session)}}">{{'Third '}}
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
                        <th class="rotate"><div>POSITION <br> IN CLASS</div></th>
                        <th class="rotate"><div>CLASS <br> HIGHEST</div></th>
                        <th class="rotate"><div>CLASS <br> AVERAGE</div></th>
                        <th class="rotate"><div>CLASS <br> LOWEST</div></th>
                    	<th class="rotate"><div>GRADE</div></th>
                        <th class="rotate"><div>TEACHERS <br> REMARK</div></th>
                    </tr>

                @foreach($term as $result)
					<tr>
                        <td width="300px">{{$result->subject_title}}</td>
                        <td>{{$result->ca1}}</td>
                        <td>{{$result->ca2}}</td>
                        <td>{{$result->exam}}</td>
                        <td>{{$result->total}}</td>
                        <td>100</td>
                        <td>{{$result->positions}}</td>
                        <td>{{$result->class_highest}}</td>
                        <td>{{$result->class_average}}</td>
                        <td>{{$result->class_lowest}}</td>
                        <td>{{$result->grade}}</td>
                        <td width="150px">{{$result->remark}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                        <td colspan="4" id="{{$sum = $term->sum('total')}}">Total = {{$sum}}</td>
                        <td colspan="5">Average = {{round($sum/count($term), 2)}}</td>
                    <td colspan="4">Position = {{$student->positions->where('level', $k)->where('term', $j)->first() ? $student->positions->where('level', $k)->where('term', $j)->first()->position : ''}}</td>
                </tr>
                <tr>
                    {{--<td colspan="3">No. In Class =--}}
                        {{--@if(isset($data['no'][$k][$j]))--}}
                            {{--{{$data['no'][$k][$j]}}--}}
                        {{--@endif--}}
                    {{--</td>--}}

                </tr>


            @endforeach
            <tr>

                    {{--<td colspan="3">Cumulative Total = {!! $total !!} </td>--}}
                    {{--<td colspan="7">Total Average = {!! round($total/$count, 2) !!} </td>--}}

            </tr>
        </table>
            </div>
    </div>
    @else
    <h5>Results not found</h5>
@endif