<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MedicalCalendar;
use App\Models\MedicalConsultation;

class CitasController extends Controller
{
    //

    public function getSchedulesPatient(Request $request, $id){
        $searchTerms = $request->all();
        $action = "/listaCitasPaciente/$id";
        $user = User::find($id);
        if(\Auth::user()->id != $id && \Auth::user()->rol != "PATIENT"){
            return redirect('/forbidden');
        }
        if(!$request->fecha_inico && !$request->fecha_fin){
            $request->fecha_inicio = \Carbon\Carbon::now();
        }
        $schedules = MedicalConsultation::where('patient_id',$id)
                    ->when($request->fecha_inicio, function($q) use($request){
                        $q->whereDate('consultation_date', ">=" , ($request->fecha_inicio));
                    })
                    ->when($request->fecha_fin, function($q) use($request){
                        $q->whereDate('consultation_date', "<=" ,  ($request->fecha_fin));
                    })
                    ->orderBy('consultation_date','ASC')
                    ->paginate(25);
        $title = "Citas programadas";
        return view('admin.citas.lista-citas', compact('title','searchTerms','schedules','action'));
    }

    public function getSchedulesDoctor(Request $request, $id){
        $searchTerms = $request->all();
        $action = "/listaCitasDoctor/$id";
        $user = User::find($id);
        if(\Auth::user()->id != $id && \Auth::user()->rol != "PATIENT" && \Auth::user()->rol != "DOCTOR"){
            return redirect('/forbidden');
        }
        if(!$request->fecha_inico && !$request->fecha_fin){
            $request->fecha_inicio = \Carbon\Carbon::now();
        }
        $schedules = MedicalConsultation::where('doctor_id',$id)
                    ->when($request->fecha_inicio, function($q) use($request){
                        $q->whereDate('consultation_date', ">=" , ($request->fecha_inicio));
                    })
                    ->when($request->fecha_fin, function($q) use($request){
                        $q->whereDate('consultation_date', "<=" ,  ($request->fecha_fin));
                    })
                    ->orderBy('consultation_date','ASC')
                    ->paginate(25);
        $title = "Citas programadas";
        return view('admin.citas.lista-citas', compact('title','searchTerms','schedules','action'));
    }

    public function getSchedules(Request $request){
        $searchTerms = $request->all();
        $action = "/listaCitas";
        if(\Auth::user()->rol == "PATIENT"){
            return redirect('/forbidden');
        }
        if(!$request->fecha_inico && !$request->fecha_fin){
            $request->fecha_inicio = \Carbon\Carbon::now();
        }
        $schedules = MedicalConsultation::
                    when($request->fecha_inicio, function($q) use($request){
                        $q->whereDate('consultation_date', ">=" , ($request->fecha_inicio));
                    })
                    ->when($request->fecha_fin, function($q) use($request){
                        $q->whereDate('consultation_date', "<=" ,  ($request->fecha_fin));
                    })
                    ->orderBy('consultation_date','ASC')
                    ->paginate(25);
        $title = "Citas programadas";
        return view('admin.citas.lista-citas', compact('title','searchTerms','schedules','action'));
    }

    public function selectDoctorForAvailabilityPlanning(Request $request){
        $searchTerms = $request->input();

        // SI ES PACIENTE NEGARLE PERMISOS
        if(\Auth::user()->rol == "PATIENT"){
            return redirect('/forbidden');
        }
        // SI ES DOCTOR ENTRAR DIRECTAMENTE A AGENDAR DISPONIBILIDAD
        if(\Auth::user()->rol == "DOCTOR" ){
            return redirect(url('/agendarDisponibilidad/'.\Auth::id()));
        }
        $doctor = User::find($request->id);
        $doctor_list = User::where('rol','DOCTOR')
        ->when(($request->name), function($q) use($request){
            $q->where(function($q2) use($request){
                $q2->where("name", "like", "%$request->name%")
                    ->orWhere("last_name", "like", "%$request->name%");
            });
        })
        ->when(($request->email), function($q) use($request){
            $q->where("email", $request->email);
        })
        ->whereHas('doctorHierarchy', function($q){
            $q->where('doctor_hierarchies.hierarchy', 'Especialista'); // 6 => Especialista
        })
        ->orderBy('name','ASC')->orderBy('last_name','ASC')->where('status', 1)->paginate(100);

        return view('admin.citas.seleccionar-doctor-para-agendar-disponibilidad', [
            'title' => "Seleccione al medico",
            'doctor_list' => $doctor_list,
            'searchTerms' => $searchTerms,
        ]);
    }

