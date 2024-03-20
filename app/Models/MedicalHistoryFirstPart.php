<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistoryFirstPart extends Model
{
    use HasFactory;

    protected $table = "medical_history_first_part";

    protected $fillable = [
        "date_of_admission",
        "hour_of_admission",
        "previous_date_of_admission",
        "reason_for_admission",
        "current_illness",
        "final_diagnosis",
        "provisional_diagnosis",
        "anatopathological_diagnosis",
        "service_diagnosis",
        "egress_reason",
        "egress_date",
        "egress_hour",
        "medical_history_id",
    ];
}
