<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatingRoomAttendance extends Model
{
    use HasFactory;

    protected $table = "attendance";
    protected $fillable = [
        'doctor_id',
        'attendance_date',
        'type',
        'subject',
    ];


    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id')->where('rol', strtoupper('doctor'));
    }
}
