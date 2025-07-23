<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_ktp',
        'no_hp',
        'pekerjaan',
        'tanggal_lahir',
        'agama',
        'jenis_kelamin',
        'tgl_gabung',
        'rt',
        'rw',
        'image',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
