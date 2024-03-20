<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientData extends Model
{
    use HasFactory;

    protected $table = "patient_data";

    protected $fillable = [
        "fullname",
        "address",
        "sex",
        "ci",
        "civil_status",
        "nationality",
        "birthdate",
        "place_of_birth",
        "occupation",
        "medical_history_id",
    ];
}
