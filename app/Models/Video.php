<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'videos';

    protected $fillable = [
        'title',
        'teacher_id',
        'duration',
        'price',
        'image',
        'progress',
        'description',
        'category',
        'icon',
        'color',
        'level',
        'file'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
