<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferecesController extends Controller
{
    //

    public function store(Request $request){
        $patient = \App\Models\User::find($request->id);
        $reference = new \App\Models\Reference;
        $reference->patient_id = $patient->id;
        $reference->doctor_id = \Auth::id();
        $reference->exams = $request->exams;
        $reference->save();
        session()->flash("success", "Referencia creado con exito");

        return redirect("/referenciasPaciente/".$request->id);
    }

    public function create(Request $request){
        $patient = \App\Models\User::find($request->id);
        $title = "Nueva referencia";
        $action = '/crearReferenciaPaciente';
        $method = "POST";
        return view('admin.examenes.formulario-referencias', compact('title', 'patient', 'action', "method"));
    }

    public function updateView(Request $request){
        $reference = \App\Models\Reference::find($request->id);
        $patient = \App\Models\User::find($reference->patient_id);
        $title = "Modificar referencia";
        $action = '/modificarReferenciaPaciente';
        $method = "PUT";

        return view('admin.examenes.formulario-referencias', compact('title', 'patient', 'reference', 'action', 'method'));
    }

    public function update(Request $request){
        $reference = \App\Models\Reference::find($request->id);
        $patient = \App\Models\User::find($reference->patient_id);
        $reference->exams = $request->exams;
        $reference->save();
        session()->flash("success", "Referencia actualizado con exito");
        return redirect("/referenciasPaciente/".$patient->id);
    }

    public function delete(Request $request){
        $reference = \App\Models\Reference::find($request->id);
        $patient_id = $reference->patient_id;
        $reference->delete();
        session()->flash("success", "Referencia eliminado con exito");
        return redirect("/referenciasPaciente/".$patient_id);
    }

    public function getPatientReferences(Request $request){
        if(\Auth::user()->rol == "PATIENT" && \Auth::id() != $request->id)
            return redirect('forbidden');
        $patient = \App\Models\User::find($request->id);
        $title = "Referencias mandados";
        $references = \App\Models\Reference::where('patient_id', $patient->id)->orderBy('created_at','DESC')->paginate(25);
        return view('admin.examenes.lista-referencias-paciente', compact('patient','references','title'));
    }


}
