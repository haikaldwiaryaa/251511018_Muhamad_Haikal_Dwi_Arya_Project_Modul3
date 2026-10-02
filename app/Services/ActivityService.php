<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use DomainException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            throw new DomainException("Transiti status {$current} ke {$next} tidak diizinkan.");
        }
    }

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw new DomainException('Hanya kegiatan berstatus draft yang padat dipublikasikan.');
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

    /**
     * Independent Challenge: Atomic Registration (IC-01 sampai IC-06)
     */
    public function registerParticipant(Activity $activity, array $data, bool $simulateFail = false): Registration
    {
        // IC-01: Hanya untuk kegiatan published
        if ($activity->status !== 'published') {
            throw new DomainException('Pendaftaran hanya dapat dilakukan untuk kegiatan yang berstatus published.');
        }

        // IC-02: Ditolak jika waktu pelaksanaan sudah lewat
        $startTime = $activity->start_at ?? ($activity->activity_date ? Carbon::parse($activity->activity_date)->startOfDay() : null);
        if ($startTime && $startTime->isPast()) {
            throw new DomainException('Pendaftaran ditolak karena kegiatan sudah dimulai atau tanggal pelaksanaan telah lewat.');
        }

        // IC-03: Email tidak boleh mendaftar 2 kali pada kegiatan yang sama
        if ($activity->registrations()->where('email', $data['email'])->exists()) {
            throw new DomainException('Email sudah terdaftar pada kegiatan yang sama.');
        }

        // IC-04: Jumlah pendaftar tidak boleg melebihi kapasitas
        if ($activity->registered_count >= $activity->capacity) {
            throw new DomainException('Jumlah pendaftar sudah mencapai batas kapasitas maksimal.');
        }

        // IC-05 & IC-06: Atomic Transaction dengan simulasi rollback
        return DB::transaction(function () use ($activity, $data, $simulateFail) {
            $registration = $activity->registrations()->create([
                'participant_name' => $data['participant_name'],
                'email' => $data['email'],
                'registered_at' => now(),
            ]);

            // Simulasi kegagalan operasi kedua untuk membuktikan rollback terkontrol
            if ($simulateFail) {
                throw new DomainException('Simulasi kegagalan update registered_count (Rollback Test).');
            }

            $activity->increment('registered_count');

            return $registration;
        });
    }
}
