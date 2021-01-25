<div class="modal fade" id="addClass" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Class</h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" role="form" method="post"
                      action="{{url('/class')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Class Name (e.g JSS )</label>
                                <select name="name" class="form-control" id="name">
                                    <option value=""></option>
                                    <option value="1">Nursery 1</option>
                                    <option value="2">Nursery 2</option>
                                    <option value="3">Nursery 3</option>
                                    <option value="4">Primary 1</option>
                                    <option value="5">Primary 2</option>
                                    <option value="6">Primary 3</option>
                                    <option value="7">Primary 4</option>
                                    <option value="8">Primary 5</option>
                                    <option value="9">Primary 6</option>
                                    <option value="10">JSS 1</option>
                                    <option value="11">JSS 2</option>
                                    <option value="12">JSS 3</option>
                                    <option value="13">SS 1</option>
                                    <option value="14">SS 2</option>
                                    <option value="15">SS 3</option>
                                </select>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                <label for="section" class="control-label">Section (e.g A)</label>
                                <input type="text" name="section" class="form-control" id="section" required>
                                @if ($errors->has('section'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <input type="submit" value="Save" id="calc" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>