<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCoursesRequest extends FormRequest
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
            'category' => ['nullable', 'string'],
            'duration' => ['required', 'string'],
            'price' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'format' => ['required', 'string', 'in:pdf,audio,video'],
            'progress' => ['nullable', 'integer'],
            'icon' => ['nullable', 'string'],
            'color' => ['required', 'string'],
            'level' => ['required', 'string'],
            'file' => ['required', 'file'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'category.string' => 'La catégorie doit être une chaîne de caractères.',
            'duration.required' => 'La durée est obligatoire.',
            'duration.string' => 'La durée doit être une chaîne de caractères.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'format.required' => 'Le format est obligatoire.',
            'format.string' => 'Le format doit être une chaîne de caractères.',
            'progress.integer' => 'Le progrès doit être un entier.',
            'icon.string' => 'L\'icône doit être une chaîne de caractères.',
            'color.required' => 'La couleur est obligatoire.',
            'color.string' => 'La couleur doit être une chaîne de caractères.',
            'level.required' => 'Le niveau est obligatoire.',
            'level.string' => 'Le niveau doit être une chaîne de caractères.',
            'file.required' => 'Le fichier est obligatoire.',
            'file.file' => 'Le fichier doit être un fichier valide.',
        ];
    }
}
