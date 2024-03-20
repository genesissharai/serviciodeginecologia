<?php

namespace App\Http\Controllers;
use \App\Models\MedicalHistory;
use \App\Models\DiagnosisParameter;
use \App\Models\DiagnosisParametersCategory;
use \App\Models\PatientData;
use \App\Models\EmergencyContact;
use \App\Models\MedicalHistoryFirstPart;
use \App\Models\MedicalHistorySecondPart;
use \App\Models\MedicalHistoryThirdPart;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class MedicalHistoryController extends Controller
{
    //

    public function create(Request $request){
        $patient = \App\Models\User::find($request->id);
        $title = "Nuevo informe medico";
        $action = '/crearInformeMedicoPaciente';
        $method = "POST";
        return view('admin.informe-medico.formulario-informe-medico', compact('title', 'patient', 'action', "method"));
    }

    public function updateView(Request $request){
        $medicalHistory = MedicalHistory::where('patient_id', $request->id)->first();
        $added_parameters = $medicalHistory->parameters->pluck('id')->toArray();
        $patient_data = $medicalHistory->patientData;
        $emergency_contact = $medicalHistory->emergencyContact;
        $medical_history_first_part = $medicalHistory->fisrtPart;
        $medical_history_second_part = $medicalHistory->secondPart;
        $medical_history_third_part = $medicalHistory->thirdPart;

        $patient = \App\Models\User::find($medicalHistory->patient_id);

        $title = "Historia clinica";

        $action = '/historiaClinicaPaciente';
        $method = "PUT";

        $parameteresCategories = DiagnosisParametersCategory::whereHas('subcategories')->with('subcategories.parameters.subparameters')->get()->toArray();
        $backgroundParametersCategory = $parameteresCategories[0];
        $functionalExamParametersCategory = $parameteresCategories[1];
        $physicalExamParametersCategory = $parameteresCategories[2];
        // return $added_parameters;



        return view('admin.historia-clinica.formulario-historia-clinica', compact('title', 'patient', 'medicalHistory', 'action', 'method',
        'backgroundParametersCategory', 'functionalExamParametersCategory', 'physicalExamParametersCategory',
        'added_parameters', 'patient_data', 'emergency_contact', 'medical_history_first_part', 'medical_history_second_part', 'medical_history_third_part', ));
    }

    public function update(Request $request){
        // return $medical_history_first_part;

        $medicalHistory = MedicalHistory::where('patient_id',$request->patient_id)->first();
        $parameters = DiagnosisParameter::whereIn('id',$request->parameters)->get();

        $medicalHistory->parameters()->sync($parameters);

        $patient_data = $request->patient_data ?? [];
        PatientData::updateOrCreate(['medical_history_id' => $medicalHistory->id], $patient_data);

        $emergency_contact = $request->emergency_contact ?? [];
        EmergencyContact::updateOrCreate(['medical_history_id' => $medicalHistory->id], $emergency_contact);

        $medical_history_first_part = $request->medical_history_first_part ?? [];
        if($medical_history_first_part['egress_reason'] == "OTRAS CAUSAS:")
            $medical_history_first_part['egress_reason'] = $medical_history_first_part['egress_reason'] ." ". $medical_history_first_part['custom_egress_reason'];
        MedicalHistoryFirstPart::updateOrCreate(['medical_history_id' => $medicalHistory->id], $medical_history_first_part);

        $medical_history_second_part = $request->medical_history_second_part ?? [];
        MedicalHistorySecondPart::updateOrCreate(['medical_history_id' => $medicalHistory->id], $medical_history_second_part);

        $medical_history_third_part = $request->medical_history_third_part ?? [];
        MedicalHistoryThirdPart::updateOrCreate(['medical_history_id' => $medicalHistory->id], $medical_history_third_part);

        $patient = \App\Models\User::find($medicalHistory->patient_id);

        session()->flash("success", "Historia médica actualizada con exito");
        return redirect("/historiaClinicaPaciente/".$patient->id);
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
        $pdf->loadHTML('<h1>'.$report->title.'</h1><hr>'.$report->report);
        return $pdf->stream();
    }

}
