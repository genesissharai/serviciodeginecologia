<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultadosExamenesController extends Controller
{
    //

    public function store(Request $request){
        $reference = \App\Models\Reference::find($request->id);
        $patient = \App\Models\User::find($reference->patient_id);
        $clinical_history = \DB::table('gynecological_clinical_history')->where('user_id',$patient->id)->first();
        $examResult = new \App\Models\ExamResult;
        $examResult->doctor_id = \Auth::id();
        $examResult->reference_id = $reference->id;
        $examResult->result = $request->result;
        $examResult->result_date = \Carbon\Carbon::now();
        $examResult->clinical_history_id = $clinical_history->id;
        $examResult->save();
        session()->flash("success", "Referencia creado con exito");

        return redirect("/referenciasPaciente/".$patient->id);
    }

    public function create(Request $request){
        $reference = \App\Models\Reference::find($request->id);
        $title = "Registrar resultado examen";
        $patient = \App\Models\User::find($reference->patient_id);
        $action = '/registrarResultadoExamenPaciente';
        $method = "POST";
        return view('admin.examenes.formulario-resultado-examenes', compact('title', 'reference', 'patient', 'action', "method"));
    }

    public function updateView(Request $request){
        $examResult = \App\Models\ExamResult::find($request->id);
        $reference = \App\Models\Reference::find($examResult->reference_id);
        $patient = \App\Models\User::find($reference->patient_id);
        $title = "Modificar examen";
        $action = '/modificarResultadoExamenPaciente';
        $method = "PUT";

        return view('admin.examenes.formulario-resultado-examenes', compact('title','reference', 'patient', 'examResult', 'action', 'method'));
    }

    public function update(Request $request){
        $examResult = \App\Models\ExamResult::find($request->id);

        $reference = \App\Models\Reference::find($examResult->reference_id);
        $patient = \App\Models\User::find($reference->patient_id);
        $examResult->result = $request->result;
        $examResult->save();
        session()->flash("success", "Resultado de examen actualizado con exito");
        return redirect("/referenciasPaciente/".$patient->id);
    }

    public function delete(Request $request){
        $reference = \App\Models\Reference::find($request->id);
        $patient_id = $reference->patient_id;
        $reference->delete();
        session()->flash("success", "Resultado de examen eliminado con exito");
        return redirect("/referenciasPaciente/".$patient_id);
    }



}
