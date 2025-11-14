<?php

namespace App\Application\Http\Requests\Api\V1\Customers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:50'],
            'document_number' => ['sometimes', 'string', 'max:50'],
            'address' => ['sometimes', 'array'],
            'preferences' => ['sometimes', 'array'],
            'status' => ['sometimes', 'string'],
        ];
    }
}

