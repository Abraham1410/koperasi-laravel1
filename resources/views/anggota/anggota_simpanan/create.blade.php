@extends('layouts.anggota')

@section('title', 'Tambah Pinjaman')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <h2 class="text-2xl text-center text-white font-bold pb-6">Tambah Pinjaman</h2>

    {{-- Alert for messages --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 border border-green-300">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6 border border-red-300">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-6 border border-blue-300">
        <i class="fas fa-info-circle mr-2"></i>
        Jumlah maksimal pinjaman baru adalah <strong>Rp {{ number_format($maxPinjamanBaru, 0, ',', '.') }}</strong>.
    </div>

    <form method="POST" action="{{ route('anggota.pinjaman.store') }}" enctype="multipart/form-data" class="space-y-6 block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        @csrf

        <div>
            <label for="kode_transaksi" class="block font-medium text-gray-700">Kode Transaksi</label>
            <input type="text" id="kode_transaksi" name="kode_transaksi" value="{{ $kodeTransaksiPinjaman }}" readonly class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100">
            <p class="text-sm text-gray-500 mt-1">Kode transaksi akan digenerate otomatis</p>
        </div>

        <div>
            <label for="anggota_info" class="block font-medium text-gray-700">Pemohon</label>
            <div class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100">
                <strong>{{ $anggota->name }}</strong> - NIP: {{ $anggota->nip }}
            </div>
        </div>

        <div>
            <label for="tanggal_pinjam" class="block font-medium text-gray-700">Tanggal Pinjam <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('tanggal_pinjam') border-red-500 @enderror">
            @error('tanggal_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jml_pinjam" class="block font-medium text-gray-700">Jumlah Pinjam <span class="text-red-500">*</span></label>
            <input type="number" id="jml_pinjam" name="jml_pinjam" value="{{ old('jml_pinjam') }}" max="{{ $maxPinjamanBaru }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('jml_pinjam') border-red-500 @enderror" placeholder="Masukkan jumlah pinjaman">
            @error('jml_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jml_cicilan" class="block font-medium text-gray-700">Lama Cicilan (bulan) <span class="text-red-500">*</span></label>
            <input type="number" id="jml_cicilan" name="jml_cicilan" value="{{ old('jml_cicilan') }}" min="1" max="24" class="w-full mt-1 p-2 border border-gray-300 rounded @error('jml_cicilan') border-red-500 @enderror" placeholder="Contoh: 12">
            @error('jml_cicilan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jatuh_tempo" class="block font-medium text-gray-700">Jatuh Tempo</label>
            <input type="date" id="jatuh_tempo" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}" readonly class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100 @error('jatuh_tempo') border-red-500 @enderror">
            <p class="text-sm text-gray-500 mt-1">Akan dihitung otomatis berdasarkan tanggal pinjam dan lama cicilan</p>
            @error('jatuh_tempo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="bunga_pinjam" class="block font-medium text-gray-700">Bunga Pinjam (%) <span class="text-red-500">*</span></label>
            <input type="number" id="bunga_pinjam" name="bunga_pinjam" value="{{ old('bunga_pinjam', '2') }}" min="0" max="100" step="0.1" class="w-full mt-1 p-2 border border-gray-300 rounded @error('bunga_pinjam') border-red-500 @enderror" placeholder="Contoh: 2.5">
            @error('bunga_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Perhitungan Estimasi -->
        <div id="estimasi" class="hidden bg-gray-50 p-4 rounded border">
            <h4 class="font-semibold text-gray-700 mb-2">Estimasi Pembayaran:</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Jumlah Pinjam:</span>
                    <span id="est_pinjam" class="font-medium">Rp 0</span>
                </div>
                <div>
                    <span class="text-gray-600">Total Bunga:</span>
                    <span id="est_bunga" class="font-medium">Rp 0</span>
                </div>
                <div>
                    <span class="text-gray-600">Total Kembali:</span>
                    <span id="est_total" class="font-medium">Rp 0</span>
                </div>
                <div>
                    <span class="text-gray-600">Cicilan/Bulan:</span>
                    <span id="est_cicilan" class="font-medium">Rp 0</span>
                </div>
            </div>
        </div>

        <div class="text-center grid grid-cols-2 gap-x-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                <i class="fas fa-paper-plane mr-2"></i>Ajukan Pinjaman
            </button>
            <a href="{{ route('anggota.pinjaman.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalPinjam = document.getElementById('tanggal_pinjam');
    const jmlCicilan = document.getElementById('jml_cicilan');
    const jatuhTempo = document.getElementById('jatuh_tempo');
    const jmlPinjam = document.getElementById('jml_pinjam');
    const bungaPinjam = document.getElementById('bunga_pinjam');
    const estimasi = document.getElementById('estimasi');

    function calculateDueDate() {
        if (tanggalPinjam.value && jmlCicilan.value) {
            const startDate = new Date(tanggalPinjam.value);
            const months = parseInt(jmlCicilan.value);
            startDate.setMonth(startDate.getMonth() + months);
            jatuhTempo.value = startDate.toISOString().split('T')[0];
        }
    }

    function calculateEstimation() {
        const pinjam = parseFloat(jmlPinjam.value) || 0;
        const bunga = parseFloat(bungaPinjam.value) || 0;
        const cicilan = parseInt(jmlCicilan.value) || 1;

        if (pinjam > 0 && bunga >= 0) {
            const totalBunga = (pinjam * bunga) / 100;
            const totalKembali = pinjam + totalBunga;
            const cicilanBulanan = totalKembali / cicilan;

            document.getElementById('est_pinjam').textContent = 'Rp ' + pinjam.toLocaleString('id-ID');
            document.getElementById('est_bunga').textContent = 'Rp ' + totalBunga.toLocaleString('id-ID');
            document.getElementById('est_total').textContent = 'Rp ' + totalKembali.toLocaleString('id-ID');
            document.getElementById('est_cicilan').textContent = 'Rp ' + cicilanBulanan.toLocaleString('id-ID');

            estimasi.classList.remove('hidden');
        } else {
            estimasi.classList.add('hidden');
        }
    }

    tanggalPinjam.addEventListener('change', calculateDueDate);
    jmlCicilan.addEventListener('input', function() {
        calculateDueDate();
        calculateEstimation();
    });
    jmlPinjam.addEventListener('input', calculateEstimation);
    bungaPinjam.addEventListener('input', calculateEstimation);
});
</script>
@endsection
