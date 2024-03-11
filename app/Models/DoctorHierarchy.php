<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorHierarchy extends Model
{
    use HasFactory;
    protected $table = "doctor_hierarchies";
    protected $fillable = [
        'hierarchy',
        'specialty',
        'resident',
    ];
}
