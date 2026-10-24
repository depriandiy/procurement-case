<?php

namespace App\Models;

use Database\Factories\SubmissionItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'submission_id',
    'line_no',
    'catalog_item_id',
    'base_unit_id',
    'raw_item_name',
    'raw_unit',
    'offered_price',
    'price_includes_tax',
    'tax_rate',
    'conversion_factor',
    'price_excl_tax',
    'normalized_unit_price',
    'moq',
    'lead_time_days',
    'notes',
])]
class SubmissionItem extends Model
{
    /** @use HasFactory<SubmissionItemFactory> */
    use HasFactory;

    protected $attributes = [
        'price_includes_tax' => false,
        'tax_rate' => 0,
    ];

    protected function casts(): array
    {
        return [
            'line_no' => 'integer',
            'offered_price' => 'decimal:4',
            'price_includes_tax' => 'boolean',
            'tax_rate' => 'decimal:2',
            'conversion_factor' => 'decimal:6',
            'price_excl_tax' => 'decimal:4',
            'normalized_unit_price' => 'decimal:6',
            'moq' => 'decimal:4',
            'lead_time_days' => 'integer',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function catalogItem(): BelongsTo
    {
        return $this->belongsTo(CatalogItem::class);
    }

    public function baseUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }
}
