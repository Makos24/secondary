<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

use Portal\Http\Requests;
use Portal\Models\Subject;
use Portal\Models\Log;
use Auth;

class SubjectController extends Controller
{
    public function __construct()
    {
        //$this->middleware('admin', ['except' => ['subjectsJSON']]);
    }
    public function getNewSubject()
    {
        return view('subject.newsubject');
    }
    public function postNewSubject(Request $request)
    {
		//dd($request->all());
        $this->validate($request,
            ['title' => 'required|string',
            'section' => 'required|string']);
		Subject::create($request->all());	
		if(session()->get('section') == "primary"){
			Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Added a new Subject to primary',
		]);
		}else if(session()->get('section') == "secondary"){
			Log::create([
			'user_id' => Auth::user()->id,
			'action' => 'Added a new Subject to secondary',
		]);
		}else{
				return redirect('/start');
			}
        return back()->with('info', 'Subject saved');
    }
    public function addSubjects(Request $request)
    {
        
    }
    public function showSubjects()
    {
		if(session()->get('section') == "primary"){
			$subjects = Subject::where('section', 'primary')->get();
		}else if(session()->get('section') == "secondary"){
			$subjects = Subject::where('section', 'secondary')->get();
		}else{
				return redirect('/start');
			}
        
        return view('subject.index', compact('subjects'));
    }
    public function subjectJSON(Request $request)
    {
        try{
            if($request->ajax()){
                $subject = Subject::where('id', $request->id)->first();
                if(!$subject){
                    return response()->json(null);
                }
                return response()->json($subject);
            }
        }catch (Exception $e)
        {
            return response()->json($e);
        }
    }

    public function updateSubject(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'section' => 'required|string',
			'sub_section' => 'required',
        ]);
        $subject = Subject::where('id', $request->input('subject_id'))->first();
		$title = $subject->title;
        $subject->update([
           'title' => $request->input('title'),
            'section' => $request->input('section'),
			'sub_section' => $request->input('sub_section')
        ]);
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Updated Subject from '.$title.' to '.$request->input('title'),
		]);
        
        return back()->with('info', 'Subject Updated');
    }

    public function deleteSubject($id)
    {
        $subject = Subject::where('id', $id)->first();
		$sub = $subject;
        $subject->delete();
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Deleted Subject '.$sub->title,
		]);
       
        return back()->with('info', 'Subject Deleted');
    }
	
	public function subjectsJSON(Request $request)
    {
        try{
            if($request->ajax()){
                if($request->level >= 10 && $request->level < 13){
				$subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
			}else if($request->level >= 13 && $request->level < 15){
				$subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
			}
                if(!count($subjects)){
                    return response()->json(null);
                }
                return response()->json($subjects);
            }
        }catch (Exception $e)
        {
            return response()->json($e);
        }
    }
}
