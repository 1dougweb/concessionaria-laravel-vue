<?php

namespace App\Application\Http\Requests\Api\V1\Customers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('customer')?->id;

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customerId),
            ],
            'phone' => ['sometimes', 'string', 'max:50'],
            'document_number' => ['sometimes', 'string', 'max:50'],
            'address' => ['sometimes', 'array'],
            'preferences' => ['sometimes', 'array'],
            'status' => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }
}

