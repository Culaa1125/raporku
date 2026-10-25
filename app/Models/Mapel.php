<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Guru;
use App\Models\Nilai;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id_mapel';
    protected $fillable = ['kode_mapel', 'nama_mapel', 'deskripsi'];

    public function guru()
    {
        return $this->hasMany(Guru::class, 'id_mapel', 'id_mapel');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_mapel', 'id_mapel');
    }
}