<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Portal\Http\Requests;
use Portal\Models\Staff;
use Portal\Models\Student;
use Portal\Models\User;
use Portal\Models\Log;
use Portal\Models\Attendance;
use Portal\Models\Rate;
use Portal\Models\Behave;
use Illuminate\Support\Facades\Input;
use Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
		
        $this->middleware('auth');
    }
	
	public function getAttendance(Request $request){
		$level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->get();		
        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		
        return view('attendance.attendance', ['students' => $students,
		 'class' => $cname,]);
	}
	public function postAttendance(Request $request)
	{
		 $this->validate($request, [
            'term' => 'required|numeric',
            'session' => 'required|numeric',
            'class' => 'required|numeric',
			'div' => 'required',
        ]);
		for($i = 0; $i < count($request->id); $i++){
			$check = Attendance::whereRaw('student_id=? AND term=? AND session=? AND class=? AND div=?',
		 [$request->id[$i], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('div')])->first();
		if (isset($check)) {
			$check->update(['present' => $request->present[$i], 'late' => $request->late[$i],
			 'total' => $request->total]);
                        
		} else {
			Attendance::create([
			'student_id' => $request->id[$i],
			'present' => $request->present[$i],
			'late' => $request->late[$i],
			'total' => $request->input('total'),
			'term' => $request->input('term'),
			'session' => $request->input('session'),
			'class' => $request->input('class'),
			'div' => $request->input('div'),
			]);
		}
		}
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Saved '.$this->getClassName($request->class).''.$request->div.'
		 Attendance for '.$request->term.' Term '.$request->session.' Session',
		]);
		return redirect('result')->with('info', 'Attendance saved');
	}
	
	public function check(Request $request)
	{
		$result = Attendance::where('session', $request->session)
		 ->where('term', $request->term)->where('class', $request->class)
		 ->where('div', $request->div)->get();
		 
		 if(count($result)){
			 return response()->json("exists");
			 }else{
				  return response()->json("not");
				 }
	}
	
	public function viewAttendance(Request $request)
	{
		$results = Attendance::where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(count($results)){
		foreach($results as $result){
			$student = User::where('student_id', $result->student_id)->first();
			if($student){
			$res[] = array('id' => $result->student_id, 'present' => $result->present, 
			'total' => $result->total, 'name' => $student->getName() );
			}
			}
		}else{
        	return back()->with('info', 'Attendance not found');
			}
			$data = array('term' => $this->term($request->term), 'session' => $request->session, 
			'class' => $this->getClassName($request->class).$request->div, 'term_id' => $request->term,
			 'div' => $request->div, 'class_id' => $request->class);
			//dd($data);
			return view('attendance.attendsheet', compact('data', 'res'));
	} 
	
	public function editAttendance(Request $request)
	{
		$results = Attendance::where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(count($results)){
		foreach($results as $result){
			$student = User::where('student_id', $result->student_id)->first();
			if($student){
			$res[] = array('id' => $result->student_id, 'present' => $result->present, 
			'late' => $result->late, 'total' => $result->total, 'name' => $student->getName() );
			}
			}
		}else{
        	return back()->with('info', 'Attendance not found');
			}
			$data = array('term' => $this->term($request->term), 'session' => $request->session, 
			'class' => $this->getClassName($request->class).$request->div, 'term_id' => $request->term,
			 'div' => $request->div, 'class_id' => $request->class);
			//dd($data);
			return view('attendance.editattendance', compact('data', 'res'));
	} 
	public function updateAttendance(Request $request)
	{
		 
		for($i = 0; $i < count($request->id); $i++){
			$check = Attendance::whereRaw('student_id=? AND term=? AND session=? AND class=? AND div=?',
		 [$request->id[$i], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('div')])->first();
		if (isset($check)) {
			$check->update(['present' => $request->present[$i], 'late' => $request->late[$i],
			 'total' => $request->total]);
                        
		} 
		}
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Updated '.$this->getClassName($request->class).''.$request->div.'
		 Attendance for '.$request->term.' Term '.$request->session.' Session',
		]);
		return redirect('result')->with('info', 'Attendance Updated');
	}
	public function getRating(Request $request)
	{
		$level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->get();		
        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		
        return view('attendance.rating', ['students' => $students,
		 'class' => $cname,]);
	}
	
	public function postRating(Request $request)
	{
		 $this->validate($request, [
            'term' => 'required|numeric',
            'session' => 'required|numeric',
            'class' => 'required|numeric',
			'div' => 'required',
        ]);
		for($i = 0; $i < count($request->id); $i++){
			$check = Rate::whereRaw('student_id=? AND term=? AND session=? AND class=? AND div=?',
		 [$request->id[$i], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('div')])->first();
		if (isset($check)) {
			$check->update([
			  "punctuality" => $request->punctuality[$i], 
			  "attendance" => $request->attendance[$i],
			  "assignments" => $request->assignment[$i],
			  "perseverance" => $request->perseverance[$i],
			  "self_control" => $request->self_control[$i],
			  "self_confidence" => $request->self_confidence[$i],
			  "endurance" => $request->endurance[$i],
			  "respect" => $request->respect[$i],
			  "relationship" => $request->relationship[$i],
			  "leadership" => $request->leadership[$i],
			  "honesty" => $request->honesty[$i],
			  "neatness" => $request->neatness[$i],
			  "responsibility" => $request->responsibility[$i],
			  "sports" => $request->sports[$i],
			  "skills" => $request->skills[$i],
			  "group_projects" => $request->group_projects[$i],
			  "merit" => $request->merit[$i],]);
                        
		} else {
			Rate::create([
			'student_id' => $request->id[$i],
			'term' => $request->input('term'),
			'session' => $request->input('session'),
			'class' => $request->input('class'),
			'div' => $request->input('div'),
			 "punctuality" => $request->punctuality[$i], 
			  "attendance" => $request->attendance[$i],
			  "assignments" => $request->assignment[$i],
			  "perseverance" => $request->perseverance[$i],
			  "self_control" => $request->self_control[$i],
			  "self_confidence" => $request->self_confidence[$i],
			  "endurance" => $request->endurance[$i],
			  "respect" => $request->respect[$i],
			  "relationship" => $request->relationship[$i],
			  "leadership" => $request->leadership[$i],
			  "honesty" => $request->honesty[$i],
			  "neatness" => $request->neatness[$i],
			  "responsibility" => $request->responsibility[$i],
			  "sports" => $request->sports[$i],
			  "skills" => $request->skills[$i],
			  "group_projects" => $request->group_projects[$i],
			  "merit" => $request->merit[$i],
			]);
		}
		}
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Saved '.$this->getClassName($request->class).''.$request->div.'
		 Rating for '.$request->term.' Term '.$request->session.' Session',
		]);
		return redirect('result')->with('info', 'Rating saved');	
	}
	
	public function editRating(Request $request)
	{
		$rating = Rate::where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(!count($rating)){
			return back()->with('info', 'No rating found');
		}
		$data = array('term' => $this->term($request->term), 'session' => $request->session, 
			'class' => $this->getClassName($request->class).$request->div, 'term_id' => $request->term,
			 'div' => $request->div, 'class_id' => $request->class);
			 
		return view('attendance.editrating', compact('rating', 'data'));
	}
	
	public function updateRating(Request $request)
	{
		for($i = 0; $i < count($request->id); $i++){
			$check = Rate::whereRaw('student_id=? AND term=? AND session=? AND class=? AND div=?',
		 [$request->id[$i], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('div')])->first();
		if (isset($check)) {
			$check->update([
			  "punctuality" => $request->punctuality[$i], 
			  "attendance" => $request->attendance[$i],
			  "assignments" => $request->assignment[$i],
			  "perseverance" => $request->perseverance[$i],
			  "self_control" => $request->self_control[$i],
			  "self_confidence" => $request->self_confidence[$i],
			  "endurance" => $request->endurance[$i],
			  "respect" => $request->respect[$i],
			  "relationship" => $request->relationship[$i],
			  "leadership" => $request->leadership[$i],
			  "honesty" => $request->honesty[$i],
			  "neatness" => $request->neatness[$i],
			  "responsibility" => $request->responsibility[$i],
			  "sports" => $request->sports[$i],
			  "skills" => $request->skills[$i],
			  "group_projects" => $request->group_projects[$i],
			  "merit" => $request->merit[$i],]);
                        
		}
		}
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Updated '.$this->getClassName($request->class).''.$request->div.'
		 Rating for '.$request->term.' Term '.$request->session.' Session',
		]);
		return redirect('result')->with('info', 'Rating Updated');	
	}
	
	
	public function viewRating(Request $request)
	{
		$rating = Rate::where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(!count($rating)){
			return back()->with('info', 'No rating found');
		}
		$data = array('term' => $this->term($request->term), 'session' => $request->session, 
			'class' => $this->getClassName($request->class).$request->div, 'term_id' => $request->term,
			 'div' => $request->div, 'class_id' => $request->class);
			 
		return view('attendance.viewrating', compact('rating', 'data'));
	}
	
	public function checkRating(Request $request)
	{
		$result = Rate::where('session', $request->session)
		 ->where('term', $request->term)->where('class', $request->class)
		 ->where('div', $request->div)->get();
		 
		 if(count($result)){
			 return response()->json("exists");
			 }else{
				  return response()->json("not");
				 }
	}
	
	public function getBehaviour(Request $request){
		$level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->get();		
        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		
        return view('attendance.behaviour', ['students' => $students,
		 'class' => $cname,]);
		
		}
		
	public function postBehaviour(Request $request){
		$this->validate($request, [
            'term' => 'required|numeric',
            'session' => 'required|numeric',
            'class' => 'required|numeric',
			'div' => 'required',
        ]);
		for($i = 0; $i < count($request->id); $i++){
			$check = Behave::whereRaw('student_id=? AND term=? AND session=? AND class=? AND div=?',
		 [$request->id[$i], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('div')])->first();
	if (isset($check)) {
		$check->update(['behaviour' => $request->behaviour[$i], 'appearance' => $request->appearance[$i],
		]);
                        
		} else {
			Behave::create([
			'student_id' => $request->id[$i],
			'behaviour' => $request->behaviour[$i],
			'appearance' => $request->appearance[$i],
			'term' => $request->input('term'),
			'session' => $request->input('session'),
			'class' => $request->input('class'),
			'div' => $request->input('div'),
			]);
		}
		}
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Saved '.$this->getClassName($request->class).''.$request->div.'
		 Behaviour for '.$request->term.' Term '.$request->session.' Session',
		]);
		return redirect('result')->with('info', 'Behaviour/Appearance saved');
		}	
	public function editBehaviour(Request $request)
	{
		$behaviour = Behave::where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(!count($behaviour)){
			return back()->with('info', 'No behaviour found');
		}
		foreach($behaviour as $behave){
			$behaviours[] = array('appearance' => $behave->appearance, 'behaviour' => $behave->behaviour, 
			'app' => $this->getApp($behave->appearance), 'be' => $this->getBe($behave->behaviour), 
			'student_id' => $behave->student_id, 
			'name' => User::where('student_id', $behave->student_id)->first()->getName());
			}
		$data = array('term' => $this->term($request->term), 'session' => $request->session, 
			'class' => $this->getClassName($request->class).$request->div, 'term_id' => $request->term,
			 'div' => $request->div, 'class_id' => $request->class);
			 
		return view('attendance.editbehaviour', compact('behaviours', 'data'));
	}
	
	public function updateBehaviour(Request $request){
		$this->validate($request, [
            'term' => 'required|numeric',
            'session' => 'required|numeric',
            'class' => 'required|numeric',
			'div' => 'required',
        ]);
		for($i = 0; $i < count($request->id); $i++){
			$check = Behave::whereRaw('student_id=? AND term=? AND session=? AND class=? AND div=?',
		 [$request->id[$i], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('div')])->first();
	if (isset($check)) {
		$check->update(['behaviour' => $request->behaviour[$i], 'appearance' => $request->appearance[$i],
		]);
                        
		} 
		}
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Updated '.$this->getClassName($request->class).''.$request->div.'
		 Behaviour for '.$request->term.' Term '.$request->session.' Session',
		]);
		return redirect('result')->with('info', 'Behaviour/Appearance updated');
		}	
	public function viewBehaviour(Request $request)
	{
		$behaviour = Behave::where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(!count($behaviour)){
			return back()->with('info', 'No behaviour found');
		}
		foreach($behaviour as $behave){
			$behaviours[] = array('appearance' => $behave->appearance, 'behaviour' => $behave->behaviour, 
			'app' => $this->getApp($behave->appearance), 'be' => $this->getBe($behave->behaviour), 
			'student_id' => $behave->student_id, 
			'name' => User::where('student_id', $behave->student_id)->first()->getName());
			}
		$data = array('term' => $this->term($request->term), 'session' => $request->session, 
			'class' => $this->getClassName($request->class).$request->div, 'term_id' => $request->term,
			 'div' => $request->div, 'class_id' => $request->class);
			 
		return view('attendance.viewbehaviour', compact('behaviours', 'data'));
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
	
	public function term($i)
    {
        $text = "";
        if($i == 1){
            $text = "FIRST";
        }elseif ($i == 2){
            $text = "SECOND";
        }elseif ($i == 3){
            $text = "THIRD";
        }
        return $text;
    }
	
	public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
	public function getApp($app)
	{
		if($app == 1){
			return 'SMART';
		}else if($app == 2){
			return 'NEAT';
		}else if($app == 3){
			return 'GOOD';
		}else if($app == 4){
			return 'DIRTY';
		}else if($app == 5){
			return 'ROUGH';
		}
			
	}
	public function getBe($app)
	{
		if($app == 1){
			return 'WELL BEHAVED';
		}else if($app == 2){
			return 'GOOD CONDUCT';
		}else if($app == 3){
			return 'GOOD';
		}else if($app == 4){
			return 'SATISFACTORY';
		}else if($app == 5){
			return 'PLAYFUL';
		}
			
	}
	
}
