<div class="modal fade" id="student" role="dialog">
<div class="modal-dialog modal-lg">

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title">Register New Student</h4>
    </div>
    <div class="modal-body">
    
        <form class="form-vertical" role="form" method="post" action="{{url("/test")}}" id="newStd">
{{--            {{csrf_field()}}--}}
            <input type="hidden" name="active" value="1">
            <a id="link" href="{{url("/checkID")}}"></a>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group" id="idDiv">
                        <label for="student_id" class="control-label">Student Reg. Number</label>
                        <input type="text" name="student_id" class="form-control" id="student_id"
                               value="" required>
                            <span class="help-block" id="idError"><strong> </strong></span>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group" id="fnDIv">
                        <label for="first_name" class="control-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name"
                               value="" required>
                            <span class="help-block" id="fnError"><strong></strong></span>
                    </div>
                </div>
                <div class="col-lg-6" id="lnDiv">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name"
                               value="" required>
                            <span class="help-block" id="lnError"><strong></strong></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group" id="onDIv">
                        <label for="other_name" class="control-label">Other Name</label>
                        <input type="text" name="other_name" class="form-control" id="other_name"
                               value="" >
                        <span class="help-block" id="onError"><strong></strong></span>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group" id="gDIv">
                        <label for="gender" class="control-label">Gender</label>
                        <select name="gender" id="gender" class="form-control" >
                            <option value=""></option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                        <span class="help-block" id="gError"><strong></strong></span>
                    </div>
                </div>
                <div class="col-lg-4" id="dobDiv">
                    <div class="form-group">
                        <label for="dob" class="control-label">Date of Birth</label>
                        <input type="text" name="dob" class="form-control" id="dobdatepicker"
                               value="" >
                        <span class="help-block" id="dobError"><strong></strong></span>
                    </div>
                </div>
                <div class="col-lg-4" id="rDIv">
                    <div class="form-group" >
                        <label for="religion" class="control-label">Religion</label>
                        <select name="religion" id="religion" class="form-control" >
                            <option value=""></option>
                            <option value="1">CHRISTIAN</option>
                            <option value="2">ISLAM</option>
                        </select>
                        <span class="help-block" id="rError"><strong></strong></span>
                    </div>
                </div>
                </div>
            <div class="row">
            <div class="col-lg-6">
                <div class="form-group" id="regDIv">
                    <label for="reg_date" class="control-label">Reg. Date</label>
                    <input type="text" name="reg_date" class="form-control" id="regdatepicker"
                           value="" >
                    <span class="help-block" id="regError"><strong></strong></span>
                </div>
            </div>
                <div class="col-lg-6">
            <div class="form-group" id="addDiv">
                <label for="location" class="control-label">Address</label>
                <textarea name="address" class="form-control" id="address" required></textarea>
                <span class="help-block" id="addError"><strong></strong></span>
            </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" id="dnDIv">
                            <label for="dad_number" class="control-label">Father's Mobile</label>
                            <input type="text" name="dad_number" class="form-control" id="dad_number"
                                   value="" required>
                            <span class="help-block" id="dnError"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-lg-6" id="mnDiv">
                        <div class="form-group">
                            <label for="mum_number" class="control-label">Mother's Mobile</label>
                            <input type="text" name="mum_number" class="form-control" id="mum_number"
                                   value="" required>
                            <span class="help-block" id="mnError"><strong></strong></span>
                        </div>
                    </div>


                </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group" id="levelDiv">
                        <label for="level" class="control-label">Class</label>
                        <select name="level" class="form-control" id="level" required>
                            <option value=""></option>
                            @if(session()->get('section') == "primary")
                            <option value="4">Primary 1</option>
                            <option value="5">Primary 2</option>
                            <option value="6">Primary 3</option>
                            <option value="7">Primary 4</option>
                            <option value="8">Primary 5</option>
                            <option value="9">Primary 6</option>
                            @elseif(session()->get('section') == "secondary")
                            <option value="10">JSS 1</option>
                            <option value="11">JSS 2</option>
                            <option value="12">JSS 3</option>
                            <option value="13">SS 1</option>
                            <option value="14">SS 2</option>
                            <option value="15">SS 3</option>
                            @endif
                        </select>
                        <span class="help-block" id="levError"><strong></strong></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group" id="classDiv">
                        <label for="class" class="control-label">Division (A,B,C)</label>
                        <select name="class" class="form-control" id="class" required>
                        	<option value=""></option>
                        	<option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                         </select>
                        <span class="help-block" id="classError"><strong></strong></span>
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