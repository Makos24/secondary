<?php
namespace Portal\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Portal\Http\Requests;
use Portal\Models\Position;
use Portal\Models\Result;
use Portal\Models\Setting;
use Portal\Models\User;
use Portal\Models\Subject;
use Portal\Models\Log;
use Portal\Models\Rate;
use Portal\Models\Behave;
use Portal\Models\Attendance;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
class ResultController extends Controller
{
    protected $id;
    protected $class;
    protected $product;
    protected $res = array();

    public function index()
    {

		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			$subjects = Subject::where('section','secondary')->get();
		}else{
				return redirect('/start');
			}

        return view('result.index', compact('subjects'));
    }
    public function getNewResult($studentId)
    {
        $student = User::where('id', $studentId)->first();
        if(!$student){
            return back()->with('info', 'Student record not found');
        }
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			if($student->level >= 10 && $student->level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else{
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}
		}else{
				return redirect('/start');
			}

        return view('result.newresult', compact('student', 'subjects'));
    }
    public function postNewResult(Request $request)
    {
        $this->validate($request, [
           'full_name' => 'required',
            'ca1' => 'required|numeric',
			'ca2' => 'required|numeric',
            'exam' => 'required|numeric',
            'subject' => 'required',
            'term' => 'required|numeric',
            'session' => 'required|numeric',
        ]);
        $result = Result::where('student_id',$request->input('student_id'))
            ->where('subject_id', $request->input('subject'))->where('term', $request->input('term'))
            ->where('session', $request->input('session'))->where('class', $request->input('class'))
			->where('div', $request->input('div'))->first();

        if($result){
            $result->update([
                    'ca1' => $request->input('ca1'),
					'ca2' => $request->input('ca2'),
                    'exam' => $request->input('exam'),
            ]);
			Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Updated '.$request->student_id.'\'s '.Subject::find($request->subject)->title.' result',
		]);
            return back()->with('info', 'Result Updated');
        }
        $done = Result::create([
            'student_id' => $request->input('student_id'),
            'subject_id' => $request->input('subject'),
            'ca1' => $request->input('ca1'),
			'ca2' => $request->input('ca2'),
            'exam' => $request->input('exam'),
            'term' => $request->input('term'),
            'session' => $request->input('session'),
            'class' => $request->input('class'),
			'div' => $request->input('div'),
			'position' => 0,
        ]);

			 Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Saved '.$request->student_id.'\'s '.Subject::find($request->subject)->title.' result',
		]);

		return back()->with('info', 'Result Saved');

    }
    public function getEditResults($resultId)
    {
        $result = Result::where('id', $resultId)->first();
        return view('result.newresult', compact('result', 'result'));
    }
    public function getResultById()
    {
        if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			$subjects = Subject::where('section','secondary')->get();
		}else{
				return redirect('/start');
			}
        return view('result.index', compact('subjects'));
    }

    public function getUploadResults()
    {
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			$subjects = Subject::where('section','secondary')->get();
		}else{
				return redirect('/start');
			}
        return view('result.upload', compact('subjects'));
    }

    public function postUploadResults(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'term' => 'required|numeric',
            'session' => 'required|numeric',
            'results' => 'required',
            'class' => 'required|numeric',
			'div' => 'required',
        ]);
        //dd($request);
        $file = $request->file('results')->getRealPath();

        $data = Excel::load($file, function($reader){
            $reader->get();
        });
        $d = $data->toArray();
        for($i = 0; $i < count($d[0]); $i++){
            $result[] = array('student_id' => $d[0][$i]['student_id'],
                'ca1' => $d[0][$i]['ca1'], 'ca2' => $d[0][$i]['ca2'], 'exam' => $d[0][$i]['exam'],
                'total' => ($d[0][$i]['ca1']+$d[0][$i]['ca2']+$d[0][$i]['exam']));
        }

        $dd = new Collection($result);
        $sorted = $dd->sortByDesc('total')->all();
        //dd($sorted);
        //$sorted = $data->sortBy('total')->all();
        $k = 0;
foreach ($sorted as $value) {
		$check = Result::whereRaw('student_id=? AND term=? AND session=? AND class=? AND subject_id=?',
			[$value['student_id'], Input::get('term'), Input::get('session'),
				Input::get('class'), Input::get('subject')])->first();
		if (isset($check)) {
			$check->update(['ca1' => $value['ca1'], 'ca2' => $value['ca2'], 'exam' => $value['exam'],'position'=> ++$k]);

		} else {

			Result::create([
			'subject_id' => $request->input('subject'),
			'student_id' => $value['student_id'],
			'ca1' => $value['ca1'],
			'ca2' => $value['ca2'],
			'exam' => $value['exam'],
			'term' => $request->input('term'),
			'session' => $request->input('session'),
			'class' => $request->input('class'),
			'div' => $request->input('div'),
			'position' => ++$k,
			]);
		}
	}
	 Log::create([
'user_id' => Auth::user()->id,
'action' => 'Uploaded '.$this->getClassName($request->class).''.$request->div.' '.Subject::find($request->subject)->title.' results',
]);

return back()->with('info', 'Result Uploaded Successfully');
}
    public function grade($total)
    {
        if($total > 79){
            return 'A';
        }elseif ($total > 59 && $total < 80){
            return 'B';
        }elseif ($total > 49 && $total < 60){
            return 'C';
        }elseif ($total > 39 && $total < 50){
            return 'D';
        }elseif($total < 40){
            return 'F';
        }
    }
    public function remark($grade)
    {
        if($grade >= 80){
            return 'Excellent';
        }elseif($grade >= 70 && $grade < 80 ){
            return 'Very Good';
        }elseif ($grade >= 60 && $grade < 70){
            return 'Good';
        }elseif ($grade >= 50 && $grade < 60){
            return 'Credit';
		}elseif ($grade >= 40 && $grade < 50){
            return 'Fair';
        }else{
            return 'Poor';
        }
    }



    public function getClassResult($level, $student_id){

        $student = User::with('positions', 'attendances','rates','results')->where('id', $student_id)->first();
        if(!$student){
        return back()->with('info', 'Student not found');
        }
        $results = $student->results->where('class', $level);

        return view('student.class', compact('student','results'));
    }
    public function getTermResult($student, $level, $term, $session)
    {
		if(User::find($student))
        return view('student.term', $this->termStuff($student, $level, $term, $session));
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

	public function checkResults(Request $request){
		 $result = Result::where('subject_id', $request->subject)->where('session', $request->session)
		 ->where('term', $request->term)->where('class', $request->class)
		 ->where('div', $request->div)->get();

		 if(count($result)){
			 return response()->json("exists");
			 }else{
				  return response()->json("not");
				 }
		}
	public function viewResults(Request $request){
		$results = Result::where('subject_id', $request->subject)->where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(count($results)){
		foreach($results as $result){
			$student = User::where('student_id', $result->student_id)->first();
			if($student){
			$res[] = array('id' => $result->student_id, 'ca1' => $result->ca1, 'ca2' => $result->ca2,
			 'exam' => $result->exam, 'total' => $result->ca1+$result->ca2+$result->exam, 'grade' =>
			 $this->grade($result->ca1+$result->ca2+$result->exam),
			'name' => $student->getName(), 'position' => $this->ordinal($result->position));
			}
			}
		}else{
        	return back()->with('info', 'Results not found');
			}
			$subject = Subject::where('id', $request->subject)->first();
			$data = array('term' => $this->term($request->term), 'session' => $request->session,
			'subject' => $subject->title, 'class' => $this->getClassName($request->class).$request->div);
			//dd($data);
			return view('pdf.resultSheet', compact('data', 'res'));
		}

    public function classStuff($level, $student_id, $session)
    {
        $student = User::with('positions', 'attendances','rates','results')
            ->where('id', $student_id)->first();

        $results = $student->results->where('class', $level)
            ->where('session', $session)->sortBy('subject_id');
        $levels = $results->groupBy('class');
            return compact('student', 'levels','level','session');
    }

    public function getClassPrint($level, $student_id, $session)
    {
        return view('pdf.class', $this->classStuff($level, $student_id,$session));
    }

    public function getClassPdf($level, $student_id, $session)
    {
		$student = User::where('id', $student_id)->first();
        $pdf = \PDF::loadView('pdf.class', $this->classStuff($level, $student_id, $session));
        return $pdf->stream($student_id.$level.'.pdf');
    }

    public function getTermPdf($student, $level, $term, $session)
    {
        $pdf = \PDF::loadView('pdf.term', $this->termStuff($student, $level, $term, $session));
        $pdf->setPaper('a4')->setOrientation('portrait');
        return $pdf->inline($student.$level.'.pdf');
    }

    public function getTermPrint($student, $level, $term, $session)
    {
			//dd($this->termStuff($student, $level, $term));
         return view('result.term', $this->termStuff($student, $level, $term, $session));
    }



    public function getTermExcel($student, $level, $term, $session)
    {
	//dd($this->termStuff($student, $level, $term));
        Excel::create('Term', function($excel) use($student, $level, $term, $session){

            $excel->sheet('term', function($sheet) use($student, $level, $term, $session) {

               $sheet->loadView('pdf.term', $this->termStuff($student, $level, $term, $session) );

            });
        })->export('xls');
    }
    public function getClassExcel($level, $student_id)
    {
		$student = User::where('id', $student_id)->first();
        $store = $this->classStuff($level, $student_id);
        Excel::create('Class', function($excel) use($store, $student){

            $excel->sheet('class', function($sheet) use($store, $student) {

                $sheet->loadView('pdf.class', compact('store', 'student'));

            });
        })->export('xls');
    }
    public function termStuff($student, $level, $term, $session)
    {
        $student = User::with('positions', 'attendances','rates','results')->where('id', $student)->first();
        if(!$student){
           return back()->with('info', 'Student not found');
        }
        if ($term == 3){
            $results = $student->results->where('class', $level)
            ->where('session', $session)->sortBy('subject_id');
        }else{
            $results = $student->results->where('class', $level)->
            where('term', $term)->where('session', $session)->sortBy('subject_id');
        }


        return compact('student','results','term','session','level');
    }

    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

	public function ScoreSheetInput(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)
		->orderBy('student_id', 'asc')->get();

        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			if($level >= 10 && $level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else{
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}

		}else{
				return redirect('/start');
			}
        return view('pdf.scoreinput', ['students' => $students,
		 'class' => $cname, 'subjects' => $subjects]);
    }

	public function getCa1(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->orderBy('student_id', 'asc')->get();

        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			if($level >= 10 && $level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else{
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}
		}else{
				return redirect('/start');
			}
        return view('pdf.ca1', ['students' => $students,
		 'class' => $cname, 'subjects' => $subjects]);
    }

	public function getCa2(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->orderBy('student_id', 'asc')->get();

        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			if($level >= 10 && $level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else{
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}
		}else{
				return redirect('/start');
			}
        return view('pdf.ca2', ['students' => $students,
		 'class' => $cname, 'subjects' => $subjects]);
    }

	public function getExam(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->orderBy('student_id', 'asc')->get();

        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			if($level >= 10 && $level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else{
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}
		}else{
				return redirect('/start');
			}
        return view('pdf.exam', ['students' => $students,
		 'class' => $cname, 'subjects' => $subjects]);
    }

	public function getCa12(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->orderBy('student_id', 'asc')->get();

        if(!count($students)){
            return back()->with('info', 'No students found');
        }
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section','primary')->get();
		}else if(session()->get('section') == "secondary"){
			if($level >= 10 && $level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else{
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}
		}else{
				return redirect('/start');
			}
        return view('pdf.ca12', ['students' => $students,
		 'class' => $cname, 'subjects' => $subjects]);
    }

	public function firstCa(Request $request)
	{

		for($i = 0; $i < count($request->id); $i++){
			if($request->ca1[$i] == '-')
			continue;
			$result[] = array('student_id' => $request->id[$i],
			'ca1' => $request->ca1[$i],);
			}
			$col = new Collection($result);
			$sorted = $col->sortByDesc('ca1')->all();
			//dd($sorted);
       $k = 0;
        foreach ($sorted as $value) {
         $check = Result::whereRaw('student_id=? AND term=? AND class=? AND subject_id=?',
		 [$value['student_id'], Input::get('term'), Input::get('class'), Input::get('subject')])->first();
		if (isset($check)) {
			$check->update(['ca1' => $value['ca1'], 'position'=> ++$k ]);

                    } else {
                        Result::create([
                        'subject_id' => $request->input('subject'),
                        'student_id' => $value['student_id'],
                        'ca1' => $value['ca1'],
						'ca2' => 0,
                        'exam' => 0,
                        'term' => $request->input('term'),
                        'session' => $request->input('session'),
                        'class' => $request->input('class'),
						'div' => $request->input('div'),
                        'position' => ++$k,
                        ]);
                    }
                }

        return redirect('/result')->with('info', '1ST Scores CA Saved');
	}

	public function secondCa(Request $request)
	{

		for($i = 0; $i < count($request->id); $i++){
			if($request->ca2[$i] == '-')
			continue;
			$result[] = array('student_id' => $request->id[$i],
			'ca2' => $request->ca2[$i],);
			}
			$col = new Collection($result);
			$sorted = $col->sortByDesc('ca2')->all();
			//dd($sorted);
        $k = 0;
        foreach ($sorted as $value) {
         $check = Result::whereRaw('student_id=? AND term=? AND class=? AND subject_id=?',
		 [$value['student_id'], Input::get('term'), Input::get('class'), Input::get('subject')])->first();
if (isset($check)) {
	$check->update(['ca2' => $value['ca2'], 'position'=> ++$k ]);

	} else {
		return redirect('/result')->with('info', '1ST CA does not exist 2ND CA cant be saved');
	}
}


        return redirect('/result')->with('info', '2ND Scores CA Saved');
	}

	public function exam(Request $request)
	{
		$rst = array();
		for($i = 0; $i < count($request->id); $i++){
			if($request->exam[$i] == '-')
			continue;
			$result[] = array('student_id' => $request->id[$i],
			'exam' => $request->exam[$i], );
			}
			$col = new Collection($result);
			$sorted = $col->sortByDesc('exam')->all();
			//dd($sorted);
        $k = 0;
        foreach ($sorted as $value) {
         $check = Result::whereRaw('student_id=? AND term=? AND class=? AND subject_id=?',
		 [$value['student_id'], Input::get('term'), Input::get('class'), Input::get('subject')])->first();

if (isset($check)) {
	$check->update(['exam' => $value['exam']]);

	} else {
		Result::create([
                        'subject_id' => $request->input('subject'),
                        'student_id' => $value['student_id'],
                        'ca1' => 0,
						'ca2' => 0,
                        'exam' => $value['exam'],
                        'term' => $request->input('term'),
                        'session' => $request->input('session'),
                        'class' => $request->input('class'),
						'div' => $request->input('div'),
                        'position' => ++$k,
                        ]);
	}
}

		$res = Result::where('term', $request->term)->where('session', $request->session)
		->where('class', $request->class)->where('div', $request->div)->where('subject_id', $request->subject)->get();
		foreach($res as $r){
			$rst[] = array('student_id' => $r->student_id,
			'ca1' => $r->ca1, 'ca2' => $r->ca2, 'exam' => $r->exam,
			'total' => ($r->ca1+$r->ca2+$r->exam));
			}
			$colctn = new Collection($rst);
			$sortd = $colctn->sortByDesc('total')->all();
			$p = 0;
			//dd($sortd);
		foreach ($sortd as $value) {
         $check = Result::whereRaw('student_id=? AND term=? AND class=? AND subject_id=?',
		 [$value['student_id'], Input::get('term'),
					Input::get('class'), Input::get('subject')])->first();
					if (isset($check)) {
					$check->update(['position' => ++$p,]);
						}
		}



        return redirect('/result')->with('info', 'Exam Scores Saved');
	}

	public function ca12(Request $request)
	{

		for($i = 0; $i < count($request->id); $i++){
			if($request->ca1[$i] == '-' || $request->ca2[$i] == '-')
			continue;
			$result[] = array('student_id' => $request->id[$i],
			'ca1' => $request->ca1[$i], 'ca2' => $request->ca2[$i],
			'total' => ($request->ca1[$i]+$request->ca2[$i]));
			}
			$col = new Collection($result);
			$sorted = $col->sortByDesc('total')->all();
			//dd($sorted);
        $k = 0;
        foreach ($sorted as $value) {
            Result::updateOrCreate(
                [
                    'subject_id' => $request->input('subject'),
                    'student_id' => $value['student_id'],
                    'class' => $request->input('class'),
                ],
                [
                    'ca1' => $value['ca1'],
                    'ca2' => $value['ca2'],
                    'exam' => 0,
                    'term' => $request->input('term'),
                    'session' => $request->input('session'),
                    'div' => $request->input('div'),
                    'position' => ++$k,
                ]);
                }


        return redirect('/result')->with('info', 'CA Scores Saved');
	}

 	public function bulkInsert(Request $request)
	{

		for($i = 0; $i < count($request->id); $i++){
			if($request->ca1[$i] == '-' || $request->ca2[$i] == '-' || $request->exam[$i] == '-')
			continue;
			//dd($request->ca1[$i]);
			$result[] = array('student_id' => $request->id[$i],
			'ca1' => $request->ca1[$i], 'ca2' => $request->ca2[$i], 'exam' => $request->exam[$i],
			'total' => ($request->ca1[$i]+$request->ca2[$i]+$request->exam[$i]));
			}
			$col = new Collection($result);
			$sorted = $col->sortByDesc('total')->all();
			//dd($sorted);
        $k = 0;
        foreach ($sorted as $value) {
            Result::updateOrCreate(
                [
                    'subject_id' => $request->input('subject'),
                    'student_id' => $value['student_id'],
                    'class' => $request->input('class'),
                ],
                [
                'ca1' => $value['ca1'],
                'ca2' => $value['ca2'],
                'exam' => $value['exam'],
                'term' => $request->input('term'),
                'session' => $request->input('session'),
                'div' => $request->input('div'),
                'position' => ++$k,
            ]);
                }


        return redirect('/result')->with('info', 'Results Saved');
	}
public function getEditCa(Request $request)
{
	$results = Result::where('subject_id', $request->subject)->where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(count($results)){
		foreach($results as $result){
			$student = User::where('student_id', $result->student_id)->first();
			if($student){
			$res[] = array('id' => $result->student_id, 'ca1' => $result->ca1, 'ca2' => $result->ca2,
			 'exam' => $result->exam, 'total' => $result->ca+$result->exam, 'grade' =>
			 $this->grade($result->ca+$result->exam),
			'name' => $student->getName(), 'position' => $this->ordinal($result->position));
			}
			}
		}else{
        	return back()->with('info', 'Results not found');
			}
			$subject = Subject::where('id', $request->subject)->first();
			$data = array('term' => $this->term($request->term), 'session' => $request->session,
			'subject' => $subject->title, 'class' => $this->getClassName($request->class).$request->div,
			'sub_id' => $request->subject, 'term_id' => $request->term, 'class_id' => $request->class,
			'div' => $request->div);
			//dd($data);
			return view('pdf.editca', compact('data', 'res'));
}

