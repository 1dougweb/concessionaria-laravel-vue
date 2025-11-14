<?php

namespace App\Domain\Vehicles\Models;

use App\Domain\Customers\Models\Customer;
use App\Domain\Proposals\Models\Proposal;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'created_by',
        'updated_by',
        'title',
        'slug',
        'type',
        'brand',
        'model',
        'year',
        'mileage',
        'price',
        'currency',
        'fuel_type',
        'transmission',
        'status',
        'stock_count',
        'description',
        'specifications',
        'metadata',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'metadata' => 'array',
            'published_at' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(VehicleStatusHistory::class);
    }

    protected static function newFactory(): VehicleFactory
    {
        return VehicleFactory::new();
    }
}

