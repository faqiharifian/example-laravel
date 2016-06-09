<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereAdministrator(true)->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = true;
        return view('admin.user.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $input = [
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'administrator' => true
        ];
        $user = new User();
        $user->fill($input)->save();

        $success = "New User Added Successfully";
        return redirect()->action('Admin\UserController@index')->withSuccess($success);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user->email = $request->email;
        $user->save();

        $success = "User Updated Successfully";
        return redirect()->action('Admin\UserController@index')->withSuccess($success);
    }

    public function getPassword(User $user){
        return view('admin.user.password', compact('user'));
    }

    public function postPassword(Request $request, User $user)
    {
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Old password is incorrect'])->withInput();
        }

        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        $success = "User's Password Changed Successfully";
        return redirect()->action('Admin\UserController@index')->withSuccess($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Auth::user()->id != $user->id){
            $user->delete();

            $success = "User Deleted Successfully";
            return redirect()->action('Admin\UserController@index')->withSuccess($success);
        }

        return redirect()->action('Admin\UserController@index');
    }
}
