<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $table = "emergency_contact";

    protected $fillable = [
        "fullname",
        "relationship",
        "address",
        "medical_history_id",

    ];
}
