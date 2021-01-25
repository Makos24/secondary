<div class="modal fade" id="addlogo" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="title">Update School Logo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="col-md-6">

                            <img id="iconprev" src="" class="media-object" width="150px" height="150px">
                        </div>
                        <form id="frmLogo" enctype="multipart/form-data" name="logoForm" method="post"
                              action="{{url("/upload/logo")}}">
                            {{csrf_field()}}
                            <input type="file" class="form-group" id="logoFile" name="image" required>
                            <button type="submit" class="btn btn-primary" id="savePic">Update Logo</button>
                        </form>
                    </div>
                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>




    </div>
</div>