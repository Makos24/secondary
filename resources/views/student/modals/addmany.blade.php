<div class="modal fade" id="addmany" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Multiple Students</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('/students/addmany')}}" class="form-vertical">
                    {{csrf_field()}}
                    <div class="row">
                    <div class="col-lg-6">
                    <label for="no" class="control-label">Enter of Students to Add</label>
                   <input type="number" class="form-control" name="no" required>
                   </div>
                   </div>
                    <div class="modal-footer">
                        <input type="submit" value="Load" id="exportBtn" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>