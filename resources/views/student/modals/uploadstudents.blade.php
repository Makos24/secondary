<div class="modal fade" id="studentupload" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Import Students From Excel </h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" role="form" method="post"
                      action="{{url("/students/upload")}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @include('partials.level')

                    <div class="form-group{{ $errors->has('students') ? ' has-error' : '' }}">
                        <label for="students" class="control-label">Upload File</label>
                        <input type="file" name="students" class="btn btn-default" id="students" required>
                        @if ($errors->has('students'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('students') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Save" id="saveStd" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>