    public function selectDoctorDateScheduling(Request $request){
        $searchTerms = $request->input();

        $doctor = User::find($request->id);
        // SI ES DOCTOR ENTRAR DIRECTAMENTE A AGENDAR CITA PARA EL
        if(\Auth::user()->rol == "DOCTOR" ){
            return redirect(url('/agendarCita/'.\Auth::id() ) );
        }
        $doctor_list = User::where('rol','DOCTOR')
        ->when(($request->name), function($q) use($request){
            $q->where(function($q2) use($request){
                $q2->where("name", "like", "%$request->name%")
                    ->orWhere("last_name", "like", "%$request->name%");
            });
        })
        ->when(($request->email), function($q) use($request){
            $q->where("email", $request->email);
        })
        ->whereHas('doctorHierarchy', function($q){
            $q->where('doctor_hierarchies.hierarchy', 'Especialista'); // 6 => Especialista
        })
        ->orderBy('name','ASC')->orderBy('last_name','ASC')->where('status', 1)->paginate(100);

        return view('admin.citas.seleccionar-doctor-para-agendar-cita', [
            'title' => "Seleccione al medico",
            'doctor_list' => $doctor_list,
            'searchTerms' => $searchTerms,
        ]);
    }

    public function availabilityPlanning(Request $request){
        if(\Auth::user()->rol == "PATIENT" || (\Auth::user()->rol == "DOCTOR" && $request->id != \Auth::id())){
            return redirect('/forbidden');
        }

        $doctor = User::find($request->id);
        if(!$doctor || $doctor->rol !== "DOCTOR"){
            return redirect()->back()->withErrors([1 => "Usuario seleccionado no es médico"]);
        }
        return view('admin.citas.agendar-disponibilidad-doctor', [
            'title' => "Agendar Disponibilidad de medico",
            'doctorId' => $doctor->id,
        ]);
    }

    public function dateScheduling(Request $request){
        $doctor = User::find($request->id);
        if(!$doctor || $doctor->rol !== "DOCTOR"){
            return redirect()->back()->withErrors([1 => "Usuario seleccionado no es médico"]);
        }
        return view('admin.citas.agendar-cita', [
            'title' => "Agendar cita",
            'doctorId' => $doctor->id,
        ]);
    }


