<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request, String $loginType)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials["rol"] = \Str::upper($loginType);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'invalidCredentials' => 'Los credenciales no son validos.',
        ]);
    }

    public function loginPatient(Request $request){
        return $this->authenticate($request,'Patient');
    }
    public function loginDoctor(Request $request){
        return $this->authenticate($request,'Doctor');
    }
    public function loginSecretary(Request $request){
        return $this->authenticate($request,'Secretary');
    }
    public function loginAdmin(Request $request){
        return $this->authenticate($request,'Admin');
    }
}
