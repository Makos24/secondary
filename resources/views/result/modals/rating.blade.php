<div class="modal fade" id="rating" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Student Rating</h4>
            </div>
            <div class="modal-body">
                <form target="_blank" method="post" action="{{url('/rating')}}" class="form-vertical">
                    {{csrf_field()}}
                    @include('partials.level')
                    
                    <div class="modal-footer">
                        <input type="submit" value="Load" id="exportBtn" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>