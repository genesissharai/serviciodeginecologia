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
    public function registerAdmin(Request $request)
    {
        return $this->register($request,"ADMIN");
    }

    public function registerDoctor(Request $request)
    {
        return $this->register($request,"DOCTOR");
    }

    public function registerSecretary(Request $request)
    {
        return $this->register($request,"SECRETARY");
    }

    public function registerPatient(Request $request)
    {
       return $this->register($request,"PATIENT");
    }


    // Update GET
    public function updateAdminView(Request $request)
    {
        return $this->updateUserView($request,"ADMIN");
    }

    public function updateDoctorView(Request $request)
    {
        return $this->updateUserView($request,"DOCTOR");
    }

    public function updateSecretaryView(Request $request)
    {
        return $this->updateUserView($request,"SECRETARY");
    }

    public function updatePatientView(Request $request)
    {
       return $this->updateUserView($request,"PATIENT");
    }

    // Update POST
    public function updateAdmin(Request $request)
    {
        return $this->update($request,"ADMIN");
    }

    public function updateDoctor(Request $request)
    {
        return $this->update($request,"DOCTOR");
    }

    public function updateSecretary(Request $request)
    {
        return $this->update($request,"SECRETARY");
    }

    public function updatePatient(Request $request)
    {
       return $this->update($request,"PATIENT");
    }


    // List
    public function getAdminList(Request $request)
    {
        return $this->getUserList($request,"ADMIN");
    }

    public function getDoctorList(Request $request)
    {
        return $this->getUserList($request,"DOCTOR");
    }

    public function getSecretaryList(Request $request)
    {
        return $this->getUserList($request,"SECRETARY");
    }

    public function getPatientList(Request $request)
    {
       return $this->getUserList($request,"PATIENT");
    }





    public function register(Request $request, String $userRol){
        \DB::beginTransaction();
        $uniqueEmailRule =  Rule::unique('users')->where(function ($query) use($request, $userRol){
                        return $query->where('email', $request['email']??'')
                        ->where('rol', $userRol ??'');
                    });

        $uniqueCiRule =  Rule::unique('users')->where(function ($query) use($request, $userRol){
                        return $query->where('ci', $request['ci']??'')
                        ->where('rol', $userRol ??'');
                    });


        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmailRule],
            'ci' => ['required', 'numeric', $uniqueCiRule],
            'ci_type' => ['required', 'string'],
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
                'ci' => $request->ci_type . $request->ci,
                'rol' => $userRol,
                'email' => $request->email,
                'birthdate' => $request->birthdate,
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
            \DB::commit();
            return redirect('/');
        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return redirect()->back()->withErrors(["error" => "Algo ha fallado"]);
        }
    }

    public function update(Request $request, String $userRol){
        \DB::beginTransaction();
        $user = User::find($request->id);
        $uniqueEmailRule =  Rule::unique('users')->where(function ($query) use($user, $userRol){
                        return $query->where('email', $user['email']??'')
                        ->where('rol', $userRol ??'')->whereNot('id',$user->id);
                    });

        $uniqueCiRule =  Rule::unique('users')->where(function ($query) use($user, $userRol){
                        return $query->where('ci', $user['ci']??'')
                        ->where('rol', $userRol ??'')->whereNot('id',$user->id);
                    });


        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmailRule],
            'ci' => ['required', 'numeric', $uniqueCiRule],
        ];
        if($userRol == "DOCTOR"){
            $validationRules['hierarchy'] = ['required', 'string', 'max:255'];
            $validationRules['specialty'] = ['required', 'string', 'max:255'];
        }
        $request->validate($validationRules);
        try{
            $user = User::find($request->id);

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->ci =  $request->ci_type . $request->ci;
            $user->email = $request->email;
            $user->birthdate = $request->birthdate;
            $user->phone = $request->phone;

            $user->save();

            if($userRol == "DOCTOR"){
                $doctor = Doctor::where('user_id', $user->id)->update([
                    'hierarchy' => $request->hierarchy,
                    'specialty' => $request->specialty,
                ]);
            }

            //Auth::login($user);
            \DB::commit();
            return redirect()->back()->with(["success" => "Usuario actualizado con exito"]);
        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return redirect()->back()->withErrors(["error" => "Algo ha fallado"]);
        }
    }



    public function updateUserView(Request $request, String $userRol){
        if($userRol == "PATIENT") $title = "Actualizar Paciente";
        if($userRol == "DOCTOR") $title = "Actualizar Doctor";
        if($userRol == "SECRETARY") $title = "Actualizar Secretario";
        if($userRol == "ADMIN") $title = "Actualizar Administrador";
        $user = User::with('doctorData')->find($request->id);
        $updateType = "update".ucfirst(strtolower($userRol));
        return view('admin.users.update', compact("title", "user", "updateType"));
    }

    public function getUserList($request, $rol){
        $users = User::where('rol', $rol)
            ->when(($request->name), function($q) use($request){
                $q->where(function($q2){
                    $q2->where("name", "like", "%$request->name%")
                        ->orWhere("last_name", "like", "%$request->name%");
                });
            })
            ->when(($request->email), function($q) use($request){
                $q->where("email", $request->email);
            })
            ->when(($request->ci), function($q) use($request){
                $q->where("ci", $request->ci);
            })
            ->when(($request->hierarchy), function($q) use($request){
                $q->whereHas('doctorData',function($q2){
                    $q->where("hierarchy", $request->hierarchy);
                });
            })
            ->when(($request->specialty), function($q) use($request){
                $q->whereHas('doctorData',function($q2){
                    $q->where("specialty", $request->specialty);
                });
            })
            ->orderBy('name','ASC')
            ->orderBy('last_name','ASC')
            ->paginate(25);
        $title = "Lista de usuarios";
        return view('admin.users.get-users-list', compact('users', 'title', "rol"));
    }

}
