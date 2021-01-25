<div class="modal fade" id="promoteopt" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Graduation Options</h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" role="form" method="post"
                      action="{{url('/promote/student')}}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="" id="id">
                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('div') ? ' has-error' : '' }}">
                                <label for="div" class="control-label">Division (A,B,C)</label>
                                <input type="text" name="div" class="form-control" id="div" required>
                                @if ($errors->has('div'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('div') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Done" id="donePromote" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>