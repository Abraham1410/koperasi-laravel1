<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota; // Tambah ini!
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Ke mana redirect setelah register.
     */
    protected $redirectTo = '/home'; // Ubah sesuai kebutuhan

    /**
     * Hanya guest yang boleh akses.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validasi data register.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Buat user + anggota.
     */
    protected function create(array $data)
    {
        // Buat user baru
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'role'     => 'anggota', // Biar role otomatis anggota
            'password' => Hash::make($data['password']),
        ]);

        // Buat anggota yang terhubung ke user barusan
        Anggota::create([
            'user_id'       => $user->id,
            'name'          => $user->name,
            'nip'           => 'AUTO-' . rand(1000, 9999),
            'telphone'      => '-',
            'agama'         => 'Islam',
            'jenis_kelamin' => 'Laki-laki',
            'tgl_lahir'     => now(),
            'pekerjaan'     => '-',
            'alamat'        => '-',
            'rt'            => '00',
            'rw'            => '00',
            'status_anggota'=> 1,
            'saldo'         => 0,
            'tgl_gabung'    => now(),
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ]);

        return $user;
    }
}
