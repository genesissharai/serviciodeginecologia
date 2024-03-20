<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'cardinality',
        'parent_id',
        'category',
    ];


    /**
     * Get all of the subparameters for the DiagnosisParameter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subparameters()
    {
        return $this->hasMany(DiagnosisParameter::class, 'parent_id');
    }

}
