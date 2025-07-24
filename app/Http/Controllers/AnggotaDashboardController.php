<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnggotaDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:anggota']);
    }

    /**
     * Show the application dashboard for anggota.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Get the related anggota_id (if needed)
        $anggota = DB::table('_anggota')->where('user_id', $user->id)->first();

        // Prevent null error
        if (!$anggota) {
            return view('anggota.dashboard')->with('totalSaldo', 0);
        }

        // Sum deposits (setoran)
        $totalSetoran = DB::table('simpanan')
            ->where('id_anggota', $anggota->id)
            ->sum('jml_simpanan');

        // Sum withdrawals (penarikan)
        $totalPenarikan = DB::table('penarikan')
            ->where('id_anggota', $anggota->id)
            ->sum('jumlah_penarikan');

        $totalSaldo = $totalSetoran - $totalPenarikan;

        return view('anggota.dashboard', compact('totalSaldo'));
    }
}
