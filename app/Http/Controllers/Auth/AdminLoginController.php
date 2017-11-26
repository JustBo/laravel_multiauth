<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
  /**
   * Create a new controller instance
   */
    public function __construct(){
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    /**
     * Show the application dashboard
     * @return \Illuminate\Http\Response
     */
    public function index(){
      return view('admin.auth.login');
    }

    /**
     * admin login
     * @param  Request $request
     * @return redirect
     */
    public function login(Request $request){
      // Validate the form data
      $this->validate($request, [
        'userName' => 'required',
        'password' => 'required'
      ]);
      // Attempt to log the admin in
      $credentials = array(
        'userName' => $request->userName,
        'password' => $request->password
      );
      if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
        // If successful , redirect to their intended location
        print_r('false');
        return redirect()->intended(route('admin.dashboard'));
      }
      // If unsuccessful , redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('userName', 'remember'));
    }

    /**
     * Log the admin out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
