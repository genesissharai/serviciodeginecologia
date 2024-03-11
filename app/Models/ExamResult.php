<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $table = "exam_results";

    protected $fillable = [
        'doctor_id',
        'reference_id',
        'result',
        'result_date',
        'clinical_history_id',
    ];
}
