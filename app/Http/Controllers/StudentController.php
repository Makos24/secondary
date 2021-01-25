<?php

namespace Portal\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Portal\Http\Requests;
use Portal\Models\Position;
use Portal\Models\Result;
use Portal\Models\User;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Portal\Models\Subject;
use Portal\Models\Rate;
use Portal\Models\searchTerm;
use Illuminate\Pagination\Paginator;
use Auth;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function students()
    {
        return view('student.index');
    }

    public function studentsDtable()
    {
        if(session()->get('section') == "primary"){
            $users = DB::table('users')->select('*')
                ->where('level','>','3')->where('level','<','10')->
            where('active', true)->where('is_staff', false)->where('is_admin', false);
        }else if(session()->get('section') == "secondary"){
            $users = DB::table('users')->select('*')
            ->where('level','>','9')->where('level','<','16')->
            where('active', true)->where('is_staff', false)->where('is_admin', false);
        }else{
            return redirect('/start');
        }

        return DataTables::of($users)
            ->addColumn('gender', function ($user){
                if($user->gender == 1){
                    return 'Male';
                }elseif($user->gender == 2){
                    return 'Female';
                }else{
                    return '';
                }
            })->addColumn('class', function ($user){
                return $this->getClassName($user->level).''.$user->class;
            })
            ->addColumn('action', function ($user) {
                $url1 = url('/result/add/'.$user->id);
                $url2 = url('/profile/'.$user->id);
                $url3 = url('/deactivate/'.$user->id);
                return "<a href=\"#\" class=\"fa fa-edit fa-2x\" style='color: #31b0d5' title=\"Edit Student Data\"
            id=\"btn-editStudent\" 
            data-student_id=\"$user->student_id\"
            data-first_name=\"$user->first_name\"
            data-last_name=\"$user->last_name\"
            data-other_name=\"$user->other_name\"
            data-gender=\"$user->gender\"
            data-dob=\"$user->dob\"
            data-religion=\"$user->religion\"
            data-address=\"$user->address\"
            data-dad_number=\"$user->dad_number\"
            data-mum_number=\"$user->mum_number\"
            data-level=\"$user->level\"
            data-class=\"$user->class\"
            data-image=\"$user->image\"
            ></a>
            <a href=\"$url1\" style='margin-left: 5px' class=\"fa fa-plus-square fa-2x\" title=\"Add Student's Result\" ></a>
            <a href=\"$url2\" style='color: #31b0d5; margin-left: 5px' class=\"fa fa-file-text fa-2x\" title=\"View Student Profile\" ></a>
            <a href=\"$url3\" style='color: #FF0000; margin-left: 5px;' class=\"fa fa-ban fa-2x\" title=\"Deactivate Student\" id=\"deact\" ></a>";
            })->removeColumn('id')->make(true);
    }
    
