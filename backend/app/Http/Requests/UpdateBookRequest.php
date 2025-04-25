<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or implement your authorization logic
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'isbn' => 'sometimes|string|unique:books,isbn,' . $this->route('book'),
            'author_id' => 'sometimes|exists:authors,id',
            'description' => 'sometimes|nullable|string',
            'published_date' => 'sometimes|date',
            'cover_url' => 'sometimes|nullable|url',
        ];
    }
}

