
# RaporKu — Aplikasi E-Rapor Berbasis Web

RaporKu adalah aplikasi e-rapor berbasis web untuk mempermudah pengelolaan nilai akademik siswa SMA. Aplikasi ini membantu proses pencatatan nilai, perhitungan nilai akhir otomatis, penentuan status kelulusan, serta pembuatan laporan nilai secara efektif dan sistematis.

## Fitur Utama

- **Autentikasi Pengguna:** Login dan logout berdasarkan hak akses pengguna.
- **Manajemen Siswa:** Mengelola data siswa, NIS, nama, dan kelas.
- **Manajemen Guru:** Mengelola data guru dan mata pelajaran yang diampu.
- **Input Nilai:** Memasukkan nilai Tugas, UTS, dan UAS.
- **Perhitungan Otomatis:** Menghitung nilai akhir siswa secara otomatis.
- **Validasi Nilai:** Memastikan nilai berada pada rentang 0–100.
- **Status Kelulusan:** Menentukan status Lulus atau Tidak Lulus.
- **Laporan Nilai:** Menampilkan rekap nilai berdasarkan siswa, kelas, dan mata pelajaran.
- **Cetak dan Ekspor:** Mendukung kebutuhan pencetakan atau ekspor laporan nilai sesuai implementasi aplikasi.

## Hak Akses Pengguna

| Role | Hak Akses |
|---|---|
| Admin | Mengelola data guru dan siswa, menginput nilai, serta melihat dan mencetak laporan nilai. |
| Guru | Menginput nilai dan melihat rekap nilai siswa berdasarkan kelas dan mata pelajaran. |
| Siswa | Melihat nilai Tugas, UTS, UAS, nilai akhir, dan status kelulusan pribadi. |

## Rumus Perhitungan Nilai

Nilai akhir dihitung menggunakan rumus:

```text
Nilai Akhir = (30% × Tugas) + (30% × UTS) + (40% × UAS)
```

Ketentuan penilaian:

- Nilai Tugas, UTS, dan UAS berada pada rentang 0–100.
- **Lulus:** Nilai akhir ≥ 70.
- **Tidak Lulus:** Nilai akhir < 70.
- Status kelulusan ditentukan untuk setiap mata pelajaran.

## Teknologi yang Digunakan

- **Backend:** PHP dan Laravel
- **Frontend:** HTML, Tailwind CSS, JavaScript Vanilla, dan/atau Alpine.js
- **Database:** MySQL
- **Web Server:** Laragon (Nginx)

## Persyaratan Sistem

- PHP 8.2 atau lebih baru
- Laravel 11 atau lebih baru
- MySQL
- Composer
- Browser web versi terbaru

## Struktur Database

| Tabel | Deskripsi |
|---|---|
| `users` | Menyimpan akun pengguna dan role. |
| `admin` | Menyimpan data Admin. |
| `guru` | Menyimpan data guru dan mata pelajaran. |
| `siswa` | Menyimpan data siswa, NIS, nama, dan kelas. |
| `mapel` | Menyimpan data mata pelajaran. |
| `nilai` | Menyimpan nilai Tugas, UTS, UAS, nilai akhir, dan status kelulusan. |

## ⚙️ Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/Culaa1125/raporku
   ```

2. Masuk ke direktori proyek:

   ```bash
   cd <NAMA-DIREKTORI-PROYEK>
   ```

3. Instal dependensi:

   ```bash
   composer install
   ```

4. Salin file `.env.example` menjadi `.env`.

   ```bash
   cp .env.example .env
   ```

   Pada Windows, file dapat disalin secara manual.

5. Buat application key:

   ```bash
   php artisan key:generate
   ```

6. Buat database MySQL dan sesuaikan konfigurasi database pada file `.env`.

7. Jalankan migrasi database jika file migrasi tersedia:

   ```bash
   php artisan migrate
   ```

8. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

9. Buka alamat lokal yang ditampilkan di terminal pada browser.

> **Catatan:** Sesuaikan langkah instalasi dengan konfigurasi dan file yang tersedia di repository.

## Batasan Sistem

- Antarmuka dirancang untuk penggunaan desktop.
- Belum mendukung impor nilai massal dari Excel atau CSV.
- Nilai yang valid berada pada rentang 0–100.
- Sistem memiliki tiga role: Admin, Guru, dan Siswa.
- Data guru dan siswa diinput secara manual oleh Admin.
- Hanya pengguna yang terdaftar di database yang dapat mengakses sistem.
- Batas kelulusan adalah nilai akhir minimal 70 untuk setiap mata pelajaran.

## Tujuan Pengembangan

Aplikasi ini dikembangkan untuk meningkatkan efisiensi pengelolaan data akademik dengan menerapkan konsep Pemrograman Terstruktur dan Object-Oriented Programming (OOP).

## Informasi Proyek

- **Nama Aplikasi:** RaporKu
- **Jenis:** Aplikasi E-Rapor Berbasis Web
- **Platform:** Web
- **Kegiatan:** Tugas 1 Pembekalan LSP Skema Programmer — Kelompok 4

---

**RaporKu — Mempermudah Pengelolaan Nilai Akademik secara Digital.**
