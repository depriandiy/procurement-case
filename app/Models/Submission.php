<?php

namespace App\Models;

use Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'reference_no',
    'supplier_id',
    'contact_id',
    'parent_id',
    'revision_no',
    'status',
    'submitted_at',
    'valid_until',
    'currency',
    'verification_code',
    'supplier_name',
    'supplier_tax_id',
    'supplier_address',
    'contact_name',
    'contact_email',
    'contact_phone',
])]
class Submission extends Model
{
    /** @use HasFactory<SubmissionFactory> */
    use HasFactory, HasUlids;

    protected $attributes = [
        'revision_no' => 1,
        'status' => 'submitted',
        'currency' => 'IDR',
    ];

    public function uniqueIds(): array
    {
        return ['public_token', 'client_token'];
    }

    protected function casts(): array
    {
        return [
            'revision_no' => 'integer',
            'submitted_at' => 'datetime',
            'valid_until' => 'date',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(SupplierContact::class, 'contact_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SubmissionItem::class)->orderBy('line_no');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(SubmissionStatusHistory::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    public function supplierLinkHistories(): HasMany
    {
        return $this->hasMany(SubmissionSupplierLinkHistory::class);
    }
}
