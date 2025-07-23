<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;

class ProfileController extends Controller
{
    public function edit()
    {
        $anggota = Auth::user()->anggota;

        return view('anggota.profile.edit', compact('anggota'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nip' => 'nullable|string|max:50',
            'telphone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:100',
        ]);

        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            $anggota = new Anggota();
            $anggota->user_id = Auth::id();
        }

        $anggota->nip = $request->nip;
        $anggota->telphone = $request->telphone;
        $anggota->alamat = $request->alamat;
        $anggota->pekerjaan = $request->pekerjaan;

        $anggota->save();

        return redirect()->back()->with('message', 'Profil berhasil diperbarui.');
    }
}
