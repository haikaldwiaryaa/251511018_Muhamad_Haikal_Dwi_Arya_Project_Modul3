<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Activity extends Model
{
    protected $fillable = [
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
}