//    public function __construct()
//    {
//        $this->middleware('admin', ['except' => ['index', 'getUserImage','savePic', 'profile',
//		'getProfile', 'findStudents', 'getStudents']]);
//    }
    public function registerStudent(Request $request)
    {
            $this->validate($request, ['first_name' => 'required|max:20|string',
                'last_name' => 'required|max:20|string',
                'address' => 'required|string',
                'class' => 'required',
                'level' => 'required',
                'student_id' => 'required|string'
            ]);
            $student = User::where('student_id', $request->input('student_id'));
            if ($student) {
                //session()->flash('info', 'A student with this ID Number exists already');
                $response = array(
                    'status' => 'error',
                    'msg' => 'A student with this ID Number exists already',
                );
                return Response::json($response);
        }
            User::create([
                'student_id' => $request->input('student_id'),
                'first_name' => $request->input('first_name'),
                'other_name' => $request->input('other_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'level' => $request->input('level'),
                'class' => $request->input('class'),
                'active' => true,
				'is_admin' => false,
				'is_staff' => false,
            ]);

            return back()->with('info', 'Student record saved');
        }

    public function studentById($studentId)
    {
        $student = User::where('student_id', $studentId)->first();
        if(!$student){
            session()->flash('info', 'Student record not found');
            return back();
        }
        return view('student.profile', compact('student', 'student'));
    }

    public function getRegister()
    {
        return view('student.newstudent');
    }
    public function savePicture($username, Request $request)
    {
        $student = User::where('first_name', $username)->first();
        if(!$student){

            return back()->with('info', 'User record not found');
        }
        $this->validate($request, ['image' => 'required']);
        $old_name = $student->first_name;
        $filename = $student->first_name . '-' . $student->id . '.jpg';
        $old_filename = $old_name . '-' . $student->id . '.jpg';
        $update = false;
        if (Storage::disk('students')->has($old_filename)) {
            $old_file = Storage::disk('students')->get($old_filename);
            Storage::disk('students')->put($filename, $old_file);
            $update = true;
            session()->flash('info', 'Picture exists');
        }

        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
            session()->flash('info', 'Replaced');
        }
        Storage::disk('students')->put($filename, file_get_contents($request->file('image')->getRealPath()));


        return back()->with('info', 'Picture Saved');
    }
    public function savePic(Request $request)
    {
        $student = User::where('student_id', $request->id)->first();
        if(!$student){
            session()->flash('info', 'Student record not found');
            return response()->json(array('info' => 'Record not found'));
        }
        //$this->validate($request, ['image' => 'required']);
        $old_name = $student->first_name;
        $filename = $student->first_name . '-' . $student->id . '.jpg';
        $old_filename = $old_name . '-' . $student->id . '.jpg';
        $update = false;
        if (Storage::disk('students')->has($old_filename)) {
            $old_file = Storage::disk('students')->get($old_filename);
            Storage::disk('students')->put($filename, $old_file);
            $update = true;
            //return response()->json(array('info' => 'Picture exists'));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
            response()->json(array('info', 'Image Replaced'));
        }
        Storage::disk('students')->put($filename, file_get_contents(Input::file('image')->getRealPath()));
        $student->update([
            'image' => $filename,
        ]);

        return response()->json(array('info' => 'Picture Saved'));
    }
    public function getUserImage($filename)
    {
        $file = Storage::disk('students')->get($filename);
        return new Response($file, 200);
    }
    public function getEdit($studentId)
    {
        $student = User::where('id', $studentId)->first();
        if(!$student){

            return back()->with('info', 'User record not found');
        }
        //dd($student);
        return view('student.edit', compact('student', 'student'));
    }
    public function postEdit(User $student, Request $request)
    {
        $this->validate($request, ['first_name' => 'required|max:20|string',
            'last_name' => 'required|max:20|string',
            'address' => 'required|string',
            'class' => 'required',
            'level' => 'required',
            'email' => 'email',
            'phone_number' => 'digits:11',
        ]);

        $student->update($request->all());

        return back()->with('info', 'Students record Updated');
    }
    public function editStudent(Request $request){
        $student = User::where('student_id', $request->input('student_id'))->first();
        //return response()->json($request);
        if(!$student){
            return response()->json(array('info' => 'Student Not Found'));
        }
        $student->update($request->all());

        return back()->with('info', 'Students record Updated');

        //return response()->json(array('info' => 'User Record Updated'));
    }

    public function getUploadStudents()
    {
        return view('student.upload');
    }

    public function postUploadStudents(Request $request)
    {
        $fail = array();
        $this->validate($request, [
            'class' => 'required',
            'div' => 'required|alpha|max:1',
            'students' => 'required',
        ]);

        $file = $request->file('students')->getRealPath();

        $data = Excel::load($file, function ($reader) {
            $reader->get();
        });
        // dd($data->toArray());

//        $data = Excel::load($file, function($reader){
//            $reader->select(array('name','reg_no', 'sex', 'religion', 'date_of_birth', "fathers_mobile","mothers_mobile"))->get();
//        });
        //dd($data->toArray());
        foreach ($data->toArray() as $value) {
            for ($i = 0; $i < count($value); $i++) {
                if ($value[$i]['reg_no'] == null)
                {
                    $fail[$i] = $value[$i]['name'];
                    continue;
                }


                $reg = explode('.', $value[$i]['reg_no']);
                $dno = explode('.', $value[$i]['fathers_mobile']);
                $mno = explode('.', $value[$i]['mothers_mobile']);

                if($dno[0] == ""){
                    $dno[0] = "";
                }else{
                    $dno[0] = '0'.$dno[0];
                }

                if($mno[0] == ""){
                    $mno[0] = "";
                }else{
                    $mno[0] = '0'.$mno[0];
                }


                if ($value[$i]['sex'] == 'M') {
                    $gender = 1;
                } elseif ($value[$i]['sex'] == 'F') {
                    $gender = 2;
                } else {
                    $gender = 0;
                }
                $name = explode(" ", $value[$i]['name']);
                if (isset($name[2])) {
                    $oname = $name[2];
                } else {
                    $oname = " ";
                }

                if ($value[$i]['religion'] == 'CHRISTIAN') {
                    $religion = 1;
                } elseif ($value[$i]['religion'] == 'ISLAM') {
                    $religion = 2;
                } else {
                    $religion = 0;
                }


                $check = User::where('student_id', 'SIS/0' . $reg[0])->first();
                if ($check) {
                    $check->update(['level' => $request->input('class'), 'class' => $request->input('div')]);
                    //session()->flash('info', 'User with Admission Number '.$check->student_id.' exists already');
                    // return back();
                } else {
                    User::create([
                        'student_id' => 'SIS/0' . $reg[0],
                        'first_name' => $name[0],
                        'last_name' => $name[1],
                        'other_name' => $oname,
                        'level' => $request->input('class'),
                        'class' => $request->input('div'),
                        'address' => 'ADDRESS',
                        'reg_date' => $value[$i]['reg_date'],
                        'gender' => $gender,
                        'religion' => $religion,
                        'dob' => $value[$i]['date_of_birth'],
                        'dad_number' => $dno[0],
                        'mum_number' => $mno[0],
                        'password' => bcrypt($name[0]),
                        'active' => true,
                        'is_admin' => false,
                        'is_staff' => false,
                    ]);
                }
            }

        }

        if (count($fail)) {
            $names = '';
            foreach ($fail as $f){
                $names .= $f.', ';
            }
            return back()->with('info', 'These students could not be uploaded due to lack of Reg. No '.$names);
        }

        return back()->with('info', 'Student Details Uploaded Successfully');


    }

    public function getProfile($studentId)
    {
        $student = User::with('positions','results.subject')->where('id', $studentId)->first();
        if(!$student){
            return back()->with('info', 'Student not found');
        }
        //$results = Result::with('subject')->where('student_id', $student->student_id)->orderBy('level')->get();
        $results = $student->results->sortBy('level');

        return view('student.profile', compact('results','student'));
    }

    public function getProfiles(){
		if(session()->get('section') == "primary"){
			$students = User::where('level','>','3')->where('level','<','10')->where('active', true)->where('is_staff', false)->where('is_admin', false)
		->orderBy('first_name', 'asc')->paginate(12);
		}else if(session()->get('section') == "secondary"){
			$students = User::where('level','>','9')->where('level','<','16')->where('active', true)->where('is_staff', false)->where('is_admin', false)
		->orderBy('first_name', 'asc')->paginate(12);
		}else{
				return redirect('/start');
			}
        return view('student.profiles', compact('students'));
    }

    public function findProfile(Request $request)
    {
        //$this->validate($request, ['search' => 'required']);
        $search = $request->input('search');

		if(session()->get('section') == "primary"){
			$students = User::where('student_id', $search)->orWhere('name','LIKE', "%{$search}%")
            ->where('level','>','3')->where('level','<','10')->where('active', true)
                ->where('is_staff', false)->where('is_admin', false)->paginate(12);
		}else if(session()->get('section') == "secondary"){
			$students = User::where('student_id', $search)->orWhere('name','LIKE', "%{$search}%")
            ->where('level','>','9')->where('level','<','16')->where('active', true)
                ->where('is_staff', false)->where('is_admin', false)->paginate(12);
		}else{
				return redirect('/start');
			}

        if(!count($students)){
           return back()->with('info', 'No Students found');
        }
		$students->setPath('/portal/searchprofile?search='.$request->search);
        return view('student.profiles', compact('students'));

    }
   public function getPromote(Request $request)
   {
       return view('student.promote');
   }
    public function findPromote(Request $request)
    {
        $search = $request->input('search');

        $piece = explode(" ", $search);
        if(!isset($piece[1])){
            $piece[1] = 0;
        }
		if(session()->get('section') == "primary"){
			$students = User::where('level',$request->class)
			->where('level','>','3')->where('level','<','10')
                ->where('active', true)->where('is_staff', false)
                ->where('is_admin', false)->paginate(60);
		}else if(session()->get('section') == "secondary"){
			$students = User::where('level',$request->class)
			->where('level','>','9')->where('level','<','16')
                ->where('active', true)->where('is_staff', false)
                ->where('is_admin', false)->paginate(60);
		}else{
				return redirect('/start');
			}

        if(!count($students)){
           return back()->with('info', 'No Students found');
        }
        return view('student.promote', compact('students'));
    }

    public function saveStudent(Request $request)
    {
        try{
           $val = $this->validate($request,
               ['first_name' => 'required|max:20|alpha',
                'last_name' => 'required|max:20|alpha',
                'address' => 'required|string',
                'class' => 'required',
                'level' => 'required',
                'gender' => 'required',
                'religion' => 'required',
                'dob' => 'required',
                'reg_date' => 'required',
                'dad_number' => 'required',
                'mum_number' => 'required',
                'student_id' => 'required|string',
            ]);
           User::create([
                'student_id' => $request->input('student_id'),
                'first_name' => $request->input('first_name'),
                'other_name' => $request->input('other_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'level' => $request->input('level'),
                'class' => $request->input('class'),
                'email' => $request->input('student_id'),
				'password' => bcrypt($request->input('first_name')),
               'gender' => $request->input('gender'),
               'religion' => $request->input('religion'),
               'dob' => $request->input('dob'),
               'reg_date' => $request->input('reg_date'),
               'dad_number' => $request->input('dad_number'),
               'mum_number' => $request->input('mum_number'),
                'active' => true,
				'is_admin' => false,
				'is_staff' => false,
            ]);

        //return back()->with('info', 'Students record Updated');
            return response()->json(array('sms' => 'Student Record Saved'));

        }catch (Exception $e){
            return response()->json($val);
        }
    }

    public function checkID(Request $request)
    {
        try{
            $std = User::where('student_id', $request->id)->first();
            if($std){
                return response()->json($std);
            }
            return response()->json(null);

        }catch (Exception $e){
            return response()->json($e);
        }
    }
    public function postPromote(Request $request)
    {
        $d = array();
        $i = 0;
        foreach ($request->all() as $req){
            $student = User::where('id', $req)->first();
            $student->update([
                'level' => $student->level+1,
            ]);

            $d[$i++] = $req;
        }
        //return back();
        return response()->json($d);
    }
    public function profileJSON(Request $request)
    {
        try{
        if($request->ajax()){

            $student = User::where('id', $request->id)->first();
            if(!$student){
                return response()->json(null);
            }
            $gen = '';
            $religion = '';
            if($student->gender == null){
                $gen = '';
            }if ($student->gender == 1){
                $gen = "Male";
            }if ($student->gender == 2){
                $gen = "Female";
            }if($student->religion == null){
                $religion = '';
            }if ($student->religion == 1){
                $religion = "CHRISTIAN";
            }if ($student->religion == 2){
               $religion = "ISLAM";
            }
            $data = array('fname' => $student->first_name, 'lname' => $student->last_name, 'oname' =>
            $student->other_name, 'name' => $student->getName(), 'clas' => $student->getClass(), 'dob' => $student->dob,
            'student_id' => $student->student_id, 'email' => $student->email, 'gender' => $student->gender, 'phone'
            => $student->phone, 'address' => $student->address, 'div' => $student->class, 'level' =>
            $student->getClassName($student->level), 'lev' => $student->level, 'gen' => $gen, 'image' =>
                    $student->image, 'dad_number' => $student->dad_number, 'mum_number' => $student->mum_number,
                'religion' => $student->religion, 'rel' => $religion,
            );
            return response()->json($data);
        }
        }catch (Exception $e)
        {
            return response()->json($e);
        }
    }
    public function getGraduates()
    {
        $students = User::students()->where('level', 16)->get();
        return view('graduates.index', compact('students'));
    }
    public function getGraduatesByYear(Request $request)
    {
        $students = User::where('leave_year', $request->input('search'))->
        where('level', '>', 15)->get();
        //dd(count($students));
        if(!count($students)){
            session()->flash('info', 'No Graduates Found for '.$request->input("search").' session');
            $students = User::where('level', 16)->get();
        return view('graduates.index', compact('students'));
        }
        return view('graduates.index', compact('students'));
    }

    public function promoteClass(Request $request)
    {
        $this->validate($request, [
            'class1' => 'required',
            'class2' => 'required',
            'div1' => 'required',
            'div2' => 'required',
        ]);
        $students = User::where('level', $request->input('class1'))
            ->where('class',$request->input('div1'))->where('active', true)->get();
        if(!count($students)){

            return back()->with('info', 'No students to promote');
        }
        foreach ($students as $student){
            $student->update([
                'level' => $request->input('class2'),
                'class' => $request->input('div2'),
            ]);
        }

		return redirect('/promote')->with('info', $this->getClassName($request->input('class1')).$request->input('div1').
            ' Students promoted to '.$this->getClassName($request->input('class2')).$request->input('div2'));

    }
    public function getClassName($level)
    {
        if($level <= 3 && $level > 0){
            return "NURSERY ".$level;
        }elseif ($level > 3 && $level < 10) {
            return "PRIMARY ".($level - 3);
        }elseif ($level > 9 && $level < 13){
            return "JSS ".($level - 9);
        }elseif ($level > 12 && $level < 16){
            return "SS ".($level - 12);
        }
    }

    public function promoteSelected(Request $request)
    {
        $names = $request->input('names');
        foreach ($names as $name){
            $student = User::where('id', $name)->first();
            $student->update([
                'level' => $request->input('class'),
                'class' => $request->input('div'),
            ]);
        }
        return redirect('/promote')->with('info', 'Selected students were promoted successfully');
    }

    public function getGraduate()
    {
		if(session()->get('section') == "primary"){
			$students = User::students()->where('level', 9)->get();
		}else if(session()->get('section') == "secondary"){
			$students = User::students()->where('level', 15)->get();
		}else{
				return redirect('/start');
			}
        return view('graduates.graduate', compact('students'));
    }

    public function doGraduation(Request $request)
    {
        $names = $request->input('names');
		if(session()->get('section') == "primary"){
			foreach ($names as $name){
            $student = User::where('id', $name)->first();
            $student->update([
                'level' => 16,
                'leave_year' => $request->input('year'),
            ]);

        }
		}else if(session()->get('section') == "secondary"){
			foreach ($names as $name){
            $student = User::where('id', $name)->first();
            $student->update([
                'level' => 17,
                'leave_year' => $request->input('year'),
            ]);

        }
		}else{
				return redirect('/start');
			}


        return back()->with('info', 'Done');
    }

    public function deactivateStudent($id)
    {
        $student = User::where('id', $id)->first();
        if(!$student){
            return back()->with('info', 'Student not found');
        }
        $student->update([
            'active' => false,
        ]);

			return redirect('/inactive')->with('info', $student->getName().' deactivated');
    }

    public function inactivateStudents()
    {
		if(session()->get('section') == "primary"){
			$students = User::where('active', false)->where('is_staff', false)->where('is_admin', false)->where('level','>','3')
			->where('level','<','10')->paginate(30);
		}else if(session()->get('section') == "secondary"){
			$students = User::where('active', false)->where('level','>','9')
			->where('level','<','16')->paginate(30);
		}else{
				return redirect('/start');
			}
        return view('student.inactive', compact('students'));
    }



    public function findInactive(Request $request)
    {
        $search = $request->input('search');


		if(session()->get('section') == "primary"){
			$students = User::where('student_id', $search)->orWhere('name','LIKE', "%{$search}%")
            ->where('level','>','3')->where('level','<','10')->where('active', false)
                ->where('is_staff', false)->where('is_admin', false)->paginate(60);
		}else if(session()->get('section') == "secondary"){
			$students = User::where('student_id', $search)->orWhere('name','LIKE', "%{$search}%")
            ->where('level','>','9')->where('level','<','16')->where('active', false)
                ->where('is_staff', false)->where('is_admin', false)->paginate(60);
		}else{
				return redirect('/start');
			}

        if(!count($students)){
           	return back()->with('info', 'No Students found');
        }
        return view('student.inactive', compact('students'));

    }

    public function activateStudent($id)
    {
        $student = User::where('id', $id)->first();
        if(!$student){

            return back()->with('info', 'Student not found');
        }
        $student->update([
            'active' => true,
        ]);

        return back()->with('info', $student->student_id.' Reactivated');

    }

    public function promoteStudent(Request $request)
    {
        $student = User::where('id', $request->input('id'))->first();
        if(!$student){

            return back()->with('info', 'No student to promote');
        }
        $student->update([
            'level' => $request->input('class'),
            'class' => $request->input('div'),
        ]);

            return back()->with('info', 'Student promoted');
    }

    public function exportScoreSheet(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        $pdf = \PDF::loadView('pdf.scoresheet', ['students' => $students, 'class' => $cname]);
        return $pdf->stream($cname.'.pdf');
    }
    public function ScoreSheetPrint(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        return view('pdf.scoresheet', ['students' => $students, 'class' => $cname]);
    }

	public function getClassSheet(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('is_staff', false)->where('is_admin', false)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
                if($level >= 10 && $level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else if($level >= 13 && $level < 15){
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}

		}else{
				return redirect('/start');
			}

			$pdf = \PDF::loadView('pdf.classsheet',
			['students' => $students, 'class' => $cname, 'subjects' => $subjects]);
			$pdf->setPaper('a4')->setOrientation('landscape');
        return $pdf->inline($cname.'.pdf');

    }

	public function bioData(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::students()->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        return view('pdf.biodata', ['students' => $students, 'class' => $cname]);
    }

    public function exportScoreSheetExcel(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::students()->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        Excel::create('ScoreSheet', function($excel) use($students, $cname){

            $excel->sheet('Score', function($sheet) use($students, $cname) {

                $sheet->loadView('pdf.scoresheet', ['students' => $students, 'class' => $cname]);

            });
        })->export('xls');
    }

    public function getScoreSheet()
    {
        return view('pdf.index');
    }
	public function getScoreSheetPrimary()
    {
        return view('pdf.index');
    }
	public function getScoreSheetSecondary()
    {
        return view('pdf.index');
    }

    public function tStuff($studentId)
    {
        $student = User::with('positions', 'attendances','rates','results')
            ->where('id', $studentId)->first();
        $results = $student->results;
        return compact('student', 'results');
    }

    public function printTranscript($studentId)
    {
        return view('pdf.transcript', $this->tStuff($studentId));
        //$pdf->inline();
    }

    public function getTranscriptPdf($studentId)
    {

        $pdf = \PDF::loadView('pdf.transcript', $this->tStuff($studentId));
        return $pdf->inline($studentId.'.pdf');
    }

    public function getTranscriptExcel($studentId)
    {
       Excel::create($studentId.'-Transcript', function($excel) use($studentId){
            $excel->sheet('New sheet', function($sheet) use($studentId) {
                $sheet->loadView('pdf.transcript', $this->tStuff($studentId));
            });
        })->export('xls');
    }

    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public function deleteStudent($id)
    {
		$student = User::where('id',$id)->first();
		$st = $student->student_id;
		$result = Result::where('student_id', $student->student_id)->delete();
		$position = Position::where('student_id', $student->student_id)->delete();
		$student = User::where('id',$id)->delete();


            return back()->with('info', 'Student Records Deleted');
    }
	public function index()
	{
		return view('student.page');
	}
	public function profile()
    {
        return view('student.academics', $this->getProfile(Auth::user()->id));
    }

	public function getMany(Request $request)
    {
        $no = $request->input('no');

        return view('student.addmany', compact('no'));
    }
	public function postMany(Request $request)
	{
		$fail = array();

    for($i = 0; $i < count($request->id); $i++){
	$check = User::where('student_id', $request->id[$i])->first();
	if($check){
		$fail[] = $request->first_name[$i].' '.$request->last_name[$i].' '.$request->other_name[$i].', ';
		continue;
		}else{
			User::create([
				'student_id' => $request->id[$i],
				'first_name' => $request->first_name[$i],
				'last_name' => $request->last_name[$i],
				'other_name' => $request->other_name[$i],
				'level' => $request->level[$i],
				'class' => $request->div[$i],
				'address' => $request->address[$i],
				'reg_date' => 0,
				'gender' => $request->gender[$i],
				'religion' => $request->religion[$i],
				'dob' => $request->dob[$i],
				'dad_number' => $request->fathers_mobile[$i],
				'mum_number' => $request->mothers_mobile[$i],
				'password' => bcrypt($request->first_name[$i]),
				'active' => true,
				'is_admin' => false,
				'is_staff' => false,
			]);

			}
		}
		if(count($fail)){
			foreach($fail as $f){
				$fa = $f;
				}
			return redirect('/students/all')->with('info', 'The following were not registered because their Admission numbers already exist '.$f);
			}

		return redirect('/students/all')->with('info', 'students saved successfully');
	}

}
