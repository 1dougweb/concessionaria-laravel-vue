<?php

namespace App\Application\Http\Requests\Api\V1\Vehicles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['nullable', 'uuid'],
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string'],
            'type' => ['sometimes', 'string', 'in:car,motorcycle,truck'],
            'brand' => ['sometimes', 'string', 'max:255'],
            'model' => ['sometimes', 'string', 'max:255'],
            'year' => ['sometimes', 'integer', 'between:1980,' . now()->addYear()->year],
            'mileage' => ['sometimes', 'integer', 'min:0'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'currency' => ['sometimes', 'string', 'size:3'],
            'fuel_type' => ['sometimes', 'string', 'max:255'],
            'transmission' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'string'],
            'stock_count' => ['sometimes', 'integer', 'min:0'],
            'description' => ['sometimes', 'string'],
            'specifications' => ['sometimes', 'array'],
            'metadata' => ['sometimes', 'array'],
        ];
    }
}

