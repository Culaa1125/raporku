<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Nilai;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable = ['id_user', 'nis', 'nama_siswa', 'kelas'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_siswa', 'id_siswa');
    }
}