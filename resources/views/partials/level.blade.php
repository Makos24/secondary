<div class="row">
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                <label for="class" class="control-label">Class</label>
                                <select name="class" class="form-control" required>
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