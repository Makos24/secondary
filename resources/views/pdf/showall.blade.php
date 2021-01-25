{{--{{dd($data['rate'][10][2]->total())}}--}}

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
                            @foreach($term as $result)
                                <tr>
                                    <td class="subject">{{$result->subject_title}}</td>
                                    <td class="dtl">{{$result->ca1}}</td>
                                    <td class="dtl">{{$result->ca2}}</td>
                                    <td class="dtl">{{$result->exam}}</td>
                                    <td class="dtl">{{$result->total}}</td>
                                    <td class="dtl">{{$result->remark}}</td>
                                </tr>
                            @endforeach

                        </table>

                    @elseif(session()->get('section') == "secondary")
                        <table cellspacing="0" class="table table-bordered  ">
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
                    </table>
                        <table cellspacing="0" class="table table-bordered small"
                               id="{{$rate = $student->rates->where('term',$j)->where('class',$k)->where('session',$term[0]->session)->first()}}">
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
                    @endif

                        <table class="noborder">
                            <tr>
                                <td width="70px"><strong>Average:</strong></td>
                                <td class="underline">{{round(($term->sum('total')/count($term)),2)}}</td>
                                <td width="60px"><strong>Total:</strong></td>
                                <td class="underline">{{$term->sum('total')}}</td>
                                <td width="60px"><strong>Grade:</strong></td>
                                <td class="underline" width="50px">
                                    @if($pos = $student->positions->where('level', $k)->where('term', $j)->first())
                                        {{$pos->grade}}
                                    @endif
                                </td>
                                <td width="120px"><strong>Position in Class:</strong></td>
                                <td class="underline" width="200px">
                                    @if($pos = $student->positions->where('level', $k)->where('term', $j)->first())
                                        {{$pos->position .' out of '.$pos->number_in_class}}
                                    @endif
                                </td>
                            </tr>
                        </table>

                @endforeach
 <br>
            <table class="noborder">
                <tr>

                        <td width="140px"><strong>Cumulative Total :</strong></td>
                        <td class="underline"> {{ $level->sum('total') }} </td>
                        <td width="140px"><strong>Total Average</strong></td>
                        <td class="underline"> {{ round($level->sum('total')/count($level), 2) }} </td>

                </tr>
            </table>
        </div></div>
    @endif