<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = ['email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_user', 'id_user');
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'id_user', 'id_user');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_user', 'id_user');
    }

    public function isAdmin()  { return $this->role === 'admin'; }
    public function isGuru()   { return $this->role === 'guru'; }
    public function isSiswa()  { return $this->role === 'siswa'; }
}