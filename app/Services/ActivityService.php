<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;

class ActivityService
{
    private const TRANSITIONS = [
        'draft' => ['draft', 'published'],
        'published' => ['published', 'completed'],
        'completed' => ['completed'],
    ];


    public function create(array $data): Activity
    {
        $data['status'] = $data['status'] ?? 'draft';
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $nextStatus = $data['status'] ?? $activity->status;

        $this->ensureValidTransition($activity->status, $nextStatus);

        $activity->update($data);

        return $activity->refresh();
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = self::TRANSITIONS[$current] ?? [];

        if (!in_array($next, $allowed, true)) {
            throw new DomainException("Transisi status {$current} ke {$next} tidak diizinkan.");
        }
    }
    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw new DomainException('Hanya kegiatan berstatus draft yang dapat dipublikasikan.');
        }
        if (empty($activity->category_id) || empty($activity->code) || empty($activity->title) || empty($activity->activity_date)) {
            throw new DomainException('Field wajib belum lengkap. Tidak dapat mempublikasikan kegiatan.');
        }
        $activity->update(['status' => 'published']);
        return $activity->refresh();
    }
    public function complete(Activity $activity): Activity
    {
        if ($activity->status !== 'published') {
            throw new DomainException('Hanya kegiatan berstatus published yang dapat diselesaikan.');
        }
        $activity->update(['status' => 'completed']);
        return $activity->refresh();
    }
}
