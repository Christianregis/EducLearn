<?php

namespace App\Http\Resources\Teacher\Courses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'teacher_id' => $this->teacher_id,
            'duration' => $this->duration,
            'price' => $this->price,
            'image' => asset('/storage/'. $this->image),
            'format' => $this->format,
            'progress' => $this->progress,
            'icon' => $this->icon,
            'color' => $this->color,
            'level' => $this->level,
            'file' => asset('/storage/'. $this->file),
            'students' => $this->whenLoaded('enrollements', function(){
                $this->enrollements->count() ?? 0;
            }),
        ];
    }
}
