<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'title' => 'Menyusun Desain ERD Database',
                'description' => 'Merancang relasi tabel sistem informasi',
                'activity_date' => '2026-09-25',
                'status' => 'Planned',
            ],
            [
                'title' => 'Instalasi Framework Laravel',
                'description' => 'Setup project skeleton dan konfigurasi awal',
                'activity_date' => '2026-09-26',
                'status' => 'Done',
            ],
            [
                'title' => 'Pembuatan Model dan Migration',
                'description' => 'Membuat skema database untuk entitas kegiatan',
                'activity_date' => '2026-09-27',
                'status' => 'Ongoing',
            ],
            [
                'title' => 'Integrasi Form Request Validation',
                'description' => 'Menerapkan validasi input di server boundary',
                'activity_date' => '2026-09-28',
                'status' => 'Planned',
            ],
            [
                'title' => 'Refactoring Business Logic ke Service',
                'description' => 'Memisahkan aturan transisi status dari controller',
                'activity_date' => '2026-09-29',
                'status' => 'Planned',
            ],
        ];

        foreach ($activities as $item) {
            Activity::create($item);
        }
    }
}
