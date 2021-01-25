$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
jQuery(document).ready(function ($) {
    //New Student Modal
    $("#add").click(function () {
        //alert('yaaaay');
        $('#student').modal('show');
    });
    //Update Student Modal
    $("#edit").click(function (e) {
        e.preventDefault();
        $('#editStudent').modal('show');
    });
//New Student form submit
    $("#newStd").on('submit', function (e) {
        e.preventDefault();
        checkID();
    });
    //New Student Verify ID function
    function checkID() {
        var form = $("#newStd");
        var id = $("#student_id").val();
        var url = $("#link").attr('href');
        $.ajax({
            type: 'post',
            url: url,
            data: {id : id},
            success: function(data){
                console.log(data);
                if(data.student_id){
                    alert('A student with ID'+data.student_id+' exists already');
                }else{
                    saveRecord();
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }
    //New Student Save Record Function
    function saveRecord() {
        var form = $("#newStd");
        var frmData = form.serialize();
        var url = form.attr('action');
        $.ajax({
            type: 'post',
            url: url,
            data: frmData,
            success: function(data){
                console.log(data);
                alert(data.sms);
                form.trigger('reset');
            },
            error: function(data) {
                var errs = data.responseJSON;
                if(errs['student_id']){
                    $("#idDiv").addClass('has-error');
                    $("#idError").html(errs['student_id']);
                }
                if(errs['first_name']){
                    $("#fnDIv").addClass('has-error');
                    $("#fnError").html(errs['first_name']);
                }
                if(errs['last_name']){
                    $("#lnDiv").addClass('has-error');
                    $("#lnError").html(errs['last_name']);
                }
                if(errs['address']){
                    $("#addDiv").addClass('has-error');
                    $("#addError").html(errs['address']);
                }
                if(errs['level']){
                    $("#levelDiv").addClass('has-error');
                    $("#levError").html(errs['level']);
                }
                if(errs['class']){
                    $("#classDiv").addClass('has-error');
                    $("#classError").html(errs['class']);
                }
                if(errs['gender']){
                    $("#gDiv").addClass('has-error');
                    $("#gError").html(errs['gender']);
                }
                if(errs['dob']){
                    $("#dobDiv").addClass('has-error');
                    $("#dobError").html(errs['dob']);
                }if(errs['religion']){
                    $("#rDiv").addClass('has-error');
                    $("#rError").html(errs['religion']);
                }
                if(errs['reg_date']){
                    $("#regDiv").addClass('has-error');
                    $("#regError").html(errs['reg_date']);
                }
                if(errs['dad_number']){
                    $("#dnDiv").addClass('has-error');
                    $("#dnError").html(errs['dad_number']);
                }if(errs['mum_number']){
                    $("#mnDiv").addClass('has-error');
                    $("#mnError").html(errs['mum_number']);
                }

            }
        });
    }
    
    
});