<?php

namespace App\Models;

use Database\Factories\SubmissionStatusHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['submission_id', 'from_status', 'to_status', 'changed_by', 'note'])]
class SubmissionStatusHistory extends Model
{
    /** @use HasFactory<SubmissionStatusHistoryFactory> */
    use HasFactory;

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
