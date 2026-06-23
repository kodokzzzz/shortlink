<?php

namespace App\Http\Requests;

use App\Models\Link;
use App\Models\ReservedSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'original_url' => ['required', 'url', 'max:2048'],
            'title' => ['nullable', 'string', 'max:150'],
            'slug' => [
                'nullable',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('links', 'slug')->where(function ($query) {
                    return $query->where('status', '!=', 'deleted');
                }),
                function ($attribute, $value, $fail) {
                    if ($value && ReservedSlug::where('slug', strtolower($value))->exists()) {
                        $fail('This slug is reserved and cannot be used.');
                    }
                },
            ],
            'password' => ['nullable', 'string', 'min:1', 'max:255'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => [
                'nullable',
                'date',
                Rule::when($this->filled('starts_at'), ['after:starts_at']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'original_url.required' => 'Please enter a URL.',
            'original_url.url' => 'Please enter a valid URL (e.g., https://example.com).',
            'original_url.max' => 'The URL is too long (max 2048 characters).',
            'slug.min' => 'Custom slug must be at least 3 characters.',
            'slug.max' => 'Custom slug must not exceed 100 characters.',
            'slug.regex' => 'Custom slug can only contain letters, numbers, hyphens, and underscores.',
            'slug.unique' => 'This slug is already taken.',
            'expires_at.after' => 'The expiry time must be after the start time.',
        ];
    }
}
