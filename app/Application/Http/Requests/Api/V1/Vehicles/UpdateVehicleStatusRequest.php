<?php

namespace App\Application\Http\Requests\Api\V1\Vehicles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:draft,published,reserved,sold'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

