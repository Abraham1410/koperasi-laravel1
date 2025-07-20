<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpananUserController extends Controller
{
    public function index()
    {
        return view('anggota.anggota_simpanan.index');
    }

    public function main(Request $request)
    {
        $userId = Auth::user()->id;

        $simpanan = DB::table('simpanan')
            ->where('anggota_id', $userId)
            ->orderByDesc('tanggal')
            ->get();

        return view('anggota.anggota_simpanan.main', compact('simpanan'));
    }

    public function show($id)
    {
        $detail = DB::table('simpanan')
            ->select([
                'simpanan.kodeTransaksiSimpanan as kode',
                'simpanan.tanggal_simpanan as tanggal',
                'jenis_simpanan.nama as jenis',
                'simpanan.jml_simpanan as jumlah',
                'users_created.name as created_by',
                'users_updated.name as updated_by',
                'simpanan.bukti_pembayaran as bukti'
            ])
            ->join('jenis_simpanan', 'jenis_simpanan.id', '=', 'simpanan.id_jenis_simpanan')
            ->join('users as users_created', 'users_created.id', '=', 'simpanan.created_by')
            ->leftJoin('users as users_updated', 'users_updated.id', '=', 'simpanan.updated_by')
            ->where('simpanan.id', $id)
            ->first();

        if (!$detail) {
            return redirect()->route('anggota.anggota_simpanan.main')->with('error', 'Data tidak ditemukan');
        }

        return view('anggota.anggota_simpanan.show', compact('detail'));
    }

    public function create()
    {
        $userId = Auth::id();

        $kodeTransaksi = $this->generateTransactionCode();

        $anggota = DB::table('anggota')->where('user_id', $userId)->first();
        $jenisSimpananList = DB::table('jenis_simpanan')->get(); // or use a model

        // dd($userId, $anggota);
        return view('anggota.anggota_simpanan.create', [
            'kodeTransaksiSimpanan' => 'SMP-xxxx', // generated
            'anggota' => $anggota, // from DB
            'jenisSimpananList' => $jenisSimpananList,
        ]);
    }

    private function generateTransactionCode()
    {
        $lastTransaction = DB::table('simpanan')
            ->where('kodeTransaksiSimpanan', 'LIKE', 'SMP-%')
            ->orderBy('kodeTransaksiSimpanan', 'desc')
            ->first();

        $newTransactionNumber = $lastTransaction ?
            (int) substr($lastTransaction->kodeTransaksiSimpanan, 4) + 1 : 1;

        return 'SMP-' . str_pad($newTransactionNumber, 4, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kodeTransaksiSimpanan' => 'required',
            'tanggal_simpanan' => 'required|date',
            'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id',
            'jml_simpanan' => 'nullable|numeric|min:0',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $userId = Auth::id();

        try {
            DB::beginTransaction();

            $anggota = DB::table('_anggota')->where('user_id', $userId)->first();
            if (!$anggota) {
                return redirect()->back()->withErrors(['anggota' => 'Data anggota tidak ditemukan']);
            }

            $imagePath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $image = $request->file('bukti_pembayaran');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/img'), $imageName);
                $imagePath = 'assets/img/' . $imageName;
            }

            DB::table('simpanan')->insert([
                'kodeTransaksiSimpanan' => $request->kodeTransaksiSimpanan,
                'tanggal_simpanan' => $request->tanggal_simpanan,
                'id_anggota' => $anggota->id,
                'id_jenis_simpanan' => $request->id_jenis_simpanan,
                'jml_simpanan' => $request->jml_simpanan ?? 0,
                'bukti_pembayaran' => $imagePath,
                'created_by' => $userId,
                'updated_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('anggota.anggota_simpanan.main')->with('message', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // public function main()
    // {
    //     return view('anggota.anggota_simpanan.main');
    // }

    // public function show()
    // {
    //     return view('anggota.anggota_simpanan.show');
    // }
}
