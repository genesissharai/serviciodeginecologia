<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function registerAdmin(Request $request): RedirectResponse
    {
        return $this->register($request,"ADMIN");


    }

    public function registerDoctor(Request $request): RedirectResponse
    {
        return $this->register($request,"DOCTOR");


    }

    public function registerSecretary(Request $request): RedirectResponse
    {
        return $this->register($request,"SECRETARY");


    }

    public function registerPatient(Request $request): RedirectResponse
    {
       return $this->register($request,"PATIENT");

    }

    public function register(Request $request, String $userRol){
        $uniqueEmailRule =  Rule::unique('users')->where(function ($query) use($request, $userRol){
                        return $query->where('email', $request['email']??'')
                        ->where('rol', $userRol ??'');
                    });

        $uniqueCiRule =  Rule::unique('users')->where(function ($query) use($request, $userRol){
                        return $query->where('ci', $request['ci']??'')
                        ->where('rol', $userRol ??'');
                    });

        \Log::info($uniqueEmailRule);
        \Log::info($uniqueCiRule);


        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmailRule],
            'ci' => ['required', 'numeric', $uniqueCiRule],
            'password' => ['required', Rules\Password::defaults()],
        ];
        if($userRol == "DOCTOR"){
            $validationRules['hierarchy'] = ['required', 'string', 'max:255'];
            $validationRules['specialty'] = ['required', 'string', 'max:255'];
        }
        $request->validate($validationRules);
        try{
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'ci' => $request->ci_type.$request->ci,
                'rol' => $userRol,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            if($userRol == "DOCTOR"){
                $doctor = Doctor::create([
                    'hierarchy' => $request->hierarchy,
                    'specialty' => $request->specialty,
                    'user_id' => $user->id,
                    'status' => 1,
                ]);
            }

            event(new Registered($user));

            //Auth::login($user);

            return redirect('/');
        }catch(\Exception $e){
            \Log::info($e);
            return redirect()->back()->withErrors(["error" => "Algo ha fallado"]);
        }
    }
}
