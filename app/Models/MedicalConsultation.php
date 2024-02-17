<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalConsultation extends Model
{
    use HasFactory;

    protected $table = "medical_consultations";
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'status',
        'notes',
    ];
}
