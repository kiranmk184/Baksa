<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use Authenticatable;

    //where to redirect admins after login
    protected $redirectTo = '/admin';

    //create a new conroller instance
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

     /**
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function loginForm()
     {
         return view('admin.auth.login');
     }

     public function login(Request $request)
     {

         $this->validate($request, [
             'email' => 'required|email',
             'password' => 'required|min:8'
         ]);

         if(Auth::guard('admin')->attempt([
             'email' => $request->email,
             'password' => $request->password
         ], $request->get('remember'))) {
             return redirect()->intended(route('admin.index'));
         }
         return back()->withInput($request->only('email','password'));
     }

     public function logout(Request $request)
     {
         Auth::guard('admin')->logout();
         $request->session()->invalidate();
         return redirect()->route('admin.login');
     }
}
