<div class="modal fade" id="promoteopt" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Promotion Options</h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" role="form" method="post"
                      action="{{url("/promote/student")}}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="" id="id">
                    {{csrf_field()}}
                    @include('partials.level')
                    <div class="modal-footer">
                        <input type="submit" value="Done" id="donePromote" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>