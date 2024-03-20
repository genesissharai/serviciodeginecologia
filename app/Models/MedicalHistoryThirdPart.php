<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistoryThirdPart extends Model
{
    use HasFactory;

    protected $table = "medical_history_third_part";

    protected $fillable = [
        "bpm_breathing",
        "max_blood_pressure",
        "min_blood_pressure",
        "temperature_celcius",
        "pulse",
        "weight_kgs",
        "diagnosis",
        "exam_date",
        "exam_made_by",
        "service_diagnosis",
        "medical_history_id",
    ];

    /**
     * Get all of the parameters for the MedicalHistorySecondPart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function parameters(): HasManyThrough
    {
        return $this->hasManyThrough(DiagnosisParameter::class, MedicalHistory::class);
    }
}
