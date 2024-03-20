<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisParametersCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'subtitle',
        'cardinality',
        'parent_id',
    ];

    /**
     * Get all of the subcategories for the DiagnosisParametersCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(DiagnosisParametersCategory::class, 'parent_id');
    }

    /**
     * Get all of the parameters for the DiagnosisParametersCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameters()
    {
        return $this->hasMany(DiagnosisParameter::class, 'category');
    }
}
