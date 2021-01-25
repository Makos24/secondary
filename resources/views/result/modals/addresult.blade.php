<div class="modal fade" id="addresult" role="dialog">
<div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload Student Results</h4>
        </div>
        <div class="modal-body">
        <a href="{{url('/results/check')}}" id="find"></a>
            <form class="form-vertical" role="form" method="post"
                  action="{{url('/results/upload')}}" enctype="multipart/form-data" id="Rform">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="control-label">Term</label>
                            <select name="term" class="form-control" required>
                                <option value=""></option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                            </select>
                            @if ($errors->has('term'))
                                <span class="help-block">
        <strong>{{ $errors->first('term') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="session" class="control-label">Session</label>
                            <select name="session" class="form-control" required>
                                <option value=""></option>
                                @for($i = 2015; $i<= date('Y'); $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @if ($errors->has('session'))
                                <span class="help-block">
        <strong>{{ $errors->first('session') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>

                </div>
                 <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                <label for="class" class="control-label">Class</label>
                                <select name="class" class="form-control" 
                                @if(session()->get('section') == "secondary")
                                id="ulevel" 
                                @endif
                                required>
                                    <option value=""></option>
                                    @if(session()->get('section') == "primary")
                                    <option value="4">Primary 1</option>
                                    <option value="5">Primary 2</option>
                                    <option value="6">Primary 3</option>
                                    <option value="7">Primary 4</option>
                                    <option value="8">Primary 5</option>
                                    <option value="9">Primary 6</option>
                                    @elseif(session()->get('section') == "secondary")
                                    <option value="10">JSS 1</option>
                                    <option value="11">JSS 2</option>
                                    <option value="12">JSS 3</option>
                                    <option value="13">SS 1</option>
                                    <option value="14">SS 2</option>
                                    <option value="15">SS 3</option>
                                    @endif
                                </select>
                                @if ($errors->has('class'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('div') ? ' has-error' : '' }}">
                                <label for="div" class="control-label">Division (A,B,C)</label>
                                <select name="div" class="form-control" id="div" required>
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                             	</select>
                                @if ($errors->has('div'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('div') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                <div class="row">
                	<div class="col-lg-6">
                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="control-label">Subject</label>
                            <select name="subject" class="form-control" id="usubjects" required>
                                <option value=""></option>
                                @if(session()->get('section') == "primary") 
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->title}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('subject'))
                                <span class="help-block">
        <strong>{{ $errors->first('subject') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('results') ? ' has-error' : '' }}">
                    <label for="results" class="control-label">Upload File</label>
                    <input type="file" name="results" class="btn btn-default" id="results" required/>
                    @if ($errors->has('results'))
                        <span class="help-block">
        <strong>{{ $errors->first('results') }}</strong>
    </span>
                    @endif
                </div>
                </div>

                
                <div class="modal-footer">
                    <input type="submit" value="Save" id="saveR" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>