<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\User;
use ReCaptcha\ReCaptcha;
use Config;

class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::check()){
            if($request->next != null){
                return redirect($request->next);
            }else{
                return redirect('/admin/dashboard');
            }
        }else{
            return view('auth.login');
        }
    }

    public function authenticate(Request $request){

        $recaptcha = new ReCaptcha(Config::get('recaptcha.secret_key'));
        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$resp->isSuccess()) {
            $errors = $resp->getErrorCodes();
            $error = "reCAPTCHA failed, please try again.";
            return redirect()->back()->withError($error)->withInput();
        }
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
                'administrator' => true
            ];

            $remember = ($request->remember == 'on' ? true : false);
            if(Auth::attempt($credentials, $remember)){

                if($request->next != null){
                    return redirect($request->next);
                }else{
                    return redirect('/admin/dashboard');
                }

            }else{
                $error = "Username or Password is incorrect";
                return redirect()->back()->withInput()->withError($error);
            }
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/admin');
    }
}
