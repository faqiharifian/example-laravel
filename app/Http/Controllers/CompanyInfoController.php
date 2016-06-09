<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;

use Config;
use ReCaptcha\ReCaptcha;
use Validator;

class CompanyInfoController extends Controller
{
    public function aboutUs(){
        $aboutUs = true;
        return view('about-us', compact('aboutUs'));
    }

    public function policies(){
        $policies = true;
        return view('policies', compact('policies'));
    }

    public function contactUs(){
        $contactUs = true;
        return view('contact-us', compact('contactUs'));
    }

    public function postContactUs(Request $request){
        $recaptcha = new ReCaptcha(Config::get('recaptcha.secret_key'));
        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if ($resp->isSuccess()) {
            $email_address = $request->email;
            $name = $request->name;

            $validator = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|email']);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $dataNotif = [
                'name' => $name,
                'email' => $email_address,
                'content' => $request->message
            ];

            Mail::send('emails.notification', $dataNotif, function($message) {
                $message->to(env('MAIL_NOTIFICATION'))->subject('New Message');
            });

            $success = "Message Has Been Sent";
            return redirect(action('CompanyInfoController@contactUs').'#contact-form')->withSuccess($success);
        } else {
            $error = "reCAPTCHA failed, please try again.";
            return redirect(action('CompanyInfoController@contactUs').'#contact-form')->withError($error)->withInput();
        }
    }

}
