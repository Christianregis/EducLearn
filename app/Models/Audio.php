<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audio extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'audios';

    protected $fillable = [
        'title',
        'teacher_id',
        'duration',
        'price',
        'image',
        'progress',
        'description',
        'category',
        'format',
        'icon',
        'color',
        'level',
        'file'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function enrollements() : HasMany
    {
        return $this->hasMany(Enrollement::class);
    }
}
