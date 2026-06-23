<?php

namespace App\Http\Requests;

use App\Models\ReservedSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('link')->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        $linkId = $this->route('link')->id;

        return [
            'original_url' => ['required', 'url', 'max:2048'],
            'title' => ['nullable', 'string', 'max:150'],
            'slug' => [
                'nullable',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('links', 'slug')
                    ->ignore($linkId)
                    ->where(function ($query) {
                        return $query->where('status', '!=', 'deleted');
                    }),
                function ($attribute, $value, $fail) {
                    if ($value && ReservedSlug::where('slug', strtolower($value))->exists()) {
                        $fail('This slug is reserved and cannot be used.');
                    }
                },
            ],
            'password' => ['nullable', 'string', 'min:1', 'max:255'],
            'remove_password' => ['nullable', 'boolean'],
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
            'slug.min' => 'Custom slug must be at least 3 characters.',
            'slug.regex' => 'Custom slug can only contain letters, numbers, hyphens, and underscores.',
            'slug.unique' => 'This slug is already taken.',
            'expires_at.after' => 'The expiry time must be after the start time.',
        ];
    }
}
