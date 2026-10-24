<?php

namespace App\Models;

use Database\Factories\SupplierContactFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'supplier_id',
    'name',
    'email',
    'normalized_email',
    'phone',
    'normalized_phone',
    'is_primary',
    'is_active',
])]
class SupplierContact extends Model
{
    /** @use HasFactory<SupplierContactFactory> */
    use HasFactory;

    protected $attributes = [
        'is_primary' => false,
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
