<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class new_tablet extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'news_table';
    
    protected $fillable = [
        'title',
        'description',
        'file_name',
        'slug',
        'status',
        'order',
        'type',
        'author_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
