<?php

namespace App\Http\Resources\Public\Course;

use App\Enum\Course\CourseTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogResource extends JsonResource
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
            'students' => $this->whenLoaded('enrollements', fn() => $this->enrollements->count()) ?? 0,
            'duration' => $this->duration,
            'price' => $this->price,
            'oldPrice' => null,
            'level' => $this->level,
            'image' => asset('/storage/' . $this->image),
            'format' => match ($this->format) {
                CourseTypeEnum::PDF->value => 'PDF',
                CourseTypeEnum::AUDIO->value => 'Audio',
                CourseTypeEnum::VIDEO->value => 'Video',
                default => 'Inconnu',
            },
            'file' => asset('/storage/' . $this->file),
        ];
    }
}
