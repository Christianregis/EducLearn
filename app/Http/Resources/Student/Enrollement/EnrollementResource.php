<?php

namespace App\Http\Resources\Student\Enrollement;

use App\Http\Resources\Teacher\Courses\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class EnrollementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'video_id' => $this->video_id,
            'audio_id' => $this->audio_id,
            'course' => match (true) {
                $this->relationLoaded('course') => CourseResource::make($this->course),
                $this->relationLoaded('video')  => CourseResource::make($this->video),
                $this->relationLoaded('audio')  => CourseResource::make($this->audio),
                default => null,
            },
            'video' => CourseResource::make($this->whenLoaded('video')),
            'audio' => CourseResource::make($this->whenLoaded('audio')),
            'created_at' => $this->created_at->format('Y-m-d H:m'),
            'updated_at' => $this->updated_at->format('Y-m-d H:m'),
            'progress' => $this->progress,
        ];
    }
}
