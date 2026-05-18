<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollement extends Model
{
    use HasFactory;

    protected $table = 'enrollements';

    protected $fillable = [
        'student_id',
        'course_id',
        'video_id',
        'audio_id',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function audio(): BelongsTo{
        return $this->belongsTo(Audio::class, 'audio_id');
    }
}
