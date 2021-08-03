<?php
namespace App\Http\Controllers;

use App\ContactUs;
use App\ContactUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class AjaxController extends Controller
{

    public function contactform()
    {
        $data = array(
            "name"    => request("name"),
            "email"   => request("email"),
            "subject"   => request("subject"),
            "message" => request("message"),
        );
        $valid = Validator::make($data, [
            'name'    => ['required', 'min:3', 'max:50', 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ ]+$/'],
            'email'   => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'subject' => ['required', 'string', 'min:5', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);
        if ($valid->fails()) {
            $message  = $valid->getMessageBag()->toArray();
            $messages = array();
            foreach ($message as $k => $v) {
                if (is_array($v)) {
                    $messages[$k] = $v[0];
                } else {
                    $messages[$k] = $v;
                }
            }
            return array("resp" => "error", "msg" => $messages);
        } else {
            $email = ContactUser::where('email', '=', request('email'))->first();
            if ($email === null) {
                $data = ContactUser::create([
                    'name'    => request('name'),
                    'email'   => request('email'),
                    'subject' => request('subject'),
                    'content' => request('message'),
                    'type'    => "Contact form",
                ]);
            }
            $from         = request('email');
            $data         = ContactUs::select("r_email")->first();
            $emails       = explode(",", $data['r_email']);
            $subject      = request('subject');
            $mail_content = 'name :' . request('name') . PHP_EOL . 'email: ' . request('email') . PHP_EOL . request('subject') . PHP_EOL . request('message');

            foreach ($emails as $k => $v) {
                $data = array(
                    "name"    => request("name"),
                    "email"   => request("email"),
                    "content" => request('message'),
                    "subject" => request("subject"),
                    "from"    => array("email" => "$from", "label" => request("name")),
                    "to"      => array("email" => $v, "label" => "Engr Abbas"),
                );
                $Mail = new Mail;
                sendEmail($Mail, "email-template.contact", $data);
            }
            return array("resp" => "success", "msg" => "Your Email has been sent Successfully.");
        }
    }
    public function subscriber()
    {
        //dd("ok");
        $data = array(
            "email"   => request("email"),
        );
        $valid = Validator::make($data, [
            'email' => 'required|email|unique:contactusers,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
        ]);
        if ($valid->fails()) {
            $message  = $valid->getMessageBag()->toArray();
            $messages = array();
            foreach ($message as $k => $v) {
                if (is_array($v)) {
                    $messages[$k] = $v[0];
                } else {
                    $messages[$k] = $v;
                }
            }
            return array("resp" => "error", "msg" => $messages);
        } else {
               $data = ContactUser::create([
                'email' => request('email'),
                'type'  => "Subscriber",
            ]); 
            return array("resp" => "success", "msg" => "Your Email has been sent Successfully.");
        }
        
    }
}
