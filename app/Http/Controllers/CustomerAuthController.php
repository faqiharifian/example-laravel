<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Socialite;
use App\Models\CustomerAccount;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use DB;
use ReCaptcha\ReCaptcha;
use Config;


class CustomerAuthController extends Controller
{
    public function login(){
        if(Auth::check()){
            return redirect('/');
        }
        return view('login');
    }
    public function redirect($provider)
    {
        return Socialite::with($provider)->redirect();
    }

    public function authenticate(Request $request){
        $recaptcha = new ReCaptcha(Config::get('recaptcha.secret_key'));
        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$resp->isSuccess()) {
            $errors = $resp->getErrorCodes();
            $error = "reCAPTCHA failed, please try again.";
            return redirect()->back()->withError($error)->withInput();
        }

        if($request->submit == "SIGN IN") {
            $credentials = [
                'email' => $request->email_login,
                'password' => $request->password_login,
            ];

            if (Auth::attempt($credentials, false)) {
                $next = session()->pull('next', '/');
                return redirect($next);
                /*if ($request->next != null) {
                    return redirect($request->next);
                } else {
                    return redirect('/');
                }*/

            } else {
                $error = "Username or Password is incorrect";
                return redirect()->back()->withInput()->withError($error);
            }
        }else if($request->submit == "SIGN UP"){
            $this->validate($request, [
                'name' => 'required',
                'email_register' => 'required|email',
                'password' => 'required|confirmed|min:6'
            ]);

            $user = User::whereEmail($request->email_register)->first();

            if($user != null){
                if($user->administrator == true){
                    return redirect()->back()->withError('Email is already used..')->withInput();
                }else{
                    $customer = $user->customers()->whereProvider('amartha')->first();
                    if($customer != null){
                        return redirect()->back()->withError('Email is already used.')->withInput();
                    }
                }
            }

            $input = [
                'provider_user_id' => 0,
                'provider' => 'amartha',
                'name' => $request->name,
                'login' => false,
            ];

            DB::beginTransaction();
            $account = new CustomerAccount($input);

            $user = User::whereEmail($request->email_register)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $request->email_register,
                    'password' => bcrypt($request->password),
                    'administrator' => false,
                ]);
            }else{
                $user->password = bcrypt($request->password);
                $user->save();
            }

            $account->user()->associate($user);
            $account->save();

            DB::commit();

            $success = "Account Created Successfully";
            return redirect()->action('CustomerAuthController@login')->withSuccess($success);
        }
        return redirect()->back()->withInput();
    }

    public function callback($provider)
    {
        $user = $this->createOrGetUser(Socialite::with($provider)->user(), $provider);

        Auth::login($user);

        $next = session()->pull('next', '/');
        return redirect($next);
    }

    public function createOrGetUser(ProviderUser $providerUser, $provider)
    {
        $account = CustomerAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        $input = [
            'provider_user_id' => $providerUser->getId(),
            'provider' => $provider,
            'name' => $providerUser->getName(),
            'login' => true,
        ];

        if ($account) {
            $account->fill($input)->save();
            return $account->user;
        } else {

            DB::beginTransaction();
            $account = new CustomerAccount($input);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'administrator' => false,
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            DB::commit();

            return $user;

        }
    }

    public function logout(){
        $customer = Auth::user()->customers()->whereLogin(true)->first();

        if($customer){
            $customer->login = false;
            $customer->save();
        }

        Auth::logout();
        return redirect()->back();
    }
}
