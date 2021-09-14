<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


     /**
     * Write code on Method
     *
     * @return response()
     */
    public function login(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only('password', 'name');
        if (Auth::attempt($credentials)) {

            return redirect()->route('items.index')->with('success', 'You have Successfully loggedin');

        }

        return redirect()->route('login')->with('error', 'Oppes! You have entered invalid credentials');

        // return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
}
