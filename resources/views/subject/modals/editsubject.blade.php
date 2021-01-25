
<div class="modal fade" id="editSubject" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Subject</h4>
            </div>
            <div class="modal-body">

                <form class="form-vertical" role="form" method="post" action="{{url("/subjects/update")}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="subject_id" value="" id="subject_id">
                    <div class="col-lg-10">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="control-label">Subject Name</label>
                            <input id="stitle" type="text" class="form-control" name="title"
                                   value="{{old('title')}}" required>
                            @if ($errors->has('title'))
                                <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                            <label for="section" class="control-label">Section</label>
                            <input id="section" type="text" class="form-control" name="section"
                                   value="{{old('section') ? : session()->get('section')}}" readonly>
                            @if ($errors->has('section'))
                                <span class="help-block">
                <strong>{{ $errors->first('section') }}</strong>
            </span>
                            @endif
                        </div>
                         @if(session()->get('section') == 'secondary') 
                        <div class="form-group{{ $errors->has('sub_section') ? ' has-error' : '' }}">
                            <label for="sub_section" class="control-label">Sub Section</label>
                            <select name="sub_section" class="form-control" id="sub_section" >
                            	<option value=""></option>
                                <option value="1">Junior</option>
                                <option value="2">Senior</option>
                            </select>
                            @if ($errors->has('sub_section'))
                                <span class="help-block">
                <strong>{{ $errors->first('sub_section') }}</strong>
            </span>
                            @endif
                        </div>
                         @else
                        <input type="hidden" value="0">
                        @endif
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Update Subject" id="saveStd" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>




    </div>
</div>