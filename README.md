# Activity Manager v1

Aplikasi web manajemen kegiatan berbasis Laravel untuk praktikum Proyek 3 (Modul 3).

## Prasyarat
- PHP >= 8.2
- Composer
- SQLite / MySQL

## Langkah Menjalankan Proyek

1. **Clone repository:**
   `ash
   git clone https://github.com/haikaldwiaryaa/251511018_Muhamad_Haikal_Dwi_Arya_Project_Modul3.git
   cd activity-manager
   `

2. **Install dependensi:**
   `ash
   composer install
   `

3. **Setup environment:**
   `ash
   cp .env.example .env
   php artisan key:generate
   `

4. **Jalankan database migration dan seeder:**
   `ash
   php artisan migrate --seed
   `

5. **Jalankan server aplikasi:**
   `ash
   php artisan serve
   `

6. **Akses aplikasi di browser:**
   Buka alamat http://127.0.0.1:8000/activities

## Fitur Aplikasi
- **CRUD Kegiatan:** Melihat daftar, melihat detail, menambah, mengubah, dan menghapus kegiatan.
- **Validasi Input:** Menggunakan Form Request (StoreActivityRequest & UpdateActivityRequest).
- **Business Logic:** Aturan transisi status (Planned -> Ongoing -> Done) ditegakkan di ActivityService.
- **Filter Status:** Menyaring kegiatan berdasarkan status melalui query string URL.
