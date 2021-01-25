    <div class="modal fade" id="pay" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Payment Info</h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" role="form" method="post" action="/pay" id="newStd">
                    {{--            {{csrf_field()}}--}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="rDiv">
                                <label for="r_no" class="control-label">Receipt Number</label>
                                <input type="text" name="r_no" class="form-control" id="r_no"
                                       value="" required>
                                <span class="help-block" id="rError"><strong> </strong></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="ridDiv">
                                <label for="rstudent_id" class="control-label">Student ID Number</label>
                                <input type="text" name="rstudent_id" class="form-control" id="rstudent_id"
                                       value="" required>
                                <span class="help-block" id="ridError"><strong> </strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="dateDiv">
                                <label for="first_name" class="control-label">Date</label>
                                <input type="date" name="date" class="form-control" id="date"
                                       value="" required>
                                <span class="help-block" id="fnError"><strong></strong></span>
                            </div>
                        </div>
                        <div class="col-lg-6" id="sessionDiv">
                            <div class="form-group">
                                <label for="session" class="control-label">Session</label>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                       value="" required>
                                <span class="help-block" id="sessionError"><strong></strong></span>
                            </div>
                        </div>

                    </div>
                    <div class="form-group" id="addDiv">
                        <label for="location" class="control-label">Address</label>
                        <textarea name="address" class="form-control" id="address" required></textarea>
                        <span class="help-block" id="addError"><strong></strong></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="levelDiv">
                                <label for="level" class="control-label">Class</label>
                                <input type="text" name="class" id="rclass" class="form-control" required>
                                <span class="help-block" id="levError"><strong></strong></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="termDiv">
                                <label for="term" class="control-label">Term</label>
                                <input id="term" type="text" class="form-control" name="term"
                                       value="" required>
                                <span class="help-block" id="termError"><strong></strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="payDiv">
                                <label for="pay" class="control-label">Amount Paid</label>
                                <input type="text" name="class" id="rclass" class="form-control" required>
                                <span class="help-block" id="levError"><strong></strong></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="termDiv">
                                <label for="term" class="control-label">Term</label>
                                <input id="term" type="text" class="form-control" name="term"
                                       value="" required>
                                <span class="help-block" id="termError"><strong></strong></span>
                            </div>
                        </div>
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