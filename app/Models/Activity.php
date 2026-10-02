<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'title',
        'description',
        'start_at',
        'activity_date',
        'capacity',
        'registered_count',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'start_at' => 'datetime',
            'capacity' => 'integer',
            'registered_count' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        $validStatuses = ['draft', 'published', 'completed', 'Planned', 'Ongoing', 'Done'];
        return $query->when(in_array($status, $validStatuses, true), function ($q) use ($status) {
            $q->where('status', $status);
        });
    }
}
