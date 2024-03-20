<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $table = "medical_history";

    protected $fillable = [
        "patient_id",
        "doctor_id",
    ];


    /**
     * The parameters that belong to the MedicalHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parameters()
    {
        return $this->belongsToMany(DiagnosisParameter::class, 'med_history_diagnosis_params', 'medical_history_id', 'diagnosis_parameter_id');
    }

    /**
     * Get the patientData associated with the MedicalHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patientData()
    {
        return $this->hasOne(PatientData::class, 'medical_history_id');
    }


    /**
     * Get the emergencyContact associated with the MedicalHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emergencyContact()
    {
        return $this->hasOne(EmergencyContact::class, 'medical_history_id');
    }

    /**
     * Get the fisrtPart associated with the MedicalHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fisrtPart()
    {
        return $this->hasOne(MedicalHistoryFirstPart::class, 'medical_history_id');
    }
    /**
     * Get the secondPart associated with the MedicalHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function secondPart()
    {
        return $this->hasOne(MedicalHistorySecondPart::class, 'medical_history_id');
    }
    /**
     * Get the thirdPart associated with the MedicalHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function thirdPart()
    {
        return $this->hasOne(MedicalHistoryThirdPart::class, 'medical_history_id');
    }


}
