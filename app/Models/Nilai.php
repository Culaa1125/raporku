<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';
    protected $fillable = [
        'id_siswa', 'id_guru', 'id_mapel', 'kelas',
        'nilai_tugas', 'nilai_uts', 'nilai_uas',
        'nilai_akhir', 'status', 'tahun_ajaran', 'semester',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    /**
     * Hitung nilai akhir: 30% Tugas + 30% UTS + 40% UAS
     */
    public static function hitungNilaiAkhir($tugas, $uts, $uas): float
    {
        return round((0.3 * $tugas) + (0.3 * $uts) + (0.4 * $uas), 2);
    }

    /**
     * Tentukan status kelulusan (min. 70)
     */
    public static function tentukanStatus(float $nilaiAkhir): string
    {
        return $nilaiAkhir >= 70 ? 'Lulus' : 'Tidak Lulus';
    }

    /**
     * Validasi nilai (0–100)
     */
    public static function validasiNilai($nilai): bool
    {
        return is_numeric($nilai) && $nilai >= 0 && $nilai <= 100;
    }
}