<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommunityPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:140'],
            'location_name' => ['nullable', 'string', 'max:120'],
            'body' => ['required', 'string', 'min:20', 'max:4000'],
        ];
    }
}
