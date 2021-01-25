<div class="modal fade" id="promoteupload" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Options for Promotion</h4>
            </div>
            <div class="modal-body">
                    <form class="form-vertical" role="form" method="post"
                          action="{{url("/class/promote")}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                    <label for="class1" class="control-label">Promote From</label>
                                    <select name="class1" class="form-control" required>
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
                                    <label for="div1" class="control-label">Division (A,B,C)</label>
                                    <select name="div1" class="form-control" id="div1" required>
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
                                <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                    <label for="class2" class="control-label">Promote To</label>
                                    <select name="class2" class="form-control" required>
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
                                    <label for="div2" class="control-label">Division (A,B,C)</label>
                                    <select name="div2" class="form-control" id="div2" required>
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

                    <div class="modal-footer">
                        <input type="submit" value="Promote" id="pClass" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
        </div>
            </div>
        </div>
</div>