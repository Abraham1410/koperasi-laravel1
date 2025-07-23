<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PenarikanUserController extends Controller
{
    public function index()
    {
        return view('anggota.anggota_penarikan.index'); // Halaman utama penarikan
    }

    public function create()
    {
        // Ambil data anggota yang sedang login
        $anggota = DB::table('_anggota')->where('id', Auth::id())->first();

        // Cek apakah anggota memiliki pinjaman yang belum selesai
        $pinjaman = DB::table('pinjaman')
            ->where('id_anggota', Auth::id())
            ->where('status_pengajuan', '!=', 3)
            ->first();

        return view('anggota.anggota_penarikan.create', compact('anggota', 'pinjaman'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_penarikan' => 'required|date',
            'jumlah_penarikan' => 'required|numeric|min:1000', // Minimal penarikan 1000
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jumlah_penarikan.min' => 'Jumlah penarikan minimal Rp 1.000',
        ]);

        // Ambil data anggota yang sedang login
        $anggota = DB::table('_anggota')->where('id', Auth::id())->first();

        if (!$anggota) {
            Session::flash('error', 'Data anggota tidak ditemukan.');
            return redirect()->route('anggota.penarikan.create');
        }

        // Periksa apakah saldo mencukupi
        if ($anggota->saldo < $request->jumlah_penarikan) {
            Session::flash('error', 'Saldo tidak mencukupi untuk penarikan ini.');
            return redirect()->route('anggota.penarikan.create');
        }

        // Periksa status pinjaman anggota
        $pinjaman = DB::table('pinjaman')
            ->where('id_anggota', Auth::id())
            ->where('status_pengajuan', '!=', 3)
            ->first();

        if ($pinjaman) {
            Session::flash('error', 'Saldo tidak bisa ditarik karena Anda belum menyelesaikan pinjaman.');
            return redirect()->route('anggota.penarikan.create');
        }

        // Generate kode transaksi penarikan
        $kodeTransaksiPenarikan = $this->generateKodeTransaksiPenarikan();

        // Simpan data penarikan
        DB::table('penarikan')->insert([
            'id_anggota' => Auth::id(),
            'tanggal_penarikan' => $request->tanggal_penarikan,
            'jumlah_penarikan' => $request->jumlah_penarikan,
            'keterangan' => $request->keterangan,
            'kodeTransaksipenarikan' => $kodeTransaksiPenarikan,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update saldo anggota
        DB::table('_anggota')
            ->where('id', Auth::id())
            ->decrement('saldo', $request->jumlah_penarikan);

        // Periksa saldo anggota setelah penarikan
        $anggotaUpdated = DB::table('_anggota')->where('id', Auth::id())->first();
        if ($anggotaUpdated->saldo <= 0) {
            DB::table('_anggota')
                ->where('id', Auth::id())
                ->update(['status_anggota' => 0]);
        }

        Session::flash('success', 'Penarikan berhasil diajukan dengan kode transaksi: ' . $kodeTransaksiPenarikan);
        return redirect()->route('anggota.penarikan.main');
    }

    public function main(Request $request)
    {
        // Mengambil data penarikan untuk anggota yang sedang login
        $penarikan = DB::table('penarikan')
            ->select('penarikan.id as penarikan_id', 'penarikan.*', '_anggota.*')
            ->leftJoin('_anggota', '_anggota.id', '=', 'penarikan.id_anggota')
            ->where('penarikan.id_anggota', Auth::id());

        // Filter berdasarkan tanggal penarikan jika tersedia
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            if ($startDate && $endDate) {
                $penarikan = $penarikan->whereBetween('tanggal_penarikan', [$startDate, $endDate]);
            }
        }

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->get('search');
            $penarikan = $penarikan->where(function ($query) use ($search) {
                $query->where('kodeTransaksipenarikan', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // Paginate hasil query
        $penarikan = $penarikan->orderBy('penarikan.created_at', 'desc')->paginate(10);

        // Ambil total penarikan user
        $totalPenarikan = DB::table('penarikan')
            ->where('id_anggota', Auth::id())
            ->sum('jumlah_penarikan');

        return view('anggota.anggota_penarikan.main', compact('penarikan', 'totalPenarikan'));
    }

    public function show($id)
    {
        // Ambil detail penarikan berdasarkan ID dan pastikan milik user yang sedang login
        $penarikan = DB::table('penarikan')
            ->select('penarikan.*', '_anggota.name', '_anggota.saldo')
            ->leftJoin('_anggota', '_anggota.id', '=', 'penarikan.id_anggota')
            ->where('penarikan.id', $id)
            ->where('penarikan.id_anggota', Auth::id())
            ->first();

        if (!$penarikan) {
            Session::flash('error', 'Data penarikan tidak ditemukan.');
            return redirect()->route('anggota.penarikan.main');
        }

        return view('anggota.anggota_penarikan.show', compact('penarikan'));
    }

    private function generateKodeTransaksiPenarikan()
    {
        $lastTransaction = DB::table('penarikan')->orderBy('id', 'desc')->first();
        $lastId = $lastTransaction ? $lastTransaction->id + 1 : 1;

        return 'PNR-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    }

    // Method untuk mendapatkan saldo anggota (untuk AJAX)
    public function getSaldo()
    {
        $anggota = DB::table('_anggota')->where('id', Auth::id())->first();

        return response()->json([
            'saldo' => $anggota ? $anggota->saldo : 0
        ]);
    }
}
