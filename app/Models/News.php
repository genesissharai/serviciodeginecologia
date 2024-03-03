<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
        use HasFactory;
        protected $table = 'News';
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
