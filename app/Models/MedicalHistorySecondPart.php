<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistorySecondPart extends Model
{
    use HasFactory;
    protected $table = "medical_history_second_part";

    protected $fillable = [
        "diagnosis",
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
