@extends('layouts.anggota')

@section('title', 'Tambah Pinjaman')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <h2 class="text-2xl text-center text-white font-bold pb-6">Tambah Pinjaman</h2>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-6 border border-blue-300">
        Jumlah maksimal pinjaman baru adalah <strong>Rp {{ number_format($maxPinjamanBaru ?? 500000, 0, ',', '.') }}</strong>.
    </div>

    {{-- PERBAIKAN: Ubah action dari "#" ke route store --}}
    <form method="POST" action="{{ route('anggota.pinjaman.store') }}" enctype="multipart/form-data" class="space-y-6 block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        @csrf

        {{-- Hidden field untuk kode transaksi --}}
        <input type="hidden" name="kodeTransaksiPinjaman" value="{{ $kodeTransaksiPinjaman ?? '' }}">

        <div>
            <label for="tanggal_pinjam" class="block font-medium text-gray-700">Tanggal Pinjam</label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('tanggal_pinjam') border-red-500 @enderror" required>
            @error('tanggal_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jml_cicilan" class="block font-medium text-gray-700">Lama (bulan)</label>
            <input type="number" id="jml_cicilan" name="jml_cicilan" value="{{ old('jml_cicilan') }}" min="1" max="60" class="w-full mt-1 p-2 border border-gray-300 rounded @error('jml_cicilan') border-red-500 @enderror" required>
            @error('jml_cicilan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jatuh_tempo" class="block font-medium text-gray-700">Jatuh Tempo</label>
            <input type="date" id="jatuh_tempo" name="jatuh_tempo" value="{{ old('jatuh_tempo') }}" readonly class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100 @error('jatuh_tempo') border-red-500 @enderror">
            @error('jatuh_tempo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="bunga_pinjam" class="block font-medium text-gray-700">Bunga Pinjam (%)</label>
            <input type="number" id="bunga_pinjam" name="bunga_pinjam" value="{{ old('bunga_pinjam') }}" step="0.01" min="0" max="100" class="w-full mt-1 p-2 border border-gray-300 rounded @error('bunga_pinjam') border-red-500 @enderror" required>
            @error('bunga_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jml_pinjam" class="block font-medium text-gray-700">Jumlah Pinjam</label>
            <input type="number" id="jml_pinjam" name="jml_pinjam" value="{{ old('jml_pinjam') }}" min="1" max="{{ $maxPinjamanBaru ?? 500000 }}" class="w-full mt-1 p-2 border border-gray-300 rounded @error('jml_pinjam') border-red-500 @enderror" required>
            @error('jml_pinjam')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-center grid grid-cols-2 gap-x-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="{{ route('anggota.pinjaman.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </form>
</div>

{{-- JavaScript untuk auto-calculate jatuh tempo --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalPinjam = document.getElementById('tanggal_pinjam');
    const jmlCicilan = document.getElementById('jml_cicilan');
    const jatuhTempo = document.getElementById('jatuh_tempo');

    function calculateJatuhTempo() {
        if (tanggalPinjam.value && jmlCicilan.value) {
            const startDate = new Date(tanggalPinjam.value);
            const months = parseInt(jmlCicilan.value);

            if (!isNaN(months) && months > 0) {
                const endDate = new Date(startDate);
                endDate.setMonth(endDate.getMonth() + months);

                const year = endDate.getFullYear();
                const month = String(endDate.getMonth() + 1).padStart(2, '0');
                const day = String(endDate.getDate()).padStart(2, '0');

                jatuhTempo.value = `${year}-${month}-${day}`;
            }
        }
    }

    tanggalPinjam.addEventListener('change', calculateJatuhTempo);
    jmlCicilan.addEventListener('input', calculateJatuhTempo);

    // Calculate on page load if values exist
    calculateJatuhTempo();
});
</script>
@endsection
