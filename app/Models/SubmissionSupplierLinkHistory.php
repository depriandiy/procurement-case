<?php

namespace App\Models;

use Database\Factories\SubmissionSupplierLinkHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'submission_id',
    'from_supplier_id',
    'to_supplier_id',
    'changed_by',
    'reason',
])]
class SubmissionSupplierLinkHistory extends Model
{
    /** @use HasFactory<SubmissionSupplierLinkHistoryFactory> */
    use HasFactory;

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function fromSupplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'from_supplier_id');
    }

    public function toSupplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'to_supplier_id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
