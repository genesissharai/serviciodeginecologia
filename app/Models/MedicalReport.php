<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    use HasFactory;
    protected $table = "medical_reports";
    protected $fillable = [
        'title',
        'report',
        'doctor_id',
        'consultation_id',
        'patient_id',
    ];

    public function patient(){
        return $this->belongsTo(User::class, 'patient_id')->where('rol', strtoupper('patient'));
    }

    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id')->where('rol', strtoupper('doctor'));
    }
}
