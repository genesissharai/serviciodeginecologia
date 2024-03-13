<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class MedicalReportController extends Controller
{
    //

    public function store(Request $request){
        $patient = \App\Models\User::find($request->id);
        $informeMedico = new \App\Models\MedicalReport;
        $informeMedico->patient_id = $patient->id;
        $informeMedico->doctor_id = \Auth::id();
        $informeMedico->title = $request->title;
        $informeMedico->report = $request->report;
        $informeMedico->save();
        session()->flash("success", "Informe medico creado con exito");

        return redirect("/informeMedicoPaciente/".$request->id);
    }

    public function create(Request $request){
        $patient = \App\Models\User::find($request->id);
        $title = "Nuevo informe medico";
        $action = '/crearInformeMedicoPaciente';
        $method = "POST";
        return view('admin.informe-medico.formulario-informe-medico', compact('title', 'patient', 'action', "method"));
    }

    public function updateView(Request $request){
        $informeMedico = \App\Models\MedicalReport::find($request->id);
        $patient = \App\Models\User::find($informeMedico->patient_id);
        $title = "Modificar referencia";
        $action = '/modificarInformeMedicoPaciente';
        $method = "PUT";

        return view('admin.informe-medico.formulario-informe-medico', compact('title', 'patient', 'informeMedico', 'action', 'method'));
    }

    public function update(Request $request){
        $informeMedico = \App\Models\MedicalReport::find($request->id);
        $patient = \App\Models\User::find($informeMedico->patient_id);
        $informeMedico->title = $request->title;
        $informeMedico->report = $request->report;
        $informeMedico->save();
        session()->flash("success", "Informe medico actualizado con exito");
        return redirect("/informeMedicoPaciente/".$patient->id);
    }

    public function delete(Request $request){
        $informeMedico = \App\Models\MedicalReport::find($request->id);
        $patient_id = $informeMedico->patient_id;
        $informeMedico->delete();
        session()->flash("success", "Referencia eliminado con exito");
        return redirect("/informeMedicoPaciente/".$patient_id);
    }

    public function getPatientMedicalReports(Request $request){
        if(\Auth::user()->rol == "PATIENT" && \Auth::id() != $request->id)
            return redirect('forbidden');
        $patient = \App\Models\User::find($request->id);
        $title = "Informes medicos";
        $medicalReports = \App\Models\MedicalReport::where('patient_id', $patient->id)->orderBy('created_at','DESC')->paginate(25);
        return view('admin.informe-medico.lista-informes-medicos-paciente', compact('patient','medicalReports','title'));
    }

    public function downloadPDF(Request $request){
        $report = \App\Models\MedicalReport::find($request->report_id);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($report->report);
        return $pdf->stream();
    }

}
