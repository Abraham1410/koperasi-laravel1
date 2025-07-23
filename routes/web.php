<?php

use App\Http\Controllers\NasabahController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SaldoAwalController;
use App\Http\Controllers\SimpananUserController;
use App\Http\Controllers\PinjamanUserController;
use App\Http\Controllers\PenarikanUserController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AnggotaDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {
    // Tampilkan form registrasi
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

    // Proses form registrasi
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    // ========== ROUTES UNTUK SEMUA USER (ADMIN & ANGGOTA) ==========


    // Home - accessible by all authenticated users
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/chart-data', [App\Http\Controllers\HomeController::class, 'chartData'])->name('chart.data');

    // ========== SIMPANAN - ADMIN & ANGGOTA ==========
    Route::get('/simpanan', [\App\Http\Controllers\SimpananController::class, 'index'])->name('simpanan');
    Route::get('/simpanan/create', [\App\Http\Controllers\SimpananController::class, 'create'])->name('simpanan.create');
    Route::post('/simpanan/store', [\App\Http\Controllers\SimpananController::class, 'store'])->name('simpanan.store');
    Route::get('/detail_simpanan/{id}', [\App\Http\Controllers\SimpananController::class, 'show'])->name('simpanan.show');

    // Edit & Delete simpanan hanya untuk admin atau pemilik simpanan
    Route::get('/editsimpanan/{id}/edit', [\App\Http\Controllers\SimpananController::class, 'edit'])->name('simpanan.edit');
    Route::put('/updatesimpanan/{id}', [\App\Http\Controllers\SimpananController::class, 'update'])->name('simpanan.update');
    Route::delete('/simpanan/{id}', [\App\Http\Controllers\SimpananController::class, 'destroy'])->name('simpanan.destroy');

    // ========== PINJAMAN - ADMIN & ANGGOTA ==========
    Route::get('/pinjaman', [\App\Http\Controllers\PinjamanController::class, 'index'])->name('pinjaman');
    Route::get('/pinjaman/create', [\App\Http\Controllers\PinjamanController::class, 'create'])->name('pinjaman.create');
    Route::post('/pinjaman/store', [\App\Http\Controllers\PinjamanController::class, 'store'])->name('pinjaman.store');
    Route::get('/detail_pinjaman/{id}', [\App\Http\Controllers\PinjamanController::class, 'show'])->name('pinjaman.show');
    Route::put('/pinjaman/{id}', [\App\Http\Controllers\PinjamanController::class, 'update'])->name('pinjaman.update');
    Route::get('angsuran/{id}', [\App\Http\Controllers\PinjamanController::class, 'showAngsuran'])->name('angsuran.show');

    // ========== PENARIKAN - ADMIN & ANGGOTA ==========
    Route::get('/penarikan', [\App\Http\Controllers\PenarikanController::class, 'index'])->name('penarikan');
    Route::post('/penarikan/store', [\App\Http\Controllers\PenarikanController::class, 'store'])->name('penarikan.store');
    Route::get('/detail_penarikan/{id}', [\App\Http\Controllers\PenarikanController::class, 'show'])->name('penarikan.show');
    Route::get('/editPenarikan/{id}/edit', [\App\Http\Controllers\PenarikanController::class, 'edit'])->name('penarikan.edit');
    Route::put('/penarikan/{id}', [\App\Http\Controllers\PenarikanController::class, 'update'])->name('penarikan.update');

    // ========== ANGSURAN - ADMIN & ANGGOTA ==========
    Route::get('/angsuran', [\App\Http\Controllers\AngsuranController::class, 'index'])->name('angsuran');
    Route::post('/pinjaman/{pinjaman_id}/angsuran', [\App\Http\Controllers\AngsuranController::class, 'bayarAngsuran'])->name('angsuran.bayar');
    Route::put('/angsuran/{id}', [\App\Http\Controllers\AngsuranController::class, 'update'])->name('angsuran.update');

    // ========== ROUTES KHUSUS ADMIN ONLY ==========
    // UBAH DARI role:admin MENJADI role:Admin (huruf besar A)
    Route::middleware(['role:Admin'])->group(function () {

        // Jurnal Umum - ADMIN ONLY
        Route::get('/laporan/jurnal-umum', [LaporanController::class, 'jurnalUmum'])->name('laporan.jurnal_umum');
        Route::get('/jurnal/create', [App\Http\Controllers\JurnalUmumController::class, 'create'])->name('jurnal.create');
        Route::post('/jurnal/store', [App\Http\Controllers\JurnalUmumController::class, 'store'])->name('jurnal.store');
        Route::get('/laporan/jurnal/export-pdf', [App\Http\Controllers\JurnalUmumController::class, 'exportPdf'])->name('laporan.jurnal_umum.export_pdf');

        // Buku Besar - ADMIN ONLY
        Route::get('/laporan/buku-besar', [LaporanController::class, 'bukuBesar'])->name('laporan.buku_besar');
        Route::get('/laporan/buku-besar/pdf', [LaporanController::class, 'cetakBukuBesarPDF'])->name('laporan.buku-besar.pdf');
        Route::get('/laporan/buku-besar-group', [LaporanController::class, 'bukuBesar'])->name('laporan.buku_besar.group');

        // Neraca Saldo - ADMIN ONLY
        Route::get('/laporan/neraca-saldo', [LaporanController::class, 'neracaSaldo'])->name('laporan.neraca_saldo');
        Route::get('/laporan/neraca-saldo/pdf', [LaporanController::class, 'cetakNeracaSaldoPdf'])->name('laporan.neraca_saldo.pdf');

        // LPHU - ADMIN ONLY
        Route::get('/laporan/lphu', [LaporanController::class, 'lphu'])->name('laporan.lphu');
        Route::get('/laporan/lphu/pdf', [LaporanController::class, 'cetakLphuPdf'])->name('laporan.lphu.pdf');

        // Neraca - ADMIN ONLY
        Route::get('/laporan/neraca', [LaporanController::class, 'neraca'])->name('laporan.neraca');
        Route::get('/laporan/neraca/pdf', [LaporanController::class, 'cetakNeracaPdf'])->name('laporan.neraca.pdf');

        // Arus Kas - ADMIN ONLY
        Route::get('/laporan/arus-kas', [LaporanController::class, 'arusKas'])->name('laporan.arus_kas');
        Route::get('/laporan/arus-kas/pdf', [LaporanController::class, 'arusKasPdf'])->name('laporan.arus-kas.pdf');

        // Akun Management - ADMIN ONLY
        Route::resource('akun', AkunController::class);

        // User Management - ADMIN ONLY
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('user');
        Route::get('/adduser', [\App\Http\Controllers\UserController::class, 'create'])->name('createUser');
        Route::post('/adduser', [\App\Http\Controllers\UserController::class, 'store'])->name('storeUser');
        Route::get('/editusers/{id}',  [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/updateusers/{id}',  [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::get('delete-user/{id}', [UserController::class, 'delete']);

        // Nasabah Management - ADMIN ONLY
        Route::get('/nasabah', [\App\Http\Controllers\NasabahController::class, 'index'])->name('nasabah');
        Route::get('/addnasabah', [\App\Http\Controllers\NasabahController::class, 'create'])->name('createNasabah');
        Route::post('/addnasabah', [\App\Http\Controllers\NasabahController::class, 'store'])->name('storeNasabah');
        Route::get('/editnasabah/{id}',  [\App\Http\Controllers\NasabahController::class, 'edit'])->name('nasabah.edit');
        Route::put('/updatenasabah/{id}',  [\App\Http\Controllers\NasabahController::class, 'update'])->name('nasabah.update');
        Route::delete('/nasabah/{id}', [\App\Http\Controllers\NasabahController::class, 'destroy'])->name('nasabah.destroy');
        Route::get('/detail_nasabah/{id}', [\App\Http\Controllers\NasabahController::class, 'show'])->name('nasabah.show');

        // Approve/Reject Pinjaman - ADMIN ONLY
        Route::get('/terima_pengajuan/{id}', [\App\Http\Controllers\PinjamanController::class, 'terimapengajuan'])->name('terima_pengajuan');
        Route::post('/tolak_pengajuan/{id}', [\App\Http\Controllers\PinjamanController::class, 'tolakPengajuan'])->name('tolak_pengajuan');

        // Delete actions - ADMIN ONLY
        Route::delete('/pinjaman/{id}', [\App\Http\Controllers\PinjamanController::class, 'destroy'])->name('pinjaman.destroy');
        Route::delete('/penarikan/{id}', [\App\Http\Controllers\PenarikanController::class, 'destroy'])->name('penarikan.destroy');
        Route::delete('/angsuran/{id}', [\App\Http\Controllers\AngsuranController::class, 'destroy'])->name('angsuran.destroy');

        // Laporan & Cetak - ADMIN ONLY
        Route::get('/simpanan/cetak', [\App\Http\Controllers\SimpananController::class, 'cetak'])->name('simpanan.cetak');
        Route::get('/pinjaman/cetak', [\App\Http\Controllers\LaporanController::class, 'laporanPinjaman'])->name('pinjaman.cetak');
        Route::get('/laporan-angsuran/{id}', [\App\Http\Controllers\LaporanController::class, 'laporanAngsuran'])->name('laporan.angsuran');
        Route::get('/penarikan/cetak', [\App\Http\Controllers\LaporanController::class, 'laporanPenarikan'])->name('penarikan.cetak');
        Route::get('/angsuran/cetak', [\App\Http\Controllers\AngsuranController::class, 'cetak'])->name('angsuran.cetak');

        // Angsuran Management - ADMIN ONLY
        Route::get('/angsuran/create', [\App\Http\Controllers\AngsuranController::class, 'create'])->name('angsuran.create');
        Route::post('/angsuran/store', [\App\Http\Controllers\AngsuranController::class, 'store'])->name('angsuran.store');
        Route::get('/editangsuran/{id}/edit', [\App\Http\Controllers\AngsuranController::class, 'edit'])->name('angsuran.edit');

        // Saldo Awal - ADMIN ONLY
        Route::get('/saldo-awal', [SaldoAwalController::class, 'index'])->name('saldo-awal.index');
        Route::get('/saldo-awal/create', [SaldoAwalController::class, 'create'])->name('saldo-awal.create');
        Route::post('/saldo-awal/store', [SaldoAwalController::class, 'store'])->name('saldo-awal.store');
        Route::get('/saldo-awal/edit/{id}', [SaldoAwalController::class, 'edit'])->name('saldo-awal.edit');
        Route::put('/saldo-awal/update/{id}', [SaldoAwalController::class, 'update'])->name('saldo-awal.update');
        Route::delete('/saldo-awal/delete/{id}', [SaldoAwalController::class, 'destroy'])->name('saldo-awal.destroy');


        // Role & Permission Management - ADMIN ONLY
        Route::get('show-roles', [RoleAndPermissionController::class, 'show']);
        Route::get('create-roles', [RoleAndPermissionController::class, 'createRole']);
        Route::post('add-role', [RoleAndPermissionController::class, 'create']);
        Route::get('edit-role/{id}', [RoleAndPermissionController::class, 'editRole']);
        Route::post('update-role', [RoleAndPermissionController::class, 'updateRole']);
        Route::get('delete-role/{id}', [RoleAndPermissionController::class, 'delete']);
    });

    // ========== ROUTES KHUSUS ANGGOTA ONLY ==========
    Route::middleware(['role:anggota'])->group(function () {

        Route::get('/anggota/profile', [ProfileController::class, 'edit'])->name('anggota.profile.edit');
        Route::post('/anggota/profile', [ProfileController::class, 'update'])->name('anggota.profile.update');

        // Dashboard Anggota
        Route::get('/anggota/dashboard', [AnggotaDashboardController::class, 'index'])->name('anggota.dashboard');

        // Simpanan Routes untuk Anggota
        Route::prefix('anggota/simpanan')->name('anggota.simpanan.')->group(function () {
            Route::get('/', [SimpananUserController::class, 'index'])->name('index');
            Route::get('/create', [SimpananUserController::class, 'create'])->name('create');
            Route::get('/main', [SimpananUserController::class, 'main'])->name('main');
            Route::get('/show/{id}', [SimpananUserController::class, 'show'])->name('show');

            Route::post('/', [SimpananUserController::class, 'store'])->name('store');
        });

        // Pinjaman Routes untuk Anggota
        // Pinjaman Routes untuk Anggota
        Route::prefix('anggota/pinjaman')->name('anggota.pinjaman.')->group(function () {
            Route::get('/', [PinjamanUserController::class, 'index'])->name('index');
            Route::get('/create', [PinjamanUserController::class, 'create'])->name('create');
            Route::post('/store', [PinjamanUserController::class, 'store'])->name('store'); // UBAH INI
            Route::get('/main', [PinjamanUserController::class, 'main'])->name('main');
            Route::get('/show/{id}', [PinjamanUserController::class, 'show'])->name('show');
        });

        // Penarikan Routes untuk Anggota
        Route::prefix('anggota/penarikan')->name('anggota.penarikan.')->group(function () {
            Route::get('/', [PenarikanUserController::class, 'index'])->name('index');
            Route::get('/create', [PenarikanUserController::class, 'create'])->name('create');
            Route::get('/main', [PenarikanUserController::class, 'main'])->name('main');
            Route::get('/show', [PenarikanUserController::class, 'show'])->name('show');
        });

    });

});

Auth::routes();
