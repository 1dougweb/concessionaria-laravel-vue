<?php

namespace App\Application\Http\Requests\Api\V1\Proposals;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seller_id' => ['sometimes', 'integer', 'exists:users,id'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string', 'in:draft,submitted,under_review,accepted,rejected,expired'],
            'financing' => ['sometimes', 'array'],
            'metadata' => ['sometimes', 'array'],
            'expires_at' => ['sometimes', 'date'],
        ];
    }
}

