<?php

namespace App\Models;

use Database\Factories\SubmissionItemMappingHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'submission_item_id',
    'from_catalog_item_id',
    'to_catalog_item_id',
    'from_unit_id',
    'to_unit_id',
    'conversion_factor',
    'changed_by',
    'note',
])]
class SubmissionItemMappingHistory extends Model
{
    /** @use HasFactory<SubmissionItemMappingHistoryFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['conversion_factor' => 'decimal:6'];
    }

    public function submissionItem(): BelongsTo
    {
        return $this->belongsTo(SubmissionItem::class);
    }

    public function fromCatalogItem(): BelongsTo
    {
        return $this->belongsTo(CatalogItem::class, 'from_catalog_item_id');
    }

    public function toCatalogItem(): BelongsTo
    {
        return $this->belongsTo(CatalogItem::class, 'to_catalog_item_id');
    }

    public function fromUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'from_unit_id');
    }

    public function toUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'to_unit_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
