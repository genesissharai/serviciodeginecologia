<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MedicalCalendar;
use App\Models\MedicalConsultation;

class CitasController extends Controller
{
    //

    public function selectDoctorForAvailabilityPlanning(Request $request){
        $doctor = User::find($request->id);
        $doctor_list = User::where('rol','DOCTOR')->where('status', 1)->get();

        return view('admin.citas.seleccionar-doctor-para-agendar-disponibilidad', [
            'title' => "Seleccione al medico",
            'doctor_list' => $doctor_list
        ]);
    }

    public function selectDoctorDateScheduling(Request $request){
        $doctor = User::find($request->id);
        $doctor_list = User::where('rol','DOCTOR')->where('status', 1)->get();

        return view('admin.citas.seleccionar-doctor-para-agendar-cita', [
            'title' => "Seleccione al medico",
            'doctor_list' => $doctor_list
        ]);
    }

    public function availabilityPlanning(Request $request){
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
            'title' => "Agendar Disponibilidad de medico",
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

            $date =  new \Carbon\Carbon($request->date);
            $now = new \Carbon\Carbon();

            $patientSchedule = MedicalConsultation::
            where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->where('date', ">=", $now->toDateString())
            ->where('status', strtoupper("pending"))->first();

            if($patientSchedule){
                return ['success' => false,
                'errorCode' => 1,
                'error' => "El paciente ya tiene una cita para el: ".  (new \Carbon\Carbon($patientSchedule->date))->toDateString()];
            }

            $medicalConsultations = MedicalConsultation::where('doctor_id', $request->id)
            ->whereDate('date', $date->toDateString())
            ->where('status', strtoupper("pending"))
            ->orderBy('date','asc')
            ->get();

            $endDate = $date->copy();
            $endDate->hour = 12;
            $endDate->minute = 00;
            $newDate = $date->copy();
            if($medicalConsultations->count() > 0){
                $last = $medicalConsultations->last();
                $newDate = (new \Carbon\Carbon($last->date))->copy();
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
                "date" => $newDate->toDateTimeString(),
            ]);
            \DB::commit();
            $newDate = (new \Carbon\Carbon($new->date));
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
            ->whereBetween('date', [$scheduledDay->start,$scheduledDay->end])
            ->where('status', strtoupper("pending"))->get();
            // if($now->greaterThan($scheduledDay->start) && $now->diffInHours($scheduledDay->start) < 24) $scheduledDay->title = 'Hoy';

            if($now->greaterThanOrEqualTo($scheduledDay->start)) {
                $scheduledDay->title = 'No disponible';
                $scheduledDay->available = false;
            }
            if($medicalConsultations->count() > 0 && $now->diffInDays($scheduledDay->start,false) < 3){
                $last = $medicalConsultations->last();
                $lastTime = new \Carbon\Carbon($last->date);
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
        $schedules = $patientSchedule = MedicalConsultation::
        where('patient_id', $request->id)
        ->where('doctor_id', $request->id_doctor)
        ->where('date', ">=", $now->toDateString())
        ->where('status', strtoupper("pending"))->get();
        foreach($schedules as $schedule){
            $date = (new \Carbon\Carbon($schedule->date));
            $schedule->title = "Cita: ". $date->hour.":".$date->minute;
        }
        return $schedules;

    }
}