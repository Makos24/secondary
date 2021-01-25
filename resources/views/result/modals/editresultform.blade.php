<div class="modal fade" id="editResultForm" role="dialog">
<div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Student Results</h4>
        </div>
        <div class="modal-body">
        <form target="_blank" class="form-vertical" role="form" method="post"
                  action="{{url('/result/updateterm')}}" >
                {{ csrf_field() }}
        <table cellspacing="0" class="table" id="editform">
        <thead>
            <tr>
                <th width="48%">SUBJECT</th>
                <th>1ST CA 15%</th>
                <th>2ND CA 15%</th>
                <th>EXAM 70%</th>
                
            </tr>
           </thead>
           <tbody id="formdiv">
           
           
           </tbody> 

        </table>
        <div class="modal-footer">
                    <input type="submit" value="Update Result" id="saveStd" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
        </form>
        </div>
    </div>
</div>
</div>