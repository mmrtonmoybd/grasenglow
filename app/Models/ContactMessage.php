<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContactMessageStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ContactMessage extends CmsModel
{
    /** @use HasFactory<\Database\Factories\ContactMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'status', 'source_page', 'submitted_at',
        'assigned_to', 'internal_notes', 'replied_at', 'archived_at',
    ];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    protected function casts(): array
    {
        return [
            'status' => ContactMessageStatus::class,
            'submitted_at' => 'datetime',
            'replied_at' => 'datetime',
            'archived_at' => 'datetime',
        ];
    }
}
