@if(isset($r))
    {{--<p>{{dump($r)}}</p>--}}
@endif
@if(isset($r))

    <div class="row">
        <div class="col-md-9 table-responsive">
            <table class="table table-bordered">
                <span class="{!! $total = 0  !!}" id="{!! $count = 0 !!}" style="{!! $i = 1 !!}"></span>
                @for($j = 1; $j <= count($r); $j++)
                    @if(count($r[$j]))
                        <thead>
                        <td colspan="6" class="text-center">
                            @if($j == 1)
                                <a href="#">{{'First '}}
                                    @elseif($j == 2)
                                        <a href="#"> {{'Second '}}
                                            @elseif($j == 3)
                                                <a href="#">{{'Third '}}
                                                    @endif
                                                    Term </a></a></a></td>
                        </thead>
                        <thead>
                        <td>Subject</td>
                        <td>CA</td>
                        <td>Exam</td>
                        <td>Total</td>
                        <td>Grade</td>
                        <td>Remark</td>
                        </thead>
                    @endif
                    @for($i = 0; $i < count($r[$j]); $i++)

                        <tr>
                            <td>{{$r[$j][$i]->title}}</td>
                            <td>{{$r[$j][$i]->ca}}</td>
                            <td>{{$r[$j][$i]->exam}}</td>
                            <td>{{($r[$j][$i]->exam+$r[$j][$i]->ca)}}</td>
                            <td>{{$all[1][$j][$i]}}</td>
                            <td>{{$all[2][$j][$i]}}</td>
                        </tr>
                    @endfor
                    <tr>
                        @if(count($r[$j]))
                            <span class="{!! $total += array_sum($all[3][$j])  !!}" id="{!! $count += count($all[3][$j]) !!}"></span>
                            <td colspan="3">Total = {{array_sum($all[3][$j])}}</td>
                            <td colspan="3">Average = {{array_sum($all[3][$j])/count($all[3][$j])}}</td>
                        @endif

                    </tr>

                @endfor
                <tr>
                    @if(count($r[3]))
                        <td colspan="3">Cumulative Total = {!! $total !!} </td>
                        <td colspan="3">Total Average = {!! $total/$count !!} </td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
@endif