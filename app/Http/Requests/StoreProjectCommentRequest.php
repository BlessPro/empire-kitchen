<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // No policies — allow any authenticated user
        return request()->user() !== null;
    }

    public function rules(): array
    {
        return [
            'body' => ['required','string','min:1','max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Body is required.',
            'body.min'      => 'Body is required.',
            'body.max'      => 'Body must be at most 2000 characters.',
        ];
    }

    public function validationData(): array
    {
        $data = parent::validationData();
        if (isset($data['body']) && is_string($data['body'])) {
            $data['body'] = trim($data['body']);
        }
        return $data;
    }
}
