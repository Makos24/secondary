<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Portal\Http\Requests;
use Portal\Models\Staff;
use Portal\Models\Student;
use Portal\Models\User;
use Portal\Models\Log;
use Auth;
class AdminController extends Controller
{
    public function __construct()
    {

//        $this->middleware('admin', ['except' => ['index', 'start']]);
    }
	public function start(Request $request)
	{

		
		session()->put('section', $request->section);
		if(Auth::check()){
			if(Auth::user()->is_admin){
		if(session()->get('section') == "primary"){
			$snum = User::where('level', '>', 3)->where('level','<','10')->where('is_admin', false)
			->where('is_staff', false)->count();
        	$staff = User::where('is_staff', true)->count();
        	$cnum = DB::select('SELECT DISTINCT level,class FROM users 
				WHERE level > 3 AND level < 10 AND is_staff = 0 AND is_admin = 0');
        	$c = count($cnum);	
		}else if(session()->get('section') == "secondary"){

			$snum = User::where('level', '>', 9)->where('level','<','16')->where('is_admin', false)
			->where('is_staff', false)->count();
        	$staff = User::where('is_staff', true)->count();
        	$cnum = DB::select('SELECT DISTINCT level,class FROM users 
				WHERE level > 9 AND level < 16 AND is_staff = 0 AND is_admin = 0');
        	$c = count($cnum);	
		}else{
				return redirect('/start');
			}


			return view('admin.index', compact('snum', 'staff', 'c'));
			}else if(Auth::user()->is_staff){
			
				return redirect('/staff/profile');
			}else if(Auth::user()->active){
				
				return redirect('/student');
			}
		}
	
	}
    public function index()
    {
		
		if(session()->get('section') == "primary"){
			$snum = User::where('level', '>', 3)->where('level','<','10')->where('is_admin', false)
			->where('is_staff', false)->count();
        	$staff = User::where('is_staff', true)->count();
        	$cnum = DB::select('SELECT DISTINCT level,class FROM users 
				WHERE level > 3 AND level < 10 AND is_staff = 0 AND is_admin = 0');
        	$c = count($cnum);	
		}else if(session()->get('section') == "secondary"){
			$snum = User::where('level', '>', 9)->where('level','<','16')->where('is_admin', false)
			->where('is_staff', false)->count();
        	$staff = User::where('is_staff', true)->count();
        	$cnum = DB::select('SELECT DISTINCT level,class FROM users 
				WHERE level > 9 AND level < 16 AND is_staff = 0 AND is_admin = 0');
        	$c = count($cnum);	
		}else{
				return redirect('/start');
			}

		if(Auth::check()){
			if(Auth::user()->is_admin){
			return view('admin.index', compact('snum', 'staff', 'c'));
			}else if(Auth::user()->is_staff){
				return redirect('/staff/profile');
			}else if(Auth::user()->active){
				return redirect('/student');
			}
		}
    }
    public function users()
    {
		$users = User::where('is_admin', true)->get();
        return view('admin.users', compact('users'));
    }
	public function create(Request $request)
	{
		
		 $this->validate($request,
		 [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ] 
            );
		 //dd($request);
			
		User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'is_admin' => 1,
			'is_staff' => 0,
			'active' => 0,
        ]);

        return back()->with('info', 'New Admin Created');
	}
	
	public function adminJSON(Request $request)
    {
        try{
            if($request->ajax()){

                $user = User::where('id', $request->id)->first();
                if(!$user){
                    return response()->json(null);
                }
                return response()->json($user);
            }
        }catch (Exception $e)
        {
            return response()->json($e);
        }
    }
	
	public function update(Request $request)
	{
		$this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
        ]);
        $subject = User::where('id', $request->id)->first();
        $subject->update([
           'name' => $request['name'],
            'email' => $request['email'],
        ]);
        session()->flash('info', 'Admin Updated');
        return back();
	}
	
	public function profile()
	{
		return view('admin.profile');
	}
	

}