public function editCa(Request $request)
	{

		for($i = 0; $i < count($request->id); $i++){
			if($request->ca1[$i] == '-' || $request->ca2[$i] == '-'){
				$resToDel = Result::where('student_id', $request->id[$i])->where('term', $request->term)->
				where('session', $request->session)->where('class', $request->class)->
				where('div', $request->div)->where('subject_id', $request->subject)->first()->delete();
				continue;

				}

			$result[] = array('student_id' => $request->id[$i],
			'ca1' => $request->ca1[$i], 'ca2' => $request->ca2[$i],
			'total' => ($request->ca1[$i]+$request->ca2[$i]));
			}
			$col = new Collection($result);
			$sorted = $col->sortByDesc('total')->all();
			//dd($sorted);
        $k = 0;
        foreach ($sorted as $value) {
         $check = Result::whereRaw('student_id=? AND term=? AND session=? AND class=? AND subject_id=?',
		 [$value['student_id'], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('subject')])->first();
		if (isset($check)) {
			$check->update(['ca1' => $value['ca1'], 'ca2' => $value['ca2'],
			'position'=> ++$k]);

                    }
                }


        return redirect('/result')->with('info', 'CAs Updated');
	}

	public function getEditResult(Request $request)
{
	$results = Result::where('subject_id', $request->subject)->where('term', $request->term)
		->where('session', $request->session)->where('class', $request->class)
		->where('div', $request->div)->orderBy('student_id', 'asc')->get();
		if(count($results)){
		foreach($results as $result){
			$student = User::where('student_id', $result->student_id)->first();
			if($student){
			$res[] = array('id' => $result->student_id, 'ca1' => $result->ca1, 'ca2' => $result->ca2,
			 'exam' => $result->exam, 'total' => $result->ca+$result->exam, 'grade' =>
			 $this->grade($result->ca+$result->exam),
			'name' => $student->getName(), 'position' => $this->ordinal($result->position));
			}
			}
		}else{
        	return back()->with('info', 'Results not found');
			}
			$subject = Subject::where('id', $request->subject)->first();
			$data = array('term' => $this->term($request->term), 'session' => $request->session,
			'subject' => $subject->title, 'class' => $this->getClassName($request->class).$request->div,
			'sub_id' => $request->subject, 'term_id' => $request->term, 'class_id' => $request->class,
			'div' => $request->div);
			//dd($data);
			return view('pdf.editresult', compact('data', 'res'));
}

public function editResult(Request $request)
	{
		for($i = 0; $i < count($request->id); $i++){
			if($request->ca1[$i] == '-' || $request->ca2[$i] == '-' || $request->exam[$i] == '-'){
				$resToDel = Result::where('student_id', $request->id[$i])->where('term', $request->term)->
				where('session', $request->session)->where('class', $request->class)->
				where('div', $request->div)->where('subject_id', $request->subject)->first()->delete();
				continue;

				}
			$result[] = array('student_id' => $request->id[$i],
			'ca1' => $request->ca1[$i], 'ca2' => $request->ca2[$i],
			'exam' => $request->exam[$i],
			'total' => ($request->ca1[$i]+$request->ca2[$i]));
			}
			$col = new Collection($result);
			$sorted = $col->sortByDesc('total')->all();
			//dd($sorted);
        $k = 0;
        foreach ($sorted as $value) {
         $check = Result::whereRaw('student_id=? AND term=? AND session=? AND class=? AND subject_id=?',
		 [$value['student_id'], Input::get('term'), Input::get('session'),
                            Input::get('class'), Input::get('subject')])->first();
		if (isset($check)) {
			$check->update(['ca1' => $value['ca1'], 'ca2' => $value['ca2'],
			'exam' => $value['exam'],'position'=> ++$k]);
                }
             }
				Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Updated '.$this->getClassName($request->class).''.$request->div.' '.Subject::find($request->subject)->title.' Results',
		]);

        return redirect('/result')->with('info', 'Results Updated');
	}
public function remove(){
	$results = Result::where('ca1', '_')->orWhere('ca2', '_')->orWhere('exam', '_')->delete();
	dd($results);
	}
public function removeSC($subject, $class, $div, $session, $term){
	$result = Result::where('subject_id', $subject)->where('class', $class)->where('div', $div)->
	where('term', $term)->get();
	if(count($result)){
		$result = Result::where('subject_id', $subject)->where('class', $class)->where('div', $div)
		->where('session', $session)->where('term', $term)->delete();
		return back()->with('info', 'Result Deleted');
		}
	}
public function getManage(){
	if(session()->get('section') == "primary"){
		$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
		->where('class', '>', 3)->where('class', '<', 10)->orderBy('created_at', 'desc')->get();
	}else if(session()->get('section') == "secondary"){
		$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
		->where('class', '>', 9)->where('class', '<', 16)->orderBy('created_at', 'desc')->get();
		}else{
				return redirect('/start');
			}
		if(count($results)){
	foreach($results as $result){
		$res[] = array('subject' => $result->subject->title, 'session' => $result->session, 'term' => $this->ordinal($result->term), 'class' => $this->getClassName($result->class).''.$result->div, 'sub_id' => $result->subject_id, 'class_id' => $result->class, 'div' => $result->div, 'term_id' => $result->term);
		}
	//dd($res);
	$perPage = 30;
    $page = Input::get('page', 1);
    if ($page > count($res) or $page < 1) { $page = 1; }
    $offset = ($page * $perPage) - $perPage;
    $perPageUnits = array_slice($res,$offset,$perPage, true);
    $res = new LengthAwarePaginator($perPageUnits, count($res), $perPage, $page);
	$res->setPath('/portal/results/manage');
		}else{
			return back()->with('info', 'No results found');
			}
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section', 'primary')->get();
		}else if(session()->get('section') == "secondary"){
			$subjects = Subject::where('section', 'secondary')->get();
		}
	return view('result.manage', compact('res', 'subjects'));
	}
	public function manageByClass(Request $request){
		if(session()->get('section') == "primary"){
		$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
		->where('class', $request->class)->orderBy('created_at', 'desc')->get();
	}else if(session()->get('section') == "secondary"){
		$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
		->where('class', $request->class)->orderBy('created_at', 'desc')->get();
		}else{
				return redirect('/start');
			}
		if(count($results)){
	foreach($results as $result){
		$res[] = array('subject' => $result->subject->title, 'session' => $result->session, 'term' => $this->ordinal($result->term), 'class' => $this->getClassName($result->class).''.$result->div, 'sub_id' => $result->subject_id, 'class_id' => $result->class, 'div' => $result->div, 'term_id' => $result->term);
		}
	//dd($res);
	$perPage = 30;
    $page = Input::get('page', 1);
    if ($page > count($res) or $page < 1) { $page = 1; }
    $offset = ($page * $perPage) - $perPage;
    $perPageUnits = array_slice($res,$offset,$perPage, true);
    $res = new LengthAwarePaginator($perPageUnits, count($res), $perPage, $page);
	$res->setPath('?class='.$request->class);
		}else{
			return back()->with('info', 'No results found');
			}
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section', 'primary')->get();
		}else if(session()->get('section') == "secondary"){
			$subjects = Subject::where('section', 'secondary')->get();
		}
	return view('result.manage', compact('res', 'subjects'));



		}

