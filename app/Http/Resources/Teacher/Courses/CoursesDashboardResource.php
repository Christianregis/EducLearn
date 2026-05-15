<?php

namespace App\Http\Resources\Teacher\Courses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesDashboardResource extends JsonResource
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
            'format' => $this->format,
            'icon' => $this->icon,
            'iconColor' => $this->color,
            'color' => $this->color,
            'level' => $this->level,
            'students' => $this->whenLoaded('enrollements',fn()=> $this->enrollements->count()),
            'status' => 'Publié'
        ];
    }
}
