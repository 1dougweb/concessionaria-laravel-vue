<?php

namespace App\Application\Http\Requests\Api\V1\Proposals;

use Illuminate\Foundation\Http\FormRequest;

class StoreProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'uuid'],
            'customer_id' => ['required', 'uuid'],
            'seller_id' => ['nullable', 'integer', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string'],
            'financing' => ['nullable', 'array'],
            'metadata' => ['nullable', 'array'],
            'expires_at' => ['nullable', 'date'],
        ];
    }
}

