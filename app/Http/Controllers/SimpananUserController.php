<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimpananRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SimpananUserController extends Controller
{
    // Constants untuk jenis simpanan (sama dengan SimpananController
    const JENIS_SIMPANAN_POKOK = 1;
    const JENIS_SIMPANAN_WAJIB = 4;
    const JENIS_SIMPANAN_SUKARELA = 5;
    const JENIS_SIMPANAN_INSIDENTAL = 6;

    // Constants untuk nominal tetap
    const NOMINAL_SIMPANAN_POKOK = 250000;
    const NOMINAL_SIMPANAN_WAJIB = 20000;

    public function index()
    {
        return view('anggota.anggota_simpanan.index');
    }

    public function create()
    {
        $jenisSimpanan = DB::table('jenis_simpanan')->select('id', 'nama')->orderBy('nama')->get();
        $kodeTransaksiSimpanan = $this->generateTransactionCode();

        return view('anggota.anggota_simpanan.create', compact(
            'kodeTransaksiSimpanan',
            'jenisSimpanan'
        ));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_simpanan' => 'required|date',
            'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id',
            'jml_simpanan' => 'nullable|numeric|min:0',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Ambil ID anggota yang login
            $anggotaId = Auth::user()->anggota->id; // Asumsi user memiliki relasi ke anggota

            // Validasi jenis simpanan
            $jenisSimpanan = $this->getJenisSimpanan($request->id_jenis_simpanan);
            if (!$jenisSimpanan) {
                return redirect()->back()
                    ->withErrors(['id_jenis_simpanan' => 'Jenis simpanan tidak valid.'])
                    ->withInput();
            }

            // Validasi dan hitung jumlah simpanan
            $jmlSimpanan = $this->calculateSimpananAmount($request, $jenisSimpanan, $anggotaId);
            if (is_array($jmlSimpanan)) {
                return redirect()->back()
                    ->withErrors($jmlSimpanan)
                    ->withInput();
            }

            // Upload bukti pembayaran
            $imagePath = $this->handleImageUpload($request);

            // Simpan data simpanan
            $simpananId = DB::table('simpanan')->insertGetId([
                'kodeTransaksiSimpanan' => $request->kodeTransaksiSimpanan,
                'tanggal_simpanan' => $request->tanggal_simpanan,
                'id_anggota' => $anggotaId,
                'id_jenis_simpanan' => $request->id_jenis_simpanan,
                'jml_simpanan' => $jmlSimpanan,
                'bukti_pembayaran' => $imagePath,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update saldo anggota
            $this->updateMemberBalance($anggotaId);

            DB::commit();

            return redirect()->route('anggota.simpanan.main')
                ->with('message', 'Pengajuan simpanan berhasil dikirim dan sedang menunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error saving simpanan from user: ' . $e->getMessage());

            return redirect()->route('anggota.simpanan.create')
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function main(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');

        // Ambil ID anggota yang login
        $anggotaId = Auth::user()->anggota->id;

        $query = DB::table('simpanan')
            ->select([
                'simpanan.id as simpanan_id',
                'simpanan.kodeTransaksiSimpanan',
                'simpanan.tanggal_simpanan',
                'simpanan.jml_simpanan',
                'jenis_simpanan.nama as jenis_simpanan_nama',
                'users.name as created_by_name'
            ])
            ->join('users', 'users.id', '=', 'simpanan.created_by')
            ->join('jenis_simpanan', 'jenis_simpanan.id', '=', 'simpanan.id_jenis_simpanan')
            ->where('simpanan.id_anggota', $anggotaId);

        // Filter berdasarkan tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('simpanan.tanggal_simpanan', [$startDate, $endDate]);
        }

        // Filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('simpanan.kodeTransaksiSimpanan', 'LIKE', "%{$search}%")
                  ->orWhere('jenis_simpanan.nama', 'LIKE', "%{$search}%");
            });
        }

        $simpanan = $query->orderBy('simpanan.id', 'DESC')->paginate(10);

        return view('anggota.anggota_simpanan.main', compact(
            'simpanan',
            'startDate',
            'endDate',
            'search'
        ));
    }

    public function show($id)
    {
        // Perbaikan: Konsisten dengan method main()
        $anggotaId = Auth::user()->anggota->id; // Bukan anggota_id

        $detailSimpanan = DB::table('simpanan')
            ->select([
                'simpanan.jml_simpanan as jmlh',
                'simpanan.kodeTransaksiSimpanan as kode',
                'simpanan.tanggal_simpanan as tgl',
                'simpanan.bukti_pembayaran as bukti',
                'users_created.name as created_by',
                'users_updated.name as updated_by',
                '_anggota.name as anggota_name',
                '_anggota.nip as anggota_nip',
                '_anggota.image as anggota_image',
                '_anggota.telphone as anggota_telphone',
                '_anggota.alamat as anggota_alamat',
                '_anggota.pekerjaan as anggota_pekerjaan',
                '_anggota.agama as anggota_agama',
                'jenis_simpanan.nama as jenis_simpanan_nama'
            ])
            ->join('_anggota', '_anggota.id', '=', 'simpanan.id_anggota')
            ->join('jenis_simpanan', 'jenis_simpanan.id', '=', 'simpanan.id_jenis_simpanan')
            ->join('users as users_created', 'users_created.id', '=', 'simpanan.created_by')
            ->leftJoin('users as users_updated', 'users_updated.id', '=', 'simpanan.updated_by')
            ->where('simpanan.id', $id)
            ->where('simpanan.id_anggota', $anggotaId) // Pastikan hanya bisa melihat simpanan sendiri
            ->first();

        if (!$detailSimpanan) {
            return redirect()->route('anggota.simpanan.main')
                ->with('error', 'Data simpanan tidak ditemukan.');
        }

        return view('anggota.anggota_simpanan.show', compact('detailSimpanan'));
    }

    /**
     * Generate kode transaksi baru
     */
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

    /**
     * Ambil data jenis simpanan
     */
    private function getJenisSimpanan($id)
    {
        return DB::table('jenis_simpanan')->where('id', $id)->first();
    }

    /**
     * Hitung jumlah simpanan berdasarkan jenis
     */
    private function calculateSimpananAmount($request, $jenisSimpanan, $anggotaId)
    {
        switch ($jenisSimpanan->id) {
            case self::JENIS_SIMPANAN_POKOK:
                // Cek apakah anggota sudah memiliki simpanan pokok
                $existingSimpananPokok = DB::table('simpanan')
                    ->where('id_anggota', $anggotaId)
                    ->where('id_jenis_simpanan', self::JENIS_SIMPANAN_POKOK)
                    ->exists();

                if ($existingSimpananPokok) {
                    return ['id_jenis_simpanan' => 'Anda sudah memiliki simpanan pokok.'];
                }

                return self::NOMINAL_SIMPANAN_POKOK;

            case self::JENIS_SIMPANAN_WAJIB:
                return self::NOMINAL_SIMPANAN_WAJIB;

            case self::JENIS_SIMPANAN_SUKARELA:
            case self::JENIS_SIMPANAN_INSIDENTAL:
                if ($request->jml_simpanan <= 0) {
                    $jenis = $jenisSimpanan->id == self::JENIS_SIMPANAN_SUKARELA ? 'sukarela' : 'insidental';
                    return ['jml_simpanan' => "Jumlah simpanan {$jenis} harus lebih dari 0."];
                }
                return $request->jml_simpanan;

            default:
                return $request->jml_simpanan;
        }
    }

    /**
     * Handle upload gambar bukti pembayaran
     */
    private function handleImageUpload($request)
    {
        if (!$request->hasFile('bukti_pembayaran')) {
            return null;
        }

        $image = $request->file('bukti_pembayaran');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/img'), $imageName);

        return 'assets/img/' . $imageName;
    }

    /**
     * Update saldo anggota dan status
     */
    private function updateMemberBalance($anggotaId)
    {
        // Hitung total simpanan anggota
        $totalSimpanan = DB::table('simpanan')
            ->where('id_anggota', $anggotaId)
            ->sum('jml_simpanan');

        // Update saldo anggota
        DB::table('_anggota')
            ->where('id', $anggotaId)
            ->update([
                'saldo' => $totalSimpanan,
                'status_anggota' => $totalSimpanan > 0 ? 1 : 0,
                'updated_at' => now()
            ]);

        // Update total saldo keseluruhan
        $grandTotalSaldo = DB::table('simpanan')->sum('jml_simpanan');
        DB::table('total_saldo_anggota')->updateOrInsert(
            [],
            [
                'gradesaldo' => $grandTotalSaldo,
                'updated_at' => now()
            ]
        );
    }
}
