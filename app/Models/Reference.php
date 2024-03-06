<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $table = "reference";

    protected $fillable = [
        "patient_id",
        "doctor_id",
        "exams",
    ];

    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id')->where('rol', strtoupper('doctor'));
    }

    public function patient(){
        return $this->belongsTo(User::class, 'patient_id')->where('rol', strtoupper('patient'));
    }
}
