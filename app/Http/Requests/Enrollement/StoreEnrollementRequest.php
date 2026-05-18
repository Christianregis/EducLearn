<?php

namespace App\Http\Requests\Enrollement;

use App\Enum\User\RoleEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEnrollementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasRole(RoleEnum::STUDENT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'video_id' => ['nullable', 'integer', 'exists:videos,id'],
            'audio_id' => ['nullable', 'integer', 'exists:audios,id'],
        ];
    }
}
