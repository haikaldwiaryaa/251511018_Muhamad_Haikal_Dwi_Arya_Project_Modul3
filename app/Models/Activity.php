<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class Activity extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'code',
        'title',
        'description',
        'activity_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }
    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        $validStatuses = ['Planned', 'Ongoing', 'Done'];
        return $query->when(in_array($status, $validStatuses, true), function ($q) use ($status) {
            $q->where('status', $status);
        });
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
