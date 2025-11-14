<?php

namespace App\Application\Http\Requests\Api\V1\Proposals;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total_amount' => ['required', 'numeric', 'min:0'],
            'payment' => ['nullable', 'array'],
            'payment.provider' => ['nullable', 'string'],
            'payment.reference' => ['nullable', 'string'],
            'payment.amount' => ['nullable', 'numeric', 'min:0'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}

