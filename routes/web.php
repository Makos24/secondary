<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/removesc/{subject}/{class}/{div}/{session}/{term}', 'ResultController@removeSC');

Route::get('/', function () {
    if(Auth::check()){
        return redirect('/home');
    }else{
        return view('auth.login');
    }
});

Route::auth();
//Route::get('/logo/{filename}', 'SettingController@getLogoImage');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/start', function(){
        return view('admin.start');
    });
    Route::post('/start', 'AdminController@start');
    Route::get('/home', 'AdminController@index');
    //Route::get('/home', 'HomeController@index');
    Route::get('/student/new', 'StudentController@getregister');
    Route::post('/student/new', 'StudentController@registerStudent');
    Route::post('/student/edit', 'StudentController@editStudent');
    Route::get('/student/{studentId}/edit', 'StudentController@getEdit');
    Route::post('/student/{student}', 'StudentController@postEdit');
    Route::post('/student/{username}/picture', 'StudentController@savePicture');
    Route::post('/upload/picture', 'StudentController@savePic');
    Route::post('/upload/logo', 'SettingController@savePic');
    Route::get('/student/{filename}/view', 'StudentController@getUserImage');
    Route::get('/logo/{filename}', 'SettingController@getLogoImage');
    Route::get('/student/view/{filename}', 'StudentController@getUserImage');
    Route::get('/students/all', 'StudentController@students');
    Route::get('/students/data', 'StudentController@studentsDtable');
    Route::get('/students/{class}', 'StudentController@studentsByClass');
    Route::get('/student/upload', 'StudentController@getUploadStudents');
    Route::post('/students/upload', 'StudentController@postUploadStudents');
    Route::post('/students/biodata', 'StudentController@bioData');
    Route::post('/students/addmany', 'StudentController@getMany');
    Route::post('/students/postmany', 'StudentController@postMany');
    Route::get('/delete/{id}', 'StudentController@deleteStudent');
    //Route::get('/result/{resultId}', 'StudentController@getEditResult');
    //Route::post('/result/{resultId}', 'StudentController@postResult');
    Route::get('/subject/new', 'SubjectController@getNewSubject');
    Route::post('/subject/{resultId}', 'SubjectController@postNewSubject');
    Route::get('/result/add/{studentId}', 'ResultController@getNewResult');
    Route::post('/result/add', 'ResultController@postNewResult');
    Route::get('/results/upload', 'ResultController@getUploadResults');
    Route::post('/results/upload', 'ResultController@postUploadResults');
    Route::post('/results/view', 'ResultController@viewResults');
    Route::get('/results/view/{subject}/{class}/{div}/{session}/{term}', 'ResultController@viewResults');
    Route::post('/results/check', 'ResultController@checkResults');
    Route::get('/result/', 'ResultController@getResultById');
    Route::get('/searchresult', 'ResultController@postResultById');
    Route::get('/subjects', 'SubjectController@showSubjects');
    Route::get('/subjectssecondary', 'SubjectController@subjectsJSON');
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/users', 'AdminController@users');
    Route::get('/user/profile', 'AdminController@profile');
    Route::post('/admin/new', 'AdminController@create');
    Route::post('/admin/adminJSON', 'AdminController@adminJSON');
    Route::get('/profile/{studentId}', 'StudentController@getProfile');
    Route::get('/profiles', 'StudentController@getProfiles');
    Route::get('/searchstudent', 'StudentController@findStudents');
    Route::get('/searchprofile', 'StudentController@findProfile');
    Route::get('/promote', 'StudentController@getPromote');
    Route::get('/searchpromote', 'StudentController@findPromote');
    Route::get('/admin/getBtn', function () {
        if (Request::ajax()) {
            return 'it came';//just a programmers joke
        }
    });
    Route::post('/admin/register', function () {
        if (Request::ajax()) {
            return Response::json(Request::all());
            //return Response::json(Input::all());
        }
    });
    Route::post('/do', function () {
        if (Request::ajax()) {
            //return Response::json(Request::all());
            return Response::json(Input::all());
        }
    });
    Route::post('/test', 'StudentController@saveStudent');
    Route::post('/checkID', 'StudentController@checkID');
    Route::post('/promote', 'StudentController@postPromote');
    Route::post('/profileJSON', 'StudentController@profileJSON');
    Route::get('/staff', 'StaffController@allStaff');
    Route::get('/staff/new', 'StaffController@getRegisterStaff');
    Route::post('/admin/staffJSON', 'StaffController@profileJSON');
    Route::post('/staff/new', 'StaffController@registerStaff');
    Route::get('/staff/{id}/edit', 'StaffController@getEditStaff');
    Route::post('/staff/edit', 'StaffController@postEditStaff');
    Route::get('/staff/{id}/delete', 'StaffController@deleteStaff');
    Route::get('/searchbyclass', 'StudentController@studentsByClass');
    Route::get('/result/{level}/{student_id}/', 'ResultController@getClassResult');
    Route::get('/position/', 'PositionController@getPosition');
    Route::post('/position/', 'PositionController@getPositions');
    Route::get('/result/{student}/{level}/{term}/{session}', 'ResultController@getTermResult');
    Route::get('/termedit/{student}/{level}/{term}', 'ResultController@getTermResultJSON');
    Route::post('/result/updateterm', 'ResultController@updateTermResult');
    Route::get('/classes', 'ClassController@showClasses');
    Route::post('/class', 'ClassController@postNewClass');
    Route::get('/searchgraduate', 'StudentController@getGraduatesByYear');
    Route::get('/graduates', 'StudentController@getGraduates');
    Route::post('/class/promote', 'StudentController@promoteClass');
    Route::post('/students/promote', 'StudentController@promoteSelected');
    Route::post('/promote/student', 'StudentController@promoteStudent');
    Route::get('/collate', 'PositionController@getCollate');
    Route::get('/graduate', 'StudentController@getGraduate');
    Route::post('/students/graduate', 'StudentController@doGraduation');
    Route::post('/subjectJSON', 'SubjectController@subjectJSON');
    Route::post('/subjects/update', 'SubjectController@updateSubject');
    Route::get('/subject/delete/{id}', 'SubjectController@deleteSubject');
    Route::get('/deactivate/{id}', 'StudentController@deactivateStudent');
    Route::get('/inactive', 'StudentController@inactivateStudents');
    Route::get('/searchinactive', 'StudentController@inactivateStudents');
    Route::get('/activate/{id}', 'StudentController@activateStudent');
    Route::get('/pdf/{level}/{class}', 'StudentController@exportScoreSheet');
    Route::get('/settings', 'SettingController@index');
    Route::post('/settings', 'SettingController@save');
    Route::get('/termsettings', 'SettingController@getSettings');
    Route::post('/termsettings', 'SettingController@postSettings');
    Route::get('/scoresheets', 'StudentController@getScoreSheet');
    Route::post('/students/classsheet', 'StudentController@getClassSheet');
    Route::post('/scoresheets', 'StudentController@exportScoreSheet');
    Route::post('/scoresheetexcel', 'StudentController@exportScoreSheetExcel');
    Route::post('/scoresheetprint', 'StudentController@ScoreSheetPrint');
    Route::post('/scoresheetinput', 'ResultController@ScoreSheetInput');
    Route::get('/scoresheetinput', 'ResultController@getResultById');
    Route::get('/positionpdf/{class}/{div}/{term}/{session}', 'PositionController@printPositions');
    Route::get('/transcript/{studentId}', 'StudentController@printTranscript');
    Route::get('/positionexcel/{class}/{div}/{term}/{session}', 'PositionController@excelPositions');
    Route::get('/resultpdf/{level}/{student_id}/{session}', 'ResultController@getClassPdf');
    Route::get('/resultexcel/{level}/{student_id}', 'ResultController@getClassExcel');
    Route::get('/resulttpdf/{student}/{level}/{term}/{session}', 'ResultController@getTermPdf');
    Route::get('/resulttexcel/{student}/{level}/{term}/{session}', 'ResultController@getTermExcel');
    Route::post('/inputresults', 'ResultController@bulkInsert');
    Route::post('/results/ca1', 'ResultController@getCa1');
    Route::post('/results/ca2', 'ResultController@getCa2');
    Route::post('/results/exam', 'ResultController@getExam');
    Route::post('/results/ca12', 'ResultController@getCa12');
    Route::post('/results/postca1', 'ResultController@firstCa');
    Route::post('/results/postca2', 'ResultController@secondCa');
    Route::post('/results/postexam', 'ResultController@exam');
    Route::post('/results/postca12', 'ResultController@ca12');
    Route::post('/results/editca', 'ResultController@getEditCa');
    Route::post('/results/posteditca', 'ResultController@editCa');
    Route::post('/results/editresult', 'ResultController@getEditResult');
    Route::get('/editresult/{subject}/{class}/{div}/{session}/{term}', 'ResultController@getEditResult');
    Route::post('/results/posteditresult', 'ResultController@editResult');
    Route::get('/results/manage', 'ResultController@getManage');
    Route::get('/results/manageclass', 'ResultController@manageClass');
    Route::get('/results/byclass', 'ResultController@manageByClass');
    Route::get('/results/bysubject', 'ResultController@manageBySubject');
    Route::get('/transcriptpdf/{student}', 'StudentController@getTranscriptPdf');
    Route::get('/transcriptexcel/{student}', 'StudentController@getTranscriptExcel');
    Route::get('/positionprint/{class}/{div}/{term}/{session}', 'PositionController@getPrintPositions');
    Route::get('/classprint/{level}/{student_id}/{session}', 'ResultController@getClassPrint');
    Route::get('/termprint/{student}/{level}/{term}/{session}', 'ResultController@getTermPrint');
    Route::get('/bulkclass/{class}/{div}', 'ResultController@classBulk');
    Route::get('/bulkterm/{level}/{div}/{term}/{session}', 'ResultController@bulkTerm');
    Route::post('/attendance', 'AttendanceController@getAttendance');
    //Route::get('/attendance', function(){ return back()->withErrors('info', 'error');});
    Route::post('/inputattendance', 'AttendanceController@postAttendance');
    Route::post('/checkattendance', 'AttendanceController@check');
    Route::post('/viewattendance', 'AttendanceController@viewAttendance');
    Route::post('/editattendance', 'AttendanceController@editAttendance');
    Route::post('/updateattendance', 'AttendanceController@updateAttendance');
    Route::post('/rating', 'AttendanceController@getRating');
    Route::post('/editrating', 'AttendanceController@editRating');
    Route::post('/updaterating', 'AttendanceController@updateRating');
    Route::post('/viewrating', 'AttendanceController@viewRating');
    //Route::get('/rating', function(){ return back();});
    Route::post('/postrating', 'AttendanceController@postRating');
    Route::post('/checkrating', 'AttendanceController@checkRating');
    Route::post('/behaviour', 'AttendanceController@getBehaviour');
    Route::post('/postbehaviour', 'AttendanceController@postBehaviour');
    Route::post('/editbehaviour', 'AttendanceController@editBehaviour');
    Route::post('/updatebehaviour', 'AttendanceController@updateBehaviour');
    Route::post('/viewbehaviour', 'AttendanceController@viewBehaviour');
    Route::get('/logs', 'LogController@index');
    Route::get('/searchlogs', 'LogController@findLog');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/staff/profile', 'StaffController@profile')->middleware('staff');
    Route::get('/staff/students', 'StaffController@students')->middleware('staff');
    Route::post('/staff/picture', 'StaffController@savePic')->middleware('staff');
    Route::get('/staff/pwdchange', 'StaffController@getPwdChange')->middleware('staff');
    Route::post('/staff/pwdchange', 'StaffController@pwdChange')->middleware('staff');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/student', 'StudentController@index')->middleware('student');
    Route::get('/student/academics', 'StudentController@profile')->middleware('student');;
});
