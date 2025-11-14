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
            'vehicle_id' => ['required', 'uuid', 'exists:vehicles,id'],
            'customer_id' => ['required', 'uuid', 'exists:customers,id'],
            'seller_id' => ['nullable', 'integer', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'in:draft,submitted,under_review,accepted,rejected,expired'],
            'financing' => ['nullable', 'array'],
            'metadata' => ['nullable', 'array'],
            'expires_at' => ['nullable', 'date', 'after:today'],
        ];
    }
}

