<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GynecologicalClinicalHistory extends Model
{
    use HasFactory;
    protected $table = 'gynecological_clinical_history';
    protected $fillable = [
        'address',
        'gender',
        'civil_state',
        'have_partner',
        'reason',
        'gynecological_history',
        'date_last_menstruation',
        'transmitted_diseases',
        'contraceptive_method',
        'family_background',
        'notes',
        'user_id',
        'doctor_id',
    ];


    /**
     * Get the user that owns the GynecologicalClinicalHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
