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
    public function registerAdmin(Request $request){ return $this->register($request,"ADMIN", false); }
    public function registerDoctor(Request $request){ return $this->register($request,"DOCTOR", false); }
    public function registerSecretary(Request $request){ return $this->register($request,"SECRETARY", false); }
    public function registerPatient(Request $request){ return $this->register($request,"PATIENT", false); }

    public function adminRegisterAdmin(Request $request){ return $this->register($request,"ADMIN", true); }
    public function adminRegisterDoctor(Request $request){ return $this->register($request,"DOCTOR", true); }
    public function adminRegisterSecretary(Request $request){ return $this->register($request,"SECRETARY", true); }
    public function adminRegisterPatient(Request $request){ return $this->register($request,"PATIENT", true); }

    // register from admin GET
    public function adminRegisterAdminView(Request $request) { return $this->registerView($request,"ADMIN"); }
    public function adminRegisterDoctorView(Request $request) { return $this->registerView($request,"DOCTOR"); }
    public function adminRegisterSecretaryView(Request $request) { return $this->registerView($request,"SECRETARY"); }
    public function adminRegisterPatientView(Request $request) { return $this->registerView($request,"PATIENT"); }


    // Update GET
    public function updateAdminView(Request $request){ return $this->updateUserView($request,"ADMIN"); }
    public function updateDoctorView(Request $request){ return $this->updateUserView($request,"DOCTOR"); }
    public function updateSecretaryView(Request $request){ return $this->updateUserView($request,"SECRETARY"); }
    public function updatePatientView(Request $request){ return $this->updateUserView($request,"PATIENT"); }

    // Update POST
    public function updateAdmin(Request $request){ return $this->update($request,"ADMIN"); }
    public function updateDoctor(Request $request){ return $this->update($request,"DOCTOR"); }
    public function updateSecretary(Request $request){ return $this->update($request,"SECRETARY"); }
    public function updatePatient(Request $request){ return $this->update($request,"PATIENT"); }


    // List
    public function getAdminList(Request $request){ return $this->getUserList($request,"ADMIN"); }
    public function getDoctorList(Request $request){ return $this->getUserList($request,"DOCTOR"); }
    public function getSecretaryList(Request $request){ return $this->getUserList($request,"SECRETARY"); }
    public function getPatientList(Request $request){ return $this->getUserList($request,"PATIENT"); }


    public function registerView(Request $request, String $userRol){
        $jerarquiasDoctor  = [];
        if($userRol == "ADMIN"){
            $registerType = "registerAdmin";
            $action = "/admin/registerAdmin";
            $title = "Registrar administrador";
        }
        if($userRol == "DOCTOR"){
            $registerType = "registerDoctor";
            $action = "/admin/registerDoctor";
            $jerarquiasDoctor  = \App\Models\DoctorHierarchy::all();
            $title = "Registrar doctor";
        }
        if($userRol == "PATIENT"){
            $registerType = "registerPatient";
            $action = "/admin/registerPatient";
            $title = "Registrar paciente";
        }
        if($userRol == "SECRETARY"){
            $registerType = "registerSecretary";
            $action = "/admin/registerSecretary";
            $title = "Registrar secretario";
        }


        return view('admin.users.register', compact('title','action','registerType','jerarquiasDoctor'));
    }


    public function register(Request $request, String $userRol, $isAdmin){
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
            'doctor_hierarchy_id' => ['numeric'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmailRule],
            'ci' => ['required', 'numeric', $uniqueCiRule],
            'ci_type' => ['required', 'string'],
            'password' => ['required', 'min:4'],
        ];

        $request->validate($validationRules);
        try{
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'ci' => $request->ci_type . $request->ci,
                'rol' => $userRol,
                'email' => $request->email,
                'doctor_hierarchy_id' => $request->doctor_hierarchy_id,
                'birthdate' => $request->birthdate,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            if($userRol == "PATIENT"){
                \DB::table('gynecological_clinical_history')->insert(["user_id" => $user->id]);
            }

            event(new Registered($user));
            session()->flash("success", "Usuario registrado con exito");

            //Auth::login($user);
            \DB::commit();
            if($isAdmin){
                if($userRol == "ADMIN"){ $action = "/getAdmins"; }
                if($userRol == "DOCTOR"){ $action = "/getDoctors";}
                if($userRol == "PATIENT"){ $action = "/getPatients"; }
                if($userRol == "SECRETARY"){ $action = "/getSecretaries"; }
                return redirect($action);
            }

            return redirect('/');
        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return redirect()->back()->withErrors(["errors" => "Algo ha fallado"]);
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
            'doctor_hierarchy_id' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmailRule],
            'ci' => ['required', 'numeric', $uniqueCiRule],
        ];

        $request->validate($validationRules);
        try{
            $user = User::find($request->id);

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->ci =  $request->ci_type . $request->ci;
            $user->email = $request->email;
            $user->doctor_hierarchy_id = $request->doctor_hierarchy_id;
            $user->birthdate = $request->birthdate;
            $user->phone = $request->phone;
            $user->status = $request->status;

            $user->save();

            //Auth::login($user);
            if($userRol == "PATIENT") $urlBack = "/getPatients";
            if($userRol == "DOCTOR") $urlBack = "/getDoctors";
            if($userRol == "SECRETARY") $urlBack = "/getSecretaries";
            if($userRol == "ADMIN") $urlBack = "/getAdmins";

            \DB::commit();
            session()->flash("success", "Usuario actualizado con exito");

            return redirect($urlBack);
        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return redirect()->back()->withErrors(["errors" => "Algo ha fallado"]);
        }
    }



    public function updateUserView(Request $request, String $userRol){
        $jerarquiasDoctor  = [];
        if($userRol == "PATIENT") $title = "Actualizar Paciente";
        if($userRol == "DOCTOR") {
            $title = "Actualizar Doctor";
            $jerarquiasDoctor  = \App\Models\DoctorHierarchy::all();

        }
        if($userRol == "SECRETARY") $title = "Actualizar Secretario";
        if($userRol == "ADMIN") $title = "Actualizar Administrador";

        $user = User::find($request->id);
        $updateType = "update".ucfirst(strtolower($userRol));
        return view('admin.users.update', compact("title", "user", "updateType", "jerarquiasDoctor"));
    }

    public function deleteUser(Request $request){
        \DB::beginTransaction();
        try{
            if( ( \Auth::user()->rol != "ADMIN" && $user->rol != "PATIENT") || \Auth::user()->rol == "PATIENT" )
                return redirect('/forbidden');
            $user = User::find($request->user_id);
            $user->delete();
            session()->flash("success", "Usuario eliminado con exito");

            \DB::commit();

            return redirect()->back();
        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return redirect()->back()->withErrors(["errors" => "Algo ha fallado"]);
        }
    }

    public function getUserList(Request $request, $rol){

        $searchTerms = $request->input();
        $jerarquiasDoctor = [];
        if($rol == "ADMIN"){
            $registerType = "/admin/registerAdmin";
            $action = "/getAdmins";
        }
        if($rol == "DOCTOR"){
            $registerType = "/admin/registerDoctor";
            $action = "/getDoctors";
            $jerarquiasDoctor = \App\Models\DoctorHierarchy::all();
        }
        if($rol == "PATIENT"){
            $registerType = "/admin/registerPatient";
            $action = "/getPatients";
        }
        if($rol == "SECRETARY"){
            $registerType = "/admin/registerSecretary";
            $action = "/getSecretaries";
        }

        $users = User::where('rol', $rol)
            ->when(($request->name), function($q) use($request){
                $q->where(function($q2) use($request){
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
            ->when(($request->doctor_hierarchy_id), function($q) use($request){
                $q->whereHas('doctorHierarchy',function($q2) use($request){
                    $q2->where("doctor_hierarchy_id", $request->doctor_hierarchy_id);
                });
            })
            ->orderBy('name','ASC')
            ->orderBy('last_name','ASC')
            ->paginate(25);
        $title = "Lista de usuarios";

        return view('admin.users.get-users-list', compact('users', 'title', "rol", "action", "searchTerms", "jerarquiasDoctor", 'registerType'));
    }


    public function changeUserPasswordView(Request $request, $id){
        $user = User::find($id);
        if(( \Auth::id() != $id ) && ( \Auth::user()->rol != "ADMIN" && $user->rol != "PATIENT") )
            return redirect('/forbidden');
        $title = "Cambiar contraseña ".$user->fullName()."";
        return view('admin.users.cambiar-contraseña', compact(['title', 'id', 'user']) );
    }

    public function changeUserPassword(Request $request){
        $request->validate($request, [
            'user_id' => 'required',
            'password' => 'min:4|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:4'
            ]);

        $user = User::find($request->user_id);

        $user->password = \Hash::make($request->password);
        $user->save();

        session()->flash("success", "Contraseña de usuario actualizada con exito");

        if(\Auth::user()->rol != "PATIENT"){
            if($userRol == "PATIENT") $urlBack = "/getPatients";
            if($userRol == "DOCTOR") $urlBack = "/getDoctors";
            if($userRol == "SECRETARY") $urlBack = "/getSecretaries";
            if($userRol == "ADMIN") $urlBack = "/getAdmins";
            return redirect($action);
        }
        return redirect('/dashboard');
    }




}
