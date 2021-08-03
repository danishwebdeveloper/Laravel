<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\generalsetting;
use App\Helpers\Options;
class GeneralsettingController extends Controller
{
	
    public $Options;
    public function __construct(){
        $this->Options = new Options;
    }
	public function index()
    {
        $settings = generalsetting::first();
        return view('admin.general-settings',compact('settings'));
    }
    public function store()
    {
		
       // dd(request()->all());
        generalsetting::updateOrCreate(
            ['id'=> request('id') ],
        [
            'logo'=>request('logo'),
            'favicon'=>request('favicon'),
            'og'=>request('og'),
            'contact_number'=>request('contact'),
            'skype'=>request('skype'),
            'email'=>request('email'),
            'smtp_email'=>request('smtp_email'),
            'smtp_password'=>request('smtp_password'),
            'fbid'=>request('fbid'),
            'google_analytics'=>request('google_analytics'),
            'web_master'=>request('web_master'),
            'bing_master'=>request('bing_master'),
            
        ]);
		// updateEnv(["MAIL_USERNAME" => request('smtp_email') , "MAIL_PASSWORD" => request('smtp_password') ]);
        return back()->with('flash_message','Yours settings are updated successfully');
    }
    public function menu(){
        $Options = $this->Options;
        return view('admin.menu' , compact('Options'));
    }
}
