<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = '_anggota'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'telphone',
        'agama',
        'jenis_kelamin',
        'tgl_lahir',
        'pekerjaan',
        'alamat',
        'rt',
        'rw',
        'image',
        'status_anggota',
        'saldo',
        'tgl_gabung',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
