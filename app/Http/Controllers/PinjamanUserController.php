<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PinjamanUserController extends Controller
{
    public function index()
    {
        // Landing page untuk pinjaman dengan pilihan menu
        return view('anggota.anggota_pinjaman.index');
    }

    public function main(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');

        // Get current user's member ID
        $userId = Auth::id();
        $anggota = DB::table('_anggota')->where('user_id', $userId)->first();

        if (!$anggota) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Query pinjaman untuk anggota yang login
        $pinjamanQuery = DB::table('pinjaman')
            ->select(
                'pinjaman.id as pinjaman_id',
                'pinjaman.kodeTransaksiPinjaman',
                'pinjaman.tanggal_pinjam',
                'pinjaman.jatuh_tempo',
                'pinjaman.jml_pinjam',
                'pinjaman.jml_cicilan',
                'pinjaman.bunga_pinjam',
                'pinjaman.status_pengajuan',
                'pinjaman.keterangan_ditolak_pengajuan',
                'users.name as created_by_name'
            )
            ->join('users', 'users.id', '=', 'pinjaman.created_by')
            ->where('pinjaman.id_anggota', $anggota->id)
            ->orderBy('pinjaman.id', 'DESC');

        // Filter by date range
        if ($startDate && $endDate) {
            $pinjamanQuery->whereBetween('pinjaman.tanggal_pinjam', [$startDate, $endDate]);
        }

        // Filter by search
        if ($search) {
            $pinjamanQuery->where('pinjaman.kodeTransaksiPinjaman', 'like', "%{$search}%");
        }

        $pinjaman = $pinjamanQuery->paginate(5);

        return view('anggota.anggota_pinjaman.main', compact('pinjaman', 'startDate', 'endDate', 'search'));
    }

    public function create()
    {
        // Check if user has pending loan application
        $userId = Auth::id();
        $anggota = DB::table('_anggota')->where('user_id', $userId)->first();

        if (!$anggota) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Check for pending applications (status != 3 means not completed)
        $pendingPengajuan = DB::table('pinjaman')
            ->where('id_anggota', $anggota->id)
            ->where('status_pengajuan', '<>', 3)
            ->exists();

        if ($pendingPengajuan) {
            return redirect()->route('anggota.pinjaman.main')
                ->with('error', 'Anda tidak dapat membuat pinjaman baru karena ada pinjaman yang belum selesai.');
        }

        // Calculate maximum loan amount
        $totalSaldo = DB::table('_anggota')->sum('saldo');
        $maxPinjaman = $totalSaldo * 0.9;
        $totalPinjamanSebelumnya = DB::table('pinjaman')->sum('jml_pinjam');
        $maxPinjamanBaru = $maxPinjaman - $totalPinjamanSebelumnya;

        // Generate transaction code
        $kodeTransaksiPinjaman = $this->generateKodeTransaksiPinjaman();

        return view('anggota.anggota_pinjaman.create', compact(
            'maxPinjamanBaru',
            'kodeTransaksiPinjaman',
            'anggota'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'jml_pinjam' => 'required|numeric|min:1',
            'jml_cicilan' => 'required|numeric|min:1',
            'bunga_pinjam' => 'required|numeric|min:0|max:100',
        ], [
            'tanggal_pinjam.required' => 'Tanggal Pinjam harus diisi.',
            'tanggal_pinjam.date' => 'Tanggal Pinjam harus berupa tanggal yang valid.',
            'jml_pinjam.required' => 'Jumlah Pinjam harus diisi.',
            'jml_pinjam.numeric' => 'Jumlah Pinjam harus berupa angka.',
            'jml_pinjam.min' => 'Jumlah Pinjam harus lebih dari 0.',
            'jml_cicilan.required' => 'Jumlah Cicilan harus diisi.',
            'jml_cicilan.numeric' => 'Jumlah Cicilan harus berupa angka.',
            'jml_cicilan.min' => 'Jumlah Cicilan harus lebih dari 0.',
            'bunga_pinjam.required' => 'Bunga Pinjam harus diisi.',
            'bunga_pinjam.numeric' => 'Bunga Pinjam harus berupa angka.',
            'bunga_pinjam.min' => 'Bunga Pinjam harus lebih besar atau sama dengan 0.',
            'bunga_pinjam.max' => 'Bunga Pinjam harus lebih kecil atau sama dengan 100.',
        ]);

        $userId = Auth::id();
        $anggota = DB::table('_anggota')->where('user_id', $userId)->first();

        if (!$anggota) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Check for pending applications again
        $pendingPengajuan = DB::table('pinjaman')
            ->where('id_anggota', $anggota->id)
            ->where('status_pengajuan', '<>', 3)
            ->exists();

        if ($pendingPengajuan) {
            return redirect()->route('anggota.pinjaman.main')
                ->with('error', 'Anda tidak dapat membuat pinjaman baru karena ada pinjaman yang belum selesai.');
        }

        // Calculate maximum loan validation
        $totalSaldo = DB::table('_anggota')->sum('saldo');
        $maxPinjaman = $totalSaldo * 0.9;
        $totalPinjamanSebelumnya = DB::table('pinjaman')->sum('jml_pinjam');
        $maxPinjamanBaru = $maxPinjaman - $totalPinjamanSebelumnya;

        if ($request->jml_pinjam > $maxPinjamanBaru) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah pinjaman melebihi batas maksimum yang tersedia: Rp ' . number_format($maxPinjamanBaru, 0, ',', '.'));
        }

        // Generate transaction code
        $lastTransaction = DB::table('pinjaman')->orderBy('id', 'desc')->first();
        $newTransactionNumber = $lastTransaction ? (int) substr($lastTransaction->kodeTransaksiPinjaman, 4) + 1 : 1;
        $kodeTransaksiPinjaman = 'PNJ-' . str_pad($newTransactionNumber, 4, '0', STR_PAD_LEFT);

        // Calculate due date
        $tanggalPinjam = new \DateTime($request->tanggal_pinjam);
        $jatuhTempo = $tanggalPinjam->add(new \DateInterval('P' . $request->jml_cicilan . 'M'))->format('Y-m-d');

        // Insert loan application
        DB::table('pinjaman')->insert([
            'kodeTransaksiPinjaman' => $kodeTransaksiPinjaman,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo' => $jatuhTempo,
            'jml_pinjam' => $request->jml_pinjam,
            'bunga_pinjam' => $request->bunga_pinjam,
            'jml_cicilan' => $request->jml_cicilan,
            'status_pengajuan' => 0, // 0 = Pending, 1 = Approved, 2 = Rejected, 3 = Completed
            'keterangan_ditolak_pengajuan' => '',
            'created_by' => $userId,
            'updated_by' => $userId,
            'id_anggota' => $anggota->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('anggota.pinjaman.main')
            ->with('success', 'Pengajuan pinjaman berhasil disubmit dan menunggu persetujuan admin.');
    }

    public function show($pinjaman_id)
    {
        $userId = Auth::id();
        $anggota = DB::table('_anggota')->where('user_id', $userId)->first();

        if (!$anggota) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Get loan details for current user only
        $pinjaman = DB::table('pinjaman')
            ->select(
                'pinjaman.id as pinjaman_id',
                'pinjaman.kodeTransaksiPinjaman',
                'pinjaman.tanggal_pinjam',
                'pinjaman.jatuh_tempo',
                'pinjaman.jml_pinjam',
                'pinjaman.jml_cicilan',
                'pinjaman.bunga_pinjam',
                'pinjaman.status_pengajuan',
                'pinjaman.keterangan_ditolak_pengajuan',
                'users.name as created_by_name',
                '_anggota.name as anggota_name'
            )
            ->join('users', 'users.id', '=', 'pinjaman.created_by')
            ->join('_anggota', '_anggota.id', '=', 'pinjaman.id_anggota')
            ->where('pinjaman.id', $pinjaman_id)
            ->where('pinjaman.id_anggota', $anggota->id) // Ensure user can only see their own loan
            ->first();

        if (!$pinjaman) {
            return redirect()->route('anggota.pinjaman.main')->with('error', 'Pinjaman tidak ditemukan.');
        }

        // Calculate total loan with interest
        $bunga_persen = $pinjaman->bunga_pinjam;
        $bunga_total = ($pinjaman->jml_pinjam * $bunga_persen) / 100;
        $total_pinjaman_dengan_bunga = $pinjaman->jml_pinjam + $bunga_total;
        $pinjaman->total_pinjaman_dengan_bunga = $total_pinjaman_dengan_bunga;

        // Get installments (angsuran) if loan is approved
        $angsuran = [];
        $total_angsuran = 0;

        if ($pinjaman->status_pengajuan == 1) { // Only if approved
            $angsuran = DB::table('angsuran')
                ->select(
                    'angsuran.id as angsuran_id',
                    'angsuran.kodeTransaksiAngsuran',
                    'angsuran.tanggal_angsuran',
                    'angsuran.jml_angsuran',
                    'angsuran.sisa_pinjam as sisa_angsuran',
                    'angsuran.cicilan',
                    'angsuran.status',
                    'angsuran.denda',
                    'angsuran.keterangan',
                    'angsuran.bukti_pembayaran',
                    'angsuran.bunga_pinjaman',
                    DB::raw('(angsuran.jml_angsuran + angsuran.bunga_pinjaman + COALESCE(angsuran.denda, 0)) as total_angsuran_dengan_bunga'),
                    'users.name as created_by_name'
                )
                ->join('users', 'users.id', '=', 'angsuran.created_by')
                ->where('angsuran.id_pinjaman', $pinjaman_id)
                ->orderBy('angsuran.tanggal_angsuran', 'asc')
                ->paginate(5);

            $total_angsuran = DB::table('angsuran')
                ->where('angsuran.id_pinjaman', $pinjaman_id)
                ->sum(DB::raw('angsuran.jml_angsuran + angsuran.bunga_pinjaman + COALESCE(angsuran.denda, 0)'));
        }

        return view('anggota.anggota_pinjaman.show', [
            'pinjaman' => $pinjaman,
            'angsuran' => $angsuran,
            'total_angsuran' => $total_angsuran,
        ]);
    }

    private function generateKodeTransaksiPinjaman()
    {
        $lastTransaction = DB::table('pinjaman')->orderBy('id', 'desc')->first();
        $lastId = $lastTransaction ? $lastTransaction->id + 1 : 1;

        return 'PNJ-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    }
}
