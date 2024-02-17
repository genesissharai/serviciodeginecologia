<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCalendar extends Model
{
    use HasFactory;

    protected $table = 'medical_calendar';
    protected $fillable = [
        'doctor_id',
        'start',
        'end',
    ];
}
