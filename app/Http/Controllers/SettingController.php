<?php
namespace Portal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Portal\Http\Requests;
use Portal\Models\Setting;
use Portal\Models\Termsetting;
use Carbon\Carbon;

class SettingController extends Controller
{
	public function __construct()
    {
//        $this->middleware('admin');
    }
    public function index()
    {
        $set = Setting::all();

        foreach ($set as $s){
            $setting[] = $s->value;
        }
        //dd($setting);
        return view('setting.index', compact('setting'));
    }

    public function save(Request $request)
    {
        $data = Input::all();
        while (list($key, $value) = each($data)) {
            //dd($key);
            if($key != "_token"){
                //dd($key);
                $setting = Setting::where('key', $key)->first();
                if($key == "title"){
                    $setting->value = $value;
                   // dd($setting->value);
                }elseif ($key =="address"){
                    $setting->value = $value;
                }elseif ($key =="motto"){
                $setting->value = $value;
                }elseif ($key =="icon"){
                    $setting->value = $value;
                }else{
                    $setting->value = $value;
                }
                $setting->save();
            }
        }
        return back();
    }
    public function savePic(Request $request)
    {
        $file = 'logo.jpg';
        Storage::disk('public')->put($file, file_get_contents(Input::file('image')->getRealPath()));

        return response()->json(array('info' => 'Picture Saved'));
    }
    public function getLogoImage($filename)
    {
        $file = Storage::disk('public')->get($filename);
        return new Response($file, 200);
    }
	public function getSettings()
	{
		$term_setting = Termsetting::where('current', true)->first();
		return view('setting.term', compact('term_setting'));	
	}
	
	public function postSettings(Request $request)
	{
		 $this->validate($request, [
                'term' => 'required',
                'session' => 'required',
                'close_date' => 'required',
				'resume_date' => 'required',
            ]);
		$check = Termsetting::where('term', $request->term)->where('session', $request->session)
		->where('current', true)->first();
		if(!$check){
			$current = Termsetting::where('current', true)->first();
			if($current){
				$current->update([
				'current' => false,
				]);
			}
			Termsetting::create([
			'term' => $request->term,
			'session' => $request->session,
			'close_date' => Carbon::parse($request->close_date),
			'resume_date' => Carbon::parse($request->resume_date),
			'current' => true,
			]);	
			return back()->with('info', 'Term Settings Saved');
		}else{
			$check->update([
			'current' => true,
			]);
			return back()->with('info', 'Term Settings Updated');
		}
			
	}
}
