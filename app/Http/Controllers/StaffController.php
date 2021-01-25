<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

use Portal\Http\Requests;
use Portal\Models\User;
use Portal\Models\Subject;
use Portal\Models\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Auth;
use Hash;

class StaffController extends Controller
{
    public function __construct()
    {
        //$this->middleware('admin', ['except' => ['profile','staffs','savePic','getPwdChange','pwdChange']]);
    }
	 public function index()
	{
		return view('staff.profile');
	}

    public function profile()
	{
		return view('staff.profile');
	}
    public function allStaff()
    {
        $staffs = User::where('is_staff', true)->paginate(50);
        if(session()->get('section') == "primary"){
            $subjects = Subject::where('section','primary')->get();
        }else if(session()->get('section') == "secondary"){
            $subjects = Subject::where('section','secondary')->get();
        }else{
            return redirect('/start');
        }
        if(!$staffs){
            session()->flash('info', 'Staff record not found');
            return back();
        }
        return view('staff.index', compact('staffs', 'subjects'));
    }
    public function getRegisterStaff()
    {
        $subjects = Subject::all();
        return view('staff.newstaff', compact('subjects'));
    }

    public function profileJSON(Request $request)
    {
        try{
            if($request->ajax()){

                $staff = User::where('id', $request->id)->first();
				$data = array('sid' => $staff->id,'fname' => $staff->first_name, 'lname' => $staff->last_name, 'oname' =>
                    $staff->other_name, 'name' => $staff->getName(), 'phone' => $staff->phone_number,
                    'address' => $staff->address, 'email' => $staff->email,
					'subject' => Subject::find($staff->entry_year)->title, 'post' =>  $staff->leave_year,
					'level' => $staff->level, 'div' => $staff->class, 'sub' => $staff->entry_year,
					'cl' => $this->getClassName($staff->level),
                );
                return response()->json($data);
            }
        }catch (Exception $e)
        {
            return response()->json($e);
        }
    }
    public function registerStaff(Request $request)
    {
        $this->validate($request, ['first_name' => 'required|max:20|alpha',
            'last_name' => 'required|max:20|alpha',
            'email' => 'required|unique:users',
            'address' => 'required|string',
            'phone' => 'required|string',
			'subject' => 'required|string',
        ]);
        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'other_name' => $request->input('other_name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone'),
			'password' => bcrypt($request->input('first_name')),
			'entry_year' => $request->subject,
			'leave_year' => $request->post,
			'level' => $request->class,
			'class' => $request->div,
			'is_admin' => false,
			'active' => false,
			'is_staff' => true,
        ]);
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Created Staff '.$request->input('first_name').''.$request->input('last_name'),
		]);

        return back()->with('info', 'Staff record saved');
    }
    public function getEditStaff($id)
    {
        $staff = User::where('id', $id)->first();
        $sub = Subject::where('id', $staff->subject_id)->first();
        $subjects = Subject::all();
        if(!$staff){
            session()->flash('info', 'Staff record does not exist');
            return back();
        }
        return view('staff.edit', compact('staff', 'subjects','sub'));
    }
    public function postEditStaff(Request $request)
    {
      $user = User::where('id', $request->sid)->first();
      //dd($user);
        $this->validate($request,
			['first_name' => 'required|max:20|alpha',
            'last_name' => 'required|max:20|alpha',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|string',
            //'designation' => 'required|string',
            //'subject' => 'required|integer',
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'other_name' => $request->input('other_name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone'),
			'entry_year' => $request->subject,//teaching subject
			'leave_year' => $request->post,//post in school
			'level' => $request->class,
			'class' => $request->div,
            //'subject_id' => $request->input('subject'),
            //'qualification' => $request->input('designation'),
        ]);
        Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Updated Staff Record '.$user->getName(),
		]);
        return back()->with('info', 'Staff record updated successfully');
    }
	public function staffs()
    {
   		$staffs = User::where('level','<','16')->
   		where('active', true)->orderBy('first_name', 'asc')->paginate(50);
        return view('staff.index', compact('staffs', 'staffs'));
    }
	 public function savePic(Request $request)
    {
        $staff = User::where('id', $request->id)->first();
        if(!$staff){
            session()->flash('info', 'Staff record not found');
            return response()->json(array('info' => 'Record not found'));
        }
        //$this->validate($request, ['image' => 'required']);
        $old_name = $staff->first_name;
        $filename = $staff->first_name . '-' . $staff->id . '.jpg';
        $old_filename = $old_name . '-' . $staff->id . '.jpg';
        $update = false;
        if (Storage::disk('staffs')->has($old_filename)) {
            $old_file = Storage::disk('staffs')->get($old_filename);
            Storage::disk('staffs')->put($filename, $old_file);
            $update = true;
            //return response()->json(array('info' => 'Picture exists'));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
            response()->json(array('info', 'Image Replaced'));
        }
        Storage::disk('staffs')->put($filename, file_get_contents(Input::file('image')->getRealPath()));
        $staff->update([
            'image' => $filename,
        ]);
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Uploaded Picture '.$filename,
		]);
        return response()->json(array('info' => 'Picture Saved'));
    }

    public function getPwdChange()
    {
        return view('staff.pwdchange');
    }
    public function pwdChange(Request $request)
    {
        $staff = User::where('id', $request->id)->first();
        if (!$staff){
            return back()->with('info', 'Staff not found');
        }
        //dd($staff->password.' '.bcrypt($request->old_password));
		if (Hash::check($request->old_password, $staff->password)) {
            $this->validate($request, ['password' => 'required|confirmed',]);
            $staff = User::where('id', $request->id)->first();
            if (!$staff) {
                return back()->with('info', 'Staff not found');
            }
            $staff->update(['password' => bcrypt($request->password)]);
            return back()->with('info', 'Password changed');
        }else{
            return back()->with('info', 'Old password incorrect');
        }
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

	public function deleteStaff($id)
    {
		$staff = User::where('id',$id)->first();
		$st = $staff->getName();
		$staff = User::where('id',$id)->delete();
		Log::create([
		'user_id' => Auth::user()->id,
		'action' => 'Deleted '.$st.'\'s Records',
		]);

            return back()->with('info', 'Staff Records Deleted');
    }

}
