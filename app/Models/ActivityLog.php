<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'actor_name',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'properties',
        'ip_address',
        'user_agent',
    ];

    // Tabel hanya menggunakan created_at, tanpa updated_at
    const UPDATED_AT = null;

    // Mengatur tipe data
    protected function casts(): array
    {
        return [
            'properties' => 'array',
            'created_at' => 'datetime',
        ];
    }

    // Relasi ke pengguna yang melakukan aktivitas
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke data yang berkaitan dengan aktivitas
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}