public function manageBySubject(Request $request){
	if(session()->get('section') == "primary"){
		$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
		->where('class', '>', 3)->where('class', '<', 10)->where('subject_id', $request->subject)->orderBy('created_at', 'desc')->get();
	}else if(session()->get('section') == "secondary"){
		$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
		->where('class', '>', 9)->where('class', '<', 16)->where('subject_id', $request->subject)->orderBy('created_at', 'desc')->get();
		}else{
				return redirect('/start');
			}
		if(count($results)){
	foreach($results as $result){
		$res[] = array('subject' => $result->subject->title, 'session' => $result->session, 'term' => $this->ordinal($result->term), 'class' => $this->getClassName($result->class).''.$result->div, 'sub_id' => $result->subject_id, 'class_id' => $result->class, 'div' => $result->div, 'term_id' => $result->term);
		}
	//dd($res);
	$perPage = 30;
    $page = Input::get('page', 1);
    if ($page > count($res) or $page < 1) { $page = 1; }
    $offset = ($page * $perPage) - $perPage;
    $perPageUnits = array_slice($res,$offset,$perPage, true);
    $res = new LengthAwarePaginator($perPageUnits, count($res), $perPage, $page);
	$res->setPath('?subject='.$request->subject);
		}else{
			return back()->with('info', 'No results found');
			}
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section', 'primary')->get();
		}else if(session()->get('section') == "secondary"){
			$subjects = Subject::where('section', 'secondary')->get();
		}
	return view('result.manage', compact('res', 'subjects'));
	}

    public function manageClass(Request $request)
    {
        if(Auth::user()->is_staff && isset(Auth::user()->level) && isset(Auth::user()->class)){
            $level = Auth::user()->level;
            $div = Auth::user()->class;
			$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
                ->where('class', $level)->where('div', $div)->orderBy('created_at', 'desc')->get();
        }else{
            //return back();

			$results = Result::with('subject')->select(DB::raw('DISTINCT subject_id, session, class, div, term'))
                ->where('class', $request->class)->orderBy('created_at', 'desc')->get();

       }

        if(count($results)){
            foreach($results as $result){
                    $res[] = array('subject' => $result->subject->title, 'session' => $result->session, 'term' => $this->ordinal($result->term), 'class' => $this->getClassName($result->class).''.$result->div, 'sub_id' => $result->subject_id, 'class_id' => $result->class, 'div' => $result->div, 'term_id' => $result->term);
            }
            //dd($res);
            $perPage = 30;
            $page = Input::get('page', 1);
            if ($page > count($res) or $page < 1) { $page = 1; }
            $offset = ($page * $perPage) - $perPage;
            $perPageUnits = array_slice($res,$offset,$perPage, true);
            $res = new LengthAwarePaginator($perPageUnits, count($res), $perPage, $page);
            $res->setPath('?class='.$request->class);
        }else{
            return back()->with('info', 'No results found');
        }
        if(session()->get('section') == "primary"){
            $subjects = Subject::where('section', 'primary')->get();
        }else if(session()->get('section') == "secondary"){
            $subjects = Subject::where('section', 'secondary')->get();
        }
        return view('result.manage', compact('res', 'subjects'));
    }

	public function getTermResultJSON($student, $level, $term){
		if(User::find($student)){
			$st = User::where('id', $student)->first();
			$results =  Result::where('student_id', $st->student_id)->where('class', $level)->
		where('term', $term)->get();
			if(count($results))
		foreach($results as $j => $result){
				$results[$j] = array('ca1' => $result->ca1, 'ca2' => $result->ca2, 'exam' => $result->exam,
				'subject' => Subject::find($result->subject_id)->title, 'subject_id' => $result->subject_id,
				'term' => $term, 'class' => $level, 'student_id' => $st->student_id,
				 );
			}
return response()->json($results);
		}

	}
	public function updateTermResult(Request $request){
			for($i=0; $i<count($request->ca1); $i++){

				if($request->ca1[$i] == '-' || $request->ca2[$i] == '-' || $request->exam[$i] == '-'){
				$resToDel = Result::where('student_id', $request['student_id'][$i])->
				where('subject_id', $request['subject'][$i])->where('term', $request['term'][$i])->
				where('class', $request['class'][$i])->first()->delete();
				continue;

				}

				$result = Result::where('student_id', $request['student_id'][$i])->
				where('subject_id', $request['subject'][$i])->where('term', $request['term'][$i])->
				where('class', $request['class'][$i])->first();

				$result->update([
				'ca1' => $request['ca1'][$i],
				'ca2' => $request['ca2'][$i],
				'exam' => $request['exam'][$i],
				]);

			}

		return back()->with('info', 'Results Updated');
		}

    public function bulkTerm($level, $div, $term, $session)
    {
        set_time_limit(300);
        $school = Setting::where('key','title')->first()->value;
        $address = \Portal\Models\Setting::where('key','address')->first()->value;
        $phone = \Portal\Models\Setting::where('key','phone')->first()->value;
        $motto = \Portal\Models\Setting::where('key','motto')->first()->value;
        $link = url('/logo/logo.jpg');
        $logo = str_replace('/logo/', '/public/storage/', $link);
        $content = '';
        $positions = Position::where('level', $level)->where('class', $div)->where('term', $term)
            ->where('session', $session)->get();
        // $students = User::where('level', $level)->where('class', $div)->where('active', true)->get();
        $content .=" <html lang=\"en\">";
        if(session()->get('section') == "primary"){
            $content .= "<head>
<style type=\"text/css\">
hr {
    width:200px;
    color:#6279E5;
    }
.noborder td strong
       {
        color:#6279E5;
        font-family:Gotham, \"Helvetica Neue\", Helvetica, Arial, sans-serif;
        font-size:14px;
        font-weight:bold;
        }
    .page {
        width: 100%;
        height: 1960px;
        margin: 0px auto;

    }
    .table {
        margin: 0px auto;
        width: 90%;
        border: 2px solid #6279E5;

    }
    .table tr, .table th, .table td {
        border: 1px solid #6279E5;
        padding:10px;
    }

    .log {
        float:left;
        width: 120px;
        height:130px;
        }
    .dtl {
        text-align:center;}
    h1, h2, h3, h4, h5 {
        text-align:center;}
    h1 {
        font-family: \"Arial Black\", Gadget, sans-serif;
        color:#6279E5;
        font-size:45px;
        margin:0px;
        font-stretch: expanded;
        }
    h2 {
        font-family: \"DejaVu Sans Condensed\", Helvetica, Arial, sans-serif;
        color:#D14B4D;
        font-size:22px;
        margin:0px;
        }
    h3 {
        font-family:\"Gill Sans\", \"Gill Sans MT\", \"Myriad Pro\", \"DejaVu Sans Condensed\",
         Helvetica, Arial, sans-serif;
        color:#6279E5;
        margin:0px;
        }
    h5 {
        margin:0px;
        font-family:\"Gill Sans\", \"Gill Sans MT\", \"Myriad Pro\", \"DejaVu Sans Condensed\",
         Helvetica, Arial, sans-serif;
        color:#D14B4D;
        }
    p {
         margin:0px;
         font-family:\"Gill Sans\", \"Gill Sans MT\", \"Myriad Pro\", \"DejaVu Sans Condensed\",
         Helvetica, Arial, sans-serif;
         color:#6279E5;
         text-align:center;
         font-size:14px;
            }
    .pp {
        width:200px;

        }
    .pp p {
        text-align:left;
        }
    a {
        color: #000000;
        text-decoration: none;
    }
    .underline {
        border-bottom: 1px solid #6279E5;
        text-align: center;
        font-family: \"DejaVu Sans Mono\", monospace;
        font-size: 20px;
        font-weight: bold;
    }

    .log {
        float:left;
        width: 120px;
        height:130px;
        }
    .bxx {
    width:900px;
	margin:0px auto;
    }
    .dtl {
        text-align:center;}

    th.rotate {
        /* Something you can count on */
        width:120px;
        color:#D14B4D;

    }

    th.rotate > div {

    }
    .subject {
        color:#6279E5;
    }
    .remark {
        width:70px;
    }

    .noborder {
        width: 100%;
        margin: 0px auto;
        border:0px solid white;
        border-spacing: 20px;
    }
    .noborder p {
        text-align:left;}
	.base {
		margin:0px auto;
		border:2px solid #6279E5;
		padding:10px;
		width:1240px;
		font-size:14px;
		margin-top:40px;
		}
		.fail {
        color: red;
    }
    .fail tr, .fail td{
        color: red;
    }
</style>
</head>";
            foreach ($positions as $position){

                $student = User::with()->where('student_id', $position->student_id)->where('active', true)->first();
                if(!$student){
                    continue;
                }
                if($student->image == null){
                    $pic = url("/student/mm.jpg/view");
                }else{
                    $pic = url("/student/".$student->image."/view");
                }
                $pic = str_replace('/student/', '/local/storage/app/students/', $pic);
                $pic = str_replace('/view', '', $pic);
                $var = $this->termStuff($student->id,$level, $term, $session);
                //dd($var);
                if(isset($var['all'][0]))
                    $content .= "<div class='page'>
			<table class=\"noborder\">
			<tr>
			<td colspan=\"3\"><h1>INTERNATIONAL SCHOOL OF NIGERIA</h1></td>
			</tr>
			<tr>
			<td>
			<div class=\"log\">
			<img src=".$logo." width=\"130px\" height=\"140px\"/>
			</div>
			</td>
			<td>
			<h3></h3>
			<div class=\"bxx\">
			<h5>Motto: ".$motto."</h5><br>
			<h5>ADDRESS:<span style=\"color:#6279E5; font-weight:200;\">".$address."</span></h5>
			<h5>TEL/GSM: <span style=\"color:#6279E5; font-weight:normal;\">".$phone."</span></h5><br>
			<h2 style=\"text-decoration:underline;\">PUPIL'S REPORT SHEET</h2>
			</div>
			</td>
			<td>
			<div class=\"log\">
			<img src=".$pic." width=\"130px\" height=\"140px\"/>
			</div>
			</td>
			</tr>
			</table>
			<table class=\"noborder\">
    <tr>
    	<td width=\"40px\"><strong>TERM</strong></td>
		<td class=\"underline\" >".Auth::user()->ordinal($term)."</td>
        <td width=\"600px\"> </td>
        <td class=\"underline\" >".$var['data']['session']."/" . ++$var['data']['session']."</td>
    	<td width=\"120px\"><strong>ACADEMIC YEAR</strong></td>
    </tr>
</table>";

                $content .= "<body>

<table class=\"noborder\">
    <tr>
        <td width=\"140px\"><strong>NAME OF STUDENT:</strong></td><td colspan=\"4\" class=\"underline\">
            {$var['stu']['name']}</td>
    </tr>
  </table>
  <table class=\"noborder\">
    <tr>
    	<td width=\"45px\"><strong>CLASS:</strong></td>
        <td class=\"underline\" >".$var['stu']['class'].''.$var['stu']['level']."</td>
    	<td width=\"65px\"><strong>REG. NO.</strong></td>
        <td class=\"underline\">".$var['stu']['adno']."</td>

    </tr>
    </table>

<br>
        <table cellspacing=\"0\" class=\"table\">
            <tr>
                <th style=\"color:#D14B4D;\">SUBJECT</th>
                <th class=\"rotate\"><div>1ST CA</div><div>15%</div></th>
                <th class=\"rotate\"><div>2ND CA</div><div>15%</div></th>
                <th class=\"rotate\"><div>EXAM</div><div>70%</div></th>
                <th class=\"rotate\"><div>TOTAL</div><div>100%</div></th>
                <th class=\"rotate\"><div>COMMENT</div></th>

            </tr>";
                foreach($var['all'] as $k => $a) {
                    $content .= "<tr  ";
                    if(($a['ca1']+$a['ca2']+$a['exam']) < 40){ $content .= "class=\"fail\""; }
                    $content .= ">
                    <td class=\"subject\">" . $a['subject'] . "</td>
                    <td class=\"dtl\">" . $a['ca1'] . "</td>
                     <td class=\"dtl\">" . $a['ca2'] . "</td>
                    <td class=\"dtl\">" . $a['exam'] . "</td>
                    <td class=\"dtl\">".($a['ca1'] + $a['ca2'] + $a['exam']) . "</td>
                    <td class=\"dtl\">".$a['remark'] . "</td>
                  </tr>";
                }
                $content .= "</table>
        <div class=\"base\">
        <table class=\"noborder\">
    <tr>
    	<td width=\"160px\"><strong>Maximum Attendance :</strong></td>
        <td class=\"underline\">";
                if(isset($var['attendance']->total))
                    $content .= $var['attendance']->total;
                $content .= "</td>
        <td width=\"100px\"><strong>Time Present :</strong></td>
        <td class=\"underline\">";
                if(isset($var['attendance']->present))
                    $content .= $var['attendance']->present;
                $content .= "</td>
        <td width=\"90px\"><strong>Time Absent:</strong></td>
        <td class=\"underline\" >";
                if(isset($var['attendance']->present) && isset($var['attendance']->total) &&
                    isset($var['attendance']->late))
                    $content .= ($var['attendance']->total-($var['attendance']->present+$var['attendance']->late));
                $content .= "</td>
        <td width=\"80px\"><strong>Time Late:</strong></td>
        <td class=\"underline\" width=\"150px\" >";
                if(isset($var['attendance']->late))
                    $content .= ($var['attendance']->late);
                $content .= "</td>
    </tr>
    </table>
    <table class=\"noborder\">
    <tr>
        <td width=\"150px\"><strong>General Behaviour:</strong></td>
        <td class=\"underline\" > ";
                if(isset($var['behaviour']->behaviour))
                    $content .= Auth::user()->behaviour($var['behaviour']->behaviour);
                $content .= "</td>
        <td width=\"150px\"><strong>General Appearance:</strong></td>
        <td class=\"underline\" >";
                if(isset($var['behaviour']->appearance))
                    $content .= Auth::user()->appearance($var['behaviour']->appearance);
                $content .= "</td>
    </tr>
    </table>
    <table class=\"noborder\">
    <tr>";
                if($var['data']['term'] && $var['data']['term'] == 3){
                    $content .= "<td width=\"50px\"><strong>Average:</strong></td>
            <td class=\"underline\">".round($var['data']['cavg'], 2)."</td>
            <td width=\"40px\"><strong>Total:</strong></td>
            <td class=\"underline\">".$var['data']['ctotal']."</td>
    		<td width=\"40px\"><strong>Grade:</strong></td>
            <td class=\"underline\">". $var['data']['cgrade']."</td>
            <td width=\"125px\"><strong>Position in Class:</strong></td>
            <td class=\"underline\" width=\"200px\">".
                        $var['data']['position'] . ' out of ' . $var['data']['no']."</td>";
                }else{
                    $content .= "<td width=\"50px\"><strong>Average:</strong></td>
            <td class=\"underline\">".round($var['data']['average'], 2)."</td>
            <td width=\"40px\"><strong>Total:</strong></td>
            <td class=\"underline\">".$var['data']['total']."</td>
    		<td width=\"40px\"><strong>Grade:</strong></td>
            <td class=\"underline\">".$var['data']['grade']."</td>
            <td width=\"123px\"><strong>Position in Class:</strong></td>
            <td class=\"underline\" width=\"200px\">
            ".$var['data']['tposition'] . ' out of ' . $var['data']['no']."</td>";
                }
                $content .= "</tr>
  </table>";
                if($var['data']['term'] && $var['data']['term'] == 3){
                    $content .= "<table class=\"noborder\">
    <tr>
    	<td width=\"110px\"><strong>1st Term Total:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['fsum']))
                        $content .= $var['data']['fsum'];
                    $content .= "</td>
        <td width=\"110px\"><strong>2nd Term Total:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['ssum']))
                        $content .= $var['data']['ssum'];
                    $content .= "</td>
        <td width=\"110px\"><strong>3rd Term Total:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['tsum']))
                        $content .= $var['data']['tsum'];
                    $content .= "</td>
        <td width=\"140px\"><strong>Cummulative Total:</strong></td>
        <td class=\"underline\" width=\"140px\" >";
                    if(isset($var['data']['ctotal']))
                        $content .= $var['data']['ctotal'];
                    $content .= "</td>
       </tr>
    </table>
    <table class=\"noborder\">
    <tr>
    	<td width=\"140px\"><strong>1st Term Average:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['favg']))
                        $content .= $var['data']['favg'];
                    $content .= "</td>
        <td width=\"140px\"><strong>2nd Term Average:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['savg']))
                        $content .= $var['data']['savg'];
                    $content .= "</td>
        <td width=\"140px\"><strong>3rd Term Average:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['tavg']))
                        $content .= $var['data']['tavg'];
                    $content .= "</td>
        <td width=\"160px\"><strong>Cummulative Average:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['cavg']))
                        $content .= $var['data']['cavg'];
                    $content .= "</td>
    </tr>
    </table>
    <table class=\"noborder\">
    <tr>
    	<td width=\"130px\"><strong>3rd Term Position:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['favg']))
                        $content .= $var['data']['tposition'];
                    $content .= "</td>
        <td width=\"120px\"><strong>Annual Position:</strong></td>
        <td class=\"underline\" >";
                    if(isset($var['data']['savg']))
                        $content .= $var['data']['position'];
                    $content .= "</td>
    </tr>
    </table>";
                }
                $content .= "<table class=\"noborder\" >
        <tr>
            <td width=\"210px\"><strong>Class Teacher's Comment :</strong></td>
            <td class=\"underline\">".Auth::user()->comment($var['data']['tposition'])."</td>
			<td width=\"138px\"><strong>Next Term Begins:</strong></td>
        <td class=\"underline\">
            ".\Portal\Models\Termsetting::where('current',true)->first()->resume_date->format('d-M-Y')."</td>

    </tr>
    </table>
    <table class=\"noborder\">
    <tr>
        <td width=\"200px\"><strong>Class Teacher's Name :</strong></td>
        <td class=\"underline\">";
                if(isset($var['data']['teacher']))
                    $content .= $var['data']['teacher'];
                $content .= "</td>
        <td width=\"100px\"></td>
        <td width=\"90\"><strong>Signature</strong></td>
        <td class=\"underline\" width=\"200px\"></td>
    </tr>
</table>
<table class=\"noborder\" >
    <tr>
            <td width=\"190px\"><strong>Headmistress's Comment :</strong></td>
            <td class=\"underline\">";
                if($term != 3){
                    $content .= Auth::user()->pcomment($var['data']['average']);
                }
                $content .= "</td>
    </tr>
    </table>
    <table class=\"noborder\">
    <tr>
        <td width=\"180px\"><strong>Headmistress's Signature</strong></td>
        <td class=\"underline\"></td>
        <td width=\"200px\"></td>
        <td width=\"40\"><strong>Date</strong></td>
        <td class=\"underline\"></td>
    </tr>
</table>
  </div>
       </div>
</body> 		";
            }
        }elseif(session()->get('section') == "secondary"){
            $content .= "<head>
        <style type=\"text/css\">
            .page {
                width:100%;
                margin:0px auto;
                padding: 0;

            }.box {
                    
                 page-break-inside: avoid;
                 width:100%;
				 height: 1400px;
               

             }
            hr {
                width:200px;
                color:#6279E5;

            }
            .noborder td strong
            {
                color:#6279E5;
                font-family:Gotham, \"Helvetica Neue\", Helvetica, Arial, sans-serif;
                font-size:15px;
                font-weight:normal;
            }

            .table {
                font-size:17px;
            }
            .table tr, .table th, .table td {
                border: 1px solid #6279E5;
            }

            .log {
                float:left;
                width: 130px;
                height:150px;
            }
            .dtl {
                text-align:center;}
            /*h1, h2, h3, h4, h5 {*/
            /*text-align:center;}*/
            h1 {
                font-family: \"Helvetica Neue\", Helvetica, sans-serif;
                color:#6279E5;
                font-size:44px;
                margin:0px;
                text-align: center;
            }
            h2 {
                font-family: \"DejaVu Sans Condensed\", Helvetica, Arial, sans-serif;
                color:#D14B4D;
                font-size:20px;
                margin:0px;
                margin-left: 30px;
            }
            h3 {
                font-family:\"Gill Sans\", \"Gill Sans MT\", \"Myriad Pro\", \"DejaVu Sans Condensed\",
                Helvetica, Arial, sans-serif;
                color:#6279E5;
                margin:0px;

            }
            h5 {
                margin:0px;
                font-family: \"DejaVu Sans Condensed\", Helvetica, Arial, sans-serif;
                color:#D14B4D;
                font-size: 17px;
            }
            p {
                margin:0px;
                font-family:\"Gill Sans\", \"Gill Sans MT\", \"Myriad Pro\", \"DejaVu Sans Condensed\",
                Helvetica, Arial, sans-serif;
                color:#6279E5;
                text-align:center;
                font-size:20px;
            }
            .pp {
                width:200px;

            }
            .pp p {
                text-align:left;
            }
            a {
                color: #000000;
                text-decoration: none;
            }
            .underline {
                border-bottom: 1px solid #6279E5;
                text-align: center;
                font-family: \"DejaVu Sans Mono\", monospace;
                font-size: 20px;
                font-weight:bolder;
            }
            .noborder {
                width: 100%;
                margin: 0px auto;
                border:0px solid white;
                border-spacing: 7px;
                padding: 0;
            }
            .bxx {
                width:100%;
                clear: right;
                margin-left: 150px;

            }

            .top {
                width:100%;
                text-align: center;
                font-size:17px;
                padding:0px;
                /*margin-bottom: -10px;*/
                border: 2px solid #6279E5;
                border-bottom:none;
                height: 58px;
            }
            .wrap {
                clear:both;
                border: 2px solid #6279E5;
                width:100%;

            }
            .fail {
                color: red;
            }
            .fail tr, .fail td{
                color: red;
            }

            .details {
                width: 100%;
                margin-top: 20px;
            }
            .results {
                width: 100%;
                margin-bottom: 20px;
                /*float: left;*/

            }

            .tdiv {
                width: 75%;
                margin-bottom:20px;
                font-family: \"Times New Roman\", Times, serif;
                float: left;
            }
            .sdiv {
                width: 25%;
                float: left;
            }

            .table {
                border: 2px solid #6279E5;
                border-right: none;
                /*max-width: 520px;*/
                text-align: center;
                margin-bottom:20px;
                font-family: \"Times New Roman\", Times, serif;
                width: 100%;
                mso-cellspacing: 20px;
                line-height: 30px;

            }
            .small {
                border: 2px solid #6279E5;
                border-left:none;
                border-bottom:none;
                font-size: 19px;
                font-family: \"Times New Roman\", Times, serif;
                 
                /*margin-bottom: -200px;*/

            }
            th.subject {
                color:#6279E5;
                width: 35%;
            } 
            th.subjects {
                color:#6279E5;
                width: 40%;
            }

            th.rotate {
                /* Something you can count on */
                height: 120px;
                width:45px;
                white-space: nowrap;
                color:#D14B4D;
            }

            th.rotate > div {
                float:left;
                position: relative;
                width: 30px;
                top: 40px;
                left:5px;
                line-height:20px ;
                border-style: none;
                font-size: 15px;
                -ms-transform:rotate(270deg); /* IE 9 */
                -moz-transform:rotate(270deg); /* Firefox */
                -webkit-transform:rotate(270deg); /* Safari and Chrome */
                -o-transform:rotate(270deg); /* Opera */
            }

            .remark {
                width:100px;
            }
            .sub {
                width: 160px;
            }
            .base {
                clear: both;
                border:2px solid #6279E5;
               
                width:98%;
                font-size:17px;

            }
            table.small tr td:nth-child(2) {
                line-height: 30px;
                text-align: center;
            }
            .base table {
               line-height: 35px;
            }
			
			
		@media (max-width:1440px) {
               
                h1 {
                    font-size:29px;
                }
                h2 {
                    font-size:14px;
                    margin-left: 20px;
                }
                h5 {
                    font-size: 15px;
                }
                p {
                    font-size:14px;
                }
                .table {
                    font-size:16px;
                }
                .underline {
                    font-size: 16px;
                }
                .noborder {
                    border-spacing: 5px;
                }
                .small {
                    font-size: 15px;
                }
                .base {
                   
                    font-size:16px;

                }
                .base table {
                    line-height: 25px;
                }
                table.small tr td:nth-child(2) {
                    line-height: 25px;
                }
                .table {
                    margin-bottom:10px;

                    }
                .box {
				 height: 1200px;
				
				 
             }
             th.subject {
                width: 31%;
            } 
		}
		
		@media (min-width:1441px) and (max-width:1920px){
				h1 {
                    font-size:44px;
                }
                h2 {
                    font-size:20px;
                    margin-left: 30px;
                }
                h5 {
                    font-size: 17px;
                }
                p {
                    font-size:16px;
                }
                .table {
                    font-size:20px;
			
                }
				.table #subj {
					line-height: 30px;
				}
			
                .underline {
                    font-size: 20px;
                }
                .noborder {
                    border-spacing: 10px;
                }
                .small {
                    font-size: 18px;
                }
                .base {
                   
                    font-size:17px;

                }
                .base table {
                    line-height: 30px;
                }
                table.small tr td:nth-child(2) {
                    line-height: 30px;
                }
                
                .box {
				 height: 1400px;
				border:1px solid red;
				 
             }
             th.subject {
                width: 35%;
            } 
		}

           

            
            
        </style>
</head>";
            foreach ($positions as $position){

                $student = User::where('student_id', $position->student_id)->where('active', true)->first();
                if(!$student){
                    continue;
                }

                if($student->image == null){
                    $pic = url("/student/mm.jpg/view");
                }else{
                    $pic = url("/student/".$student->image."/view");
                }
                $pic = str_replace('/student/', '/public/storage/students/', $pic);
                $pic = str_replace('/view', '', $pic);
                $var = $this->termStuff($student->id,$level, $term,$session);

                if(isset($var)){
                    $results = $var['results'];
                    $student = $var['student'];
                }else{
                    continue;
                }
                    $content .= "<div class='box'>
			<table class=\"noborder\">
			<tr>
			<td colspan=\"3\"><h1>INTERNATIONAL SCHOOL OF NIGERIA</h1></td>
			</tr>
			<tr>
			<td>
			<div class=\"log\">
			<img src=".$logo." width=\"120px\" height=\"120px\"/>
			</div>
			</td>
			<td>
			<h3></h3>
			<div class=\"bxx\">
			<h5>Motto: ".$motto."</h5><br>
			<h5>ADDRESS:<span style=\"color:#6279E5; font-weight:200;\">".$address."</span></h5>
			<h5>TEL/GSM: <span style=\"color:#6279E5; font-weight:normal;\">".$phone."</span></h5><br>
			<h2 style=\"text-decoration:underline;\">TERMLY REPORT SHEET</h2>
			</div>
			</td>
			<td>
			<div class=\"log\">
			<img src=".$pic." width=\"120px\" height=\"120px\"/>
			</div>
			</td>
			</tr>
			</table>
			";
                if($term == 3){
                    $content .= "<table class=\"noborder\">
                <tr>
                    <td width=\"40px\"><strong></strong></td>

                    <td width=\"700px\"> </td>
                    <td class=\"underline\" >".$session."/" . ($session+1)."</td>
                    <td width=\"65px\"><strong>SESSION</strong></td>
                </tr>
            </table>
            <table class=\"noborder\">
                <tr>
                    <td width=\"150px\"><strong>Name of Student:</strong></td><td colspan=\"2\" class=\"underline\">
                        ".$student->name."</td>
                    <td width=\"150px\"></td>
                    <td width=\"40px\"><strong>Term</strong></td>
                    <td width=\"120px\" class=\"underline\" >".Auth::user()->ordinal($term)."</td>
                </tr>
            </table>";
                    $attendance = $student->attendances->where('term',$term)->where('class',$level)->where('session',$session)->first();
            $content.="<table class=\"noborder\">
                <tr id=\"\">
                    <td width=\"175px\"><strong>Maximum Attendance:</strong></td>
                    <td class=\"underline\" width=\"120px\">";
                        if(isset($attendance->total))
                            $content .= $attendance->total;
                    $content .="</td>
                    <td width=\"100px\"></td>
                    <td width=\"120px\"><strong>Times Present:</strong></td>
                    <td class=\"underline\" >";
                        if(isset($attendance->present))
                            $content .= $attendance->present;
                    $content .="</td>
                    <td width=\"70px\"><strong>Class:</strong></td>
                    <td class=\"underline\" >$student->student_class</td>
                </tr>
            </table>
            <table class=\"noborder\">
                <tr>
                    <td width=\"155px\"><strong>Next Term Begins:</strong></td>
                    <td class=\"underline\">";
                        if($pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                            $content .= $pos->resume_date->format('d-M-Y');
                    $content .="</td>
                    <td width=\"300px\"></td>
                    <td width=\"60px\"><strong>Date</strong></td>
                    <td class=\"underline\" >";
                        if($pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                            $content .= $pos->close_date->format('d-M-Y');
                   $content .= "</td>
                </tr>
            </table>
<div class=\"results\"  >
                <div class=\"tdiv\">
        <table cellspacing=\"0\" class=\"table\">
            <tr>
                            <th class=\"subjects\">SUBJECTS</th>
                            <th class=\"rotate\"><div>1ST TERM<br> SCORE</div></th>
                            <th class=\"rotate\"><div>2ND TERM <br> SCORE</div></th>
                            <th class=\"rotate\"><div>3RD TERM <br> SCORE</div></th>
                            <th class=\"rotate\"><div>CUM <br> AVERAGE</div></th>
                            <th class=\"rotate\"><div>GRADE</div></th>
                            <th class=\"rotate\" style=\"text-align: center;\"><div>TEACHERS <br> REMARK</div></th>
                            <th  class=\"rotate\" width=\"30px\"><div>SIGNATURE</div></th>

                        </tr>";
                   $tsubjects = $results->groupBy('subject_id');

                    $no = 1;
                    foreach($tsubjects as $k => $subjects){

                        $content .= "<tr id='subj' ";
                        $subject = $subjects->groupBy('term');

                        $average=$subjects->sum('total')/count($subjects);
                        if($average < 40){
                            $content .= " class='fail'";
                        }
                        $content .= " style='line-height:30px' >
                    <td style='text-align: left'>".$no++.'. '.$subject->first()->first()->subject_title."</td>";
                        if (isset($subject[1])){
                            $content .="<td>".$subject[1]->first()->total."</td>";
                        }else{
                            $content .="<td>-</td>";
                        }
                        if (isset($subject[2])){
                            $content .="<td>".$subject[2]->first()->total."</td>";
                        }else{
                            $content .="<td>-</td>";
                        }
                        if (isset($subject[3])){
                            $content .="<td>".$subject[3]->first()->total."</td>";
                        }else{
                            $content .="<td>-</td>";
                        }
                    $content .="<td>".round($average, 2)."</td>
                    <td>".$subject->first()->first()->grade($average)."</td>
                    <td class=\"remark\">".$subject->first()->first()->remark($average)."</td>
                    <td width=\"100px\"></td>
                </tr>";
                    }
                    $rate = $student->rates->where('term',$term)
                        ->where('class',$level)->where('session',$session)->first();
                    $content .= "</table>
        </div>
        <div class=\"sdiv\">
        <table cellspacing=\"0\" class=\"small\" border='1'>
        	<tr><th height='112px'><div class=\"subject\">RATE THESE TRAITS</div></th>
            <th>5 Point<br>Rating<br>Scale<br>5-4-3-2-1<br></th></tr>
            	 <tr><td>Punctuality</td><td>";
                                if(isset($rate->punctuality))
                                    $content.= $rate->punctuality;
                            $content .="</td></tr>
                        <tr><td>Class Atendance</td><td>";
                                if(isset($rate->attendance))
                                    $content.= $rate->attendance;
                            $content .="</td></tr>
                        <tr><td>Carrying out Assignment</td><td>";
                                if(isset($rate->assignments))
                                    $content.= $rate->assignments;
                            $content .="</td></tr>
                        <tr><td>Perseverance</td><td>";
                                if(isset($rate->perseverance))
                                    $content.= $rate->perseverance;
                            $content.="</td></tr>
                        <tr><td>Self Control</td><td>";
                                if(isset($rate->self_control))
                                    $content.= $rate->self_control;
                            $content.="</td></tr>
                        <tr><td>Self Confidence</td><td>";
                                if(isset($rate->self_confidence))
                                    $content.= $rate->self_confidence;
                            $content.="</td></tr>
                        <tr><td>Endurance</td><td>";
                                if(isset($rate->endurance))
                                    $content.= $rate->endurance;
                            $content.="</td></tr>
                        <tr><td>Respect</td><td>";
                                if(isset($rate->respect))
                                    $content.= $rate->respect;
                            $content.="</td></tr>
                        <tr><td>Relationship with others</td><td>";
                                if(isset($rate->relationship))
                                    $content.= $rate->relationship;
                            $content.="</td></tr>
                        <tr><td>Leadership/Team Spirit</td><td>";
                                if(isset($rate->leadership))
                                    $content.= $rate->leadership;
                            $content.="</td></tr>
                        <tr><td>Honesty</td><td>";
                                if(isset($rate->honesty))
                                    $content.= $rate->honesty;
                            $content.="</td></tr>
                        <tr><td>Neatness</td><td>";
                                if(isset($rate->neatness))
                                    $content.= $rate->neatness;
                            $content .= "</td></tr>
                        <tr><td>Responsibilty</td><td>";
                                if(isset($rate->responsibility))
                                    $content.= $rate->responsibility;
                            $content.="</td></tr>
                        <tr><td>Sport & Athletics</td><td>";
                                if(isset($rate->sports))
                                    $content.= $rate->sports;
                            $content.="</td></tr>
                        <tr><td>Manual Skills</td><td>";
                                if(isset($rate->skills))
                                    $content.= $rate->skills;
                            $content.="</td></tr>
                        <tr><td>Participation in Group Project</td><td>";
                                if(isset($rate->group_projects))
                                    $content.= $rate->group_projects;
                            $content .= "</td></tr>
                        <tr><td>Merit</td><td>";
                                if(isset($rate->merit))
                                    $content.= $rate->merit;
                            $content.= "</td></tr>


        </table>
        </div>
        </div>

        <div class=\"base\">
    <table class=\"noborder\">";

                    $content .= "
                    <tr>
                        <td width=\"120px\"><strong>1st TERM TOTAL:</strong></td>
                        <td class=\"underline\" width=\"100px\" >".$results->where('term',1)->sum('total')."</td>
                        <td width=\"70px\"><strong>2nd TERM:</strong></td>
                        <td class=\"underline\" width=\"100px\" >".$results->where('term',2)->sum('total')."</td>
                        <td width=\"70px\"><strong>3rd TERM:</strong></td>
                        <td class=\"underline\" width=\"100px\">".$results->where('term',3)->sum('total')."</td>
                        <td width=\"100px\"><strong>CUMM. TOTAL:</strong></td>
                        <td class=\"underline\" width=\"100px\" >".$results->sum('total')."</td>
                    </tr>
                 
	</table>";
                    if (count($results->where('term',1))){
                        $a1 = round($results->where('term', 1)
                                ->sum('total')/count($results->where('term',1)),2);
                    }else{
                        $a1 = 0;
                    }
                    if (count($results->where('term',2))){
                        $a2 = round($results->where('term', 2)
                                ->sum('total')/count($results->where('term',2)),2);
                    }else{
                        $a2 = 0;
                    }
                    if (count($results->where('term',3))){
                        $a3 = round($results->where('term', 3)
                                ->sum('total')/count($results->where('term',3)),2);
                    }else{
                        $a3 = 0;
                    }


	$content.= "<table class=\"noborder\">
                    <tr>
                        <td width=\"110px\"><strong>1st TERM AVG.:</strong></td>
                        <td class=\"underline\" width=\"100px\" id=\"\">
                            ".$a1."
                        </td>
                        <td width=\"70px\"><strong>2nd TERM:</strong></td>
                        <td class=\"underline\" width=\"100px\" >
                            ".$a2."
                        </td>
                        <td width=\"70px\"><strong>3rd TERM:</strong></td>
                        <td class=\"underline\" width=\"100px\" >
                             ".$a3."
                        </td>
                        <td width=\"90px\"><strong>CUMM. AVG.:</strong></td>
                        <td class=\"underline\" width=\"100px\" >";
                        if ($a1 == 0 || $a2 == 0 || $a3 == 0){
                            $content .= round(($a1+$a2+$a3)/2,2);
                        }else{
                            $content .= round(($a1+$a2+$a3)/3,2);
                        }
                       $content.="</td>
                    </tr>
                </table>";
                    $p1=$student->positions->where('level',$level)->where('session',$session)->where('term',1)->first();
                    $p2=$student->positions->where('level',$level)->where('session',$session)->where('term',2)->first();
                    $p3=$student->positions->where('level',$level)->where('session',$session)->where('term',3)->first();
                $content.="<table class=\"noborder\">
                    <tr>
                        <td width=\"130px\"><strong>1st TERM POSITION:</strong></td>
                        <td class=\"underline\" width=\"50px\" >";
                        if($p1)
                        $content .= $p1->position;
                    $content.="</td>
                        <td width=\"80px\"><strong>2nd TERM:</strong></td>
                        <td class=\"underline\" width=\"50px\" >";
                        if($p2)
                            $content .= $p2->position;
                    $content.="</td>
                        <td width=\"70px\"><strong>3rd TERM:</strong></td>
                        <td class=\"underline\" width=\"50px\" >";
                    if($p3)
                        $content .= $p3->position;
                    $content.="</td>
                        <td width=\"130px\"><strong>ANNUAL POSITION:</strong></td>
                        <td class=\"underline\" width=\"170px\" >";
                        if ($p3)
                            $content .= $p3->overall_pos .' out of '. $p3->number_in_class;
                        $content.="</td>
                    </tr>
                </table>
	
	<table class=\"noborder\" >
                    <tr>
                        <td width=\"185px\"><strong>Class Teacher's Comment :</strong></td>
                        <td class=\"underline\">";
                            if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                $content .= $pos->comment;
                        $content .="</td>
                    </tr>
                </table>
                <table class=\"noborder\">
                    <tr>
                        <td width=\"140px\"><strong>Class Teacher's Name :</strong></td>
                        <td class=\"underline\" width=\"280px\">".$student->class_teacher."</td>

                        <td width=\"70px\"><strong>Signature</strong></td>
                        <td class=\"underline\" width=\"200px\"></td>
                    </tr>
                </table>
                <table class=\"noborder\" >
                    <tr>
                        <td width=\"150px\"><strong>Principal's Comment :</strong></td>
                        <td class=\"underline\">

                        </td>
                    </tr>
                </table>
                <table class=\"noborder\">
                    <tr>
                        <td width=\"155px\"><strong>Principal's Signature</strong></td>
                        <td class=\"underline\"></td>
                        <td width=\"200px\"></td>
                        <td width=\"40\"><strong>Date</strong></td>
                        <td class=\"underline\"></td>
                    </tr>
                </table>
  </div>
        </div>";
                }else{
                    $content .= "
<div class=\"details\">
                <table class=\"noborder\">
                    <tr>
                        <td width=\"40px\"><strong></strong></td>

                        <td width=\"700px\"> </td>
                        <td class=\"underline\" >".$session."/" . ($session+1)."</td>
                        <td width=\"65px\"><strong>SESSION</strong></td>
                    </tr>
                </table>
                <table class=\"noborder\">
                    <tr>
                        <td width=\"150px\"><strong>Name of Student:</strong></td><td colspan=\"2\" class=\"underline\">
                            ".$student->name."</td>
                        <td width=\"180px\"></td>
                        <td width=\"60px\"><strong>Term</strong></td>
                        <td class=\"underline\" >".Auth::user()->ordinal($term)."</td>
                    </tr>
                </table>";
                    $attendance = $student->attendances->where('term',$term)->where('class',$level)->where('session',$session)->first();
                $content .="<table class=\"noborder\">
                    <tr>
                        <td width=\"155px\"><strong>Maximum Attendance:</strong></td>
                        <td class=\"underline\" width=\"100px\">";
                            if(isset($attendance->total))
                                $content .=$attendance->total;
                    $content .="</td>
                        <td width=\"100px\"></td>
                        <td width=\"150px\"><strong>Times Present:</strong></td>
                        <td class=\"underline\" >";
                            if(isset($attendance->present))
                                $content .=$attendance->present;
                    $content .="</td>
                        <td width=\"60px\"><strong>Class:</strong></td>
                        <td class=\"underline\" >$student->student_class</td>
                    </tr>
                </table>
                <table class=\"noborder\">
                    <tr>
                        <td width=\"155px\"><strong>Next Term Begins:</strong></td>
                        <td class=\"underline\">";
                            if($pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                                $content .= $pos->resume_date->format('d-M-Y');
                        $content.="</td>
                        <td width=\"300px\"></td>
                        <td width=\"60px\"><strong>Date</strong></td>
                        <td class=\"underline\" >";
                            if($pos = $student->positions->where('level', $level)->where('term', $term)->first()->term_settings)
                                $content .=$pos->close_date->format('d-M-Y');
                        $content .="</td>
                    </tr>
                </table>
            </div>

<br>

            <table cellspacing=\"0\" class=\"top table-bordered\">
<tr><td width=\"417px\">Continuous Assessment 30%<br>Examination 70%</td>
<td>90-100 Excellent, 80-89 Very Good, 50-79 Good, 40-49 Fair, 0-39 Poor</td>
<td width=\"325px\"></td>
</tr>
</table>
<div class=\"results\">

                <div class=\"tdiv\">
            <table cellspacing=\"0\" class='table'>
			 <tr>
                <th class=\"subject\">SUBJECT</th>
                <th class=\"rotate\"><div>1ST CA TEST</div></th>
                <th class=\"rotate\"><div>2ND CA TEST</div></th>
                <th class=\"rotate\"><div>EXAM</div></th>
                <th class=\"rotate\"><div>TOTAL</div></th>
                <th class=\"rotate\"><div>CLASS<br> HIGHEST</div></th>
                <th class=\"rotate\"><div>CLASS<br> AVERAGE</div></th>
                <th class=\"rotate\"><div>CLASS<br> LOWEST</div></th>
                <th class=\"rotate\"><div>POSITION <br> IN CLASS</div></th>
                <th class=\"rotate\"><div>GRADE</div></th>
                <th class=\"rotate\"><div>TEACHERS <br> REMARK</div></th>

             </tr>";
                    foreach($results as $k => $result) {
                        $content .= "<tr id='subj'";
                        if ($result->total < 40){
                            $content .= "class=\"fail\"";
                        }
                        $content .= ">
                <td style='text-align: left; line-height:25px;'>".$result->subject_title."</td>
                <td>".$result->ca1."</td>
				<td>".$result->ca2."</td>
                <td>".$result->exam."</td>
                <td>".$result->total."</td>
                <td>".$result->class_highest."</td>
                <td>".$result->class_average."</td>
                <td>".$result->class_lowest."</td>
                <td>".$result->positions."</td>
				<td>".$result->grade."</td>
                <td class=\"remark\">".$result->remark."</td>
            </tr>";
                    }
                    $rate = $student->rates->where('term',$term)
                        ->where('class',$level)->where('session',$session)->first();

                    $content .= "</table>
			 </div>

                <div class=\"sdiv\">

        <table cellspacing=\"0\" class=\"small\" border='1'>
        	<tr><th>RATE THESE TRAITS</div></th>
            <th>5 Point<br>Rating<br>Scale<br>5-4-3-2-1&nbsp;<br></th></tr>
            	<tr><td>Punctuality</td><td>";
                    if(isset($rate->punctuality))
                        $content.= $rate->punctuality;
                    $content .="</td></tr>
                        <tr><td>Class Atendance</td><td>";
                    if(isset($rate->attendance))
                        $content.= $rate->attendance;
                    $content .="</td></tr>
                        <tr><td>Carrying out Assignment</td><td>";
                    if(isset($rate->assignments))
                        $content.= $rate->assignments;
                    $content .="</td></tr>
                        <tr><td>Perseverance</td><td>";
                    if(isset($rate->perseverance))
                        $content.= $rate->perseverance;
                    $content.="</td></tr>
                        <tr><td>Self Control</td><td>";
                    if(isset($rate->self_control))
                        $content.= $rate->self_control;
                    $content.="</td></tr>
                        <tr><td>Self Confidence</td><td>";
                    if(isset($rate->self_confidence))
                        $content.= $rate->self_confidence;
                    $content.="</td></tr>
                        <tr><td>Endurance</td><td>";
                    if(isset($rate->endurance))
                        $content.= $rate->endurance;
                    $content.="</td></tr>
                        <tr><td>Respect</td><td>";
                    if(isset($rate->respect))
                        $content.= $rate->respect;
                    $content.="</td></tr>
                        <tr><td>Relationship with others</td><td>";
                    if(isset($rate->relationship))
                        $content.= $rate->relationship;
                    $content.="</td></tr>
                        <tr><td>Leadership/Team Spirit</td><td>";
                    if(isset($rate->leadership))
                        $content.= $rate->leadership;
                    $content.="</td></tr>
                        <tr><td>Honesty</td><td>";
                    if(isset($rate->honesty))
                        $content.= $rate->honesty;
                    $content.="</td></tr>
                        <tr><td>Neatness</td><td>";
                    if(isset($rate->neatness))
                        $content.= $rate->neatness;
                    $content .= "</td></tr>
                        <tr><td>Responsibilty</td><td>";
                    if(isset($rate->responsibility))
                        $content.= $rate->responsibility;
                    $content.="</td></tr>
                        <tr><td>Sport & Athletics</td><td>";
                    if(isset($rate->sports))
                        $content.= $rate->sports;
                    $content.="</td></tr>
                        <tr><td>Manual Skills</td><td>";
                    if(isset($rate->skills))
                        $content.= $rate->skills;
                    $content.="</td></tr>
                        <tr><td>Participation in Group Project</td><td>";
                    if(isset($rate->group_projects))
                        $content.= $rate->group_projects;
                    $content .= "</td></tr>
                        <tr><td>Merit</td><td>";
                    if(isset($rate->merit))
                        $content.= $rate->merit;
                    $content .= "</td></tr>

        </table>
        </div>
        <div class=\"base\">
    <table class=\"noborder\">
                    <tr>
                        <td width=\"70px\"><strong>Average:</strong></td>
                        <td class=\"underline\"  width=\"100px\">";
                        if(count($results))
                            $content.= round(($results->sum('total')/count($results)),2);
                           $content.="</td>
                        <td width=\"60px\"><strong>Total:</strong></td>
                        <td class=\"underline\">".$results->sum('total')."</td>
                        <td width=\"60px\"><strong>Grade:</strong></td>
                        <td class=\"underline\" width=\"50px\">";
                            if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                $content .= $pos->grade;
                        $content .= "</td>
                        <td width=\"120px\"><strong>Position in Class:</strong></td>
                        <td class=\"underline\" width=\"200px\">";
                            if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                $content .= $pos->position .' out of '.$pos->number_in_class;
                        $content.="</td>
                    </tr>

                </table>
                <table class=\"noborder\">
                    <tr>
                        <td width=\"195px\"><strong>Class Teacher's Comment :</strong></td>
                        <td class=\"underline\">";
                            if($pos = $student->positions->where('level', $level)->where('term', $term)->first())
                                $content .= $pos->comment;
                        $content .="</td>
                    </tr>
                </table>
                <table class=\"noborder\">
                    <tr>
                        <td width=\"170px\"><strong>Class Teacher's Name :</strong></td>
                        <td class=\"underline\" width=\"500px\">
                            ".$student->class_teacher."
                        </td>
                        <td width=\"70px\"><strong>Signature</strong></td>
                        <td class=\"underline\"></td>
                    </tr>
                </table>
                <table class=\"noborder\" >
                    <tr>
                        <td width=\"150px\"><strong>Principal's Comment :</strong></td>
                        <td class=\"underline\">
                        </td>
                    </tr>
                </table>
                <table class=\"noborder\">
                    <tr>
                        <td width=\"150px\"><strong>Principal's Signature</strong></td>
                        <td class=\"underline\"></td>
                        <td width=\"150px\"></td>
                        <td width=\"60\"><strong>Date</strong></td>
                        <td class=\"underline\"></td>
                    </tr>
                </table>
  </div>
        </div>
			";

                }

            }

        }
        $content .= "</html>";

        $pdf = \PDF::loadHTML($content);
        return $pdf->stream('Res-'.$this->getClassName($level).$div.$this->term($term).'.pdf');
    }

}
