<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasRole('teacher');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'duration' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'level' => ['required', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'max:2048'],
            'icon' => ['nullable', 'image', 'max:1024'],
            'file' => ['required', 'file', 'mimes:mp4,mkv,avi,flv,wmv', 'max:512000'],
        ];
    }
}
