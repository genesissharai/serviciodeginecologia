<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Morbidity extends Model
{
    use HasFactory;
    protected $table = 'Morbidity';
    protected $fillable = [
        'date',
        'hour',
        'name',
        'last_name',
        'ci',
        'age',
        'pregnancies',
        'fvr',
        'ev_x_fur',
        'first_eco',
        'eg_x_eco',
        'ta',
        'au',
        'physical_exam',
        'conduct',
    ];
}