    public function scheduleAvailability(Request $request){
        \DB::beginTransaction();
        try{
            $doctor = User::find($request->id);
            if($request->newEvents && count($request->newEvents)){
                foreach($request->newEvents as $event) {
                    $nuevo  = MedicalCalendar::create($event);
                }
            }
            if($request->eliminados && count($request->eliminados)){
                MedicalCalendar::whereIn('id',$request->eliminados)->delete();
            }
            \DB::commit();
            return ['success' => true];

        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);
            return ['success' => false, 'error' => $e];
        }
    }

    public function scheduleConsultation(Request $request){
        \DB::beginTransaction();
        try{
            $doctor = User::find($request->id);
            $patient = User::find($request->idPatient);

            $date =  new \Carbon\Carbon($request->consultation_date);
            $now = new \Carbon\Carbon();

            $patientSchedule = MedicalConsultation::
            where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->where('consultation_date', ">=", $now->toDateString())
            ->where('status', strtoupper("pending"))->first();

            if($patientSchedule){
                return ['success' => false,
                'errorCode' => 1,
                'error' => "El paciente ya tiene una cita para el: ".  (new \Carbon\Carbon($patientSchedule->consultation_date))->toDateString()];
            }

            $medicalConsultations = MedicalConsultation::where('doctor_id', $request->id)
            ->whereDate('consultation_date', $date->toDateString())
            ->where('status', strtoupper("pending"))
            ->orderBy('consultation_date','asc')
            ->get();

            $endDate = $date->copy();
            $endDate->hour = 12;
            $endDate->minute = 00;
            $newDate = $date->copy();
            if($medicalConsultations->count() > 0){
                $last = $medicalConsultations->last();
                $newDate = (new \Carbon\Carbon($last->consultation_date))->copy();
                $newDate->addMinutes(30);
                if($newDate->greaterThanOrEqualTo($endDate)){
                    \DB::rollback();
                    return ['success' => false,
                    'errorCode' => 2,
                    'error' => "No hay disponibilidad para este día"];
                }
            }
            $new = MedicalConsultation::create([
                "patient_id" => $patient->id,
                "doctor_id" => $doctor->id,
                "status" => strtoupper("pending"),
                "consultation_date" => $newDate->toDateTimeString(),
            ]);
            \DB::commit();
            $newDate = (new \Carbon\Carbon($new->consultation_date));
            return ['success' => true,
            'message' => "Cita agendada para el ". $newDate->toDateString(). " a las ". $newDate->toTimeString() ];

        }catch(\Exception $e){
            \DB::rollback();
            \Log::info($e);

            return ['success' => false,
            'errorCode' => 3,
            'error' => $e];
        }
    }

    public function getDoctorAvailability(Request $request){

        $schedules = MedicalCalendar::where('doctor_id', $request->id)
        ->whereDate('start', ">=" , new \Carbon\Carbon($request->start))
        ->whereDate('end', "<=" ,  new \Carbon\Carbon($request->end))
        ->orderBy('start','asc')
        ->select(['id', 'start', 'end'])->get();
        foreach($schedules as $scheduledDay){
            $scheduledDay->title = 'Disponible';
            $scheduledDay->available = true;
            $now = new \Carbon\Carbon();
            $medicalConsultations = MedicalConsultation::where('doctor_id', $request->id)
            ->whereBetween('consultation_date', [$scheduledDay->start,$scheduledDay->end])
            ->where('status', strtoupper("pending"))->get();
            // if($now->greaterThan($scheduledDay->start) && $now->diffInHours($scheduledDay->start) < 24) $scheduledDay->title = 'Hoy';

            if(($now->greaterThan($scheduledDay->start))) {
                $scheduledDay->title = 'No disponible';
                $scheduledDay->available = false;
            }
            if($medicalConsultations->count() > 0 && $now->diffInDays($scheduledDay->start,false) < 3){
                $last = $medicalConsultations->last();
                $lastTime = new \Carbon\Carbon($last->consultation_date);
                $scheduledDayTime = new \Carbon\Carbon($scheduledDay->start);
                $scheduledDayTime->hour = 11;
                $scheduledDayTime->minute = 30;
                if($lastTime->greaterThanOrEqualTo(new \Carbon\Carbon($scheduledDayTime))){
                    $scheduledDay->title = 'No disponible';
                    $scheduledDay->available = false;
                }
            }

        }
        return $schedules;

    }

    public function getPatientSchedules(Request $request){

        $now = new \Carbon\Carbon();

        $user = \Auth::user();

        $schedules = $patientSchedule = MedicalConsultation::
        where('doctor_id', $request->id_doctor)
        ->when($user->rol == "PATIENT", function($q) use($request){
            $q->where('patient_id', $request->id);
        })
        ->where('consultation_date', ">=", $now->toDateString())
        ->where('status', strtoupper("pending"))->get();

        foreach($schedules as $schedule){
            $date = (new \Carbon\Carbon($schedule->consultation_date));
            $schedule->title = "Cita: ". $date->format("h:i A");
            $schedule->fullName = $schedule->patient->fullName();
            $schedule->start = $schedule->consultation_date;
            $schedule->type = "Cita";
            $schedule->_id = $schedule->id;
        }

        return $schedules;

    }

    public function searchPatients(Request $request){

        $users = User::
        where('rol', strtoupper('patient'))
        ->where(function($q) use($request){
            $q->where('name', 'like', "%".$request->search."%")
            ->orWhere('last_name', 'like', "%".$request->search."%")
            ->orWhere('ci', 'like', "%".$request->search."%");
        })
        ->get();

        return $users;
    }

    public function cancelSchedule(Request $request) { return $this->changeScheduleStatus($request, 'canceled'); }
    public function markAsAttended(Request $request) {

        $result = $this->changeScheduleStatus($request, 'attended');
        // session()->flash("success", "Cita actualizada con exito");

        return redirect()->back();

    }
    public function markAsUnattended(Request $request) {

        $result = $this->changeScheduleStatus($request, 'unattended');
        // session()->flash("success", "Cita actualizada con exito");

        return redirect()->back();

    }


    public function changeScheduleStatus(Request $request, $status){
        $schedule = MedicalConsultation::find($request->id);

        $schedule->status = strtoupper($status);
        $schedule->save();

        return ["success" => true];
    }
}
