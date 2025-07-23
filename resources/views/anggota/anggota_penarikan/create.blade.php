@extends('layouts.anggota')

@section('title', 'Buat Penarikan')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <h2 class="text-2xl text-center text-white font-bold pb-6">Formulir Penarikan Dana</h2>

    {{-- Menampilkan pesan error atau success --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Info saldo --}}
    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-6 border border-blue-300 text-center">
        Jumlah saldo Anda saat ini adalah <strong>Rp {{ number_format($anggota->saldo ?? 0, 0, ',', '.') }}</strong>.
    </div>

    {{-- Peringatan jika ada pinjaman aktif --}}
    @if(isset($pinjaman) && $pinjaman)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Peringatan!</strong>
            <span class="block sm:inline">Anda memiliki pinjaman yang belum selesai. Silakan selesaikan pinjaman terlebih dahulu sebelum melakukan penarikan.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('anggota.penarikan.store') }}" enctype="multipart/form-data" class="space-y-6 block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        @csrf

        <div>
            <label for="tanggal_penarikan" class="block font-medium text-gray-700">Tanggal Penarikan <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal_penarikan" name="tanggal_penarikan" value="{{ old('tanggal_penarikan', date('Y-m-d')) }}"
                   class="w-full mt-1 p-2 border border-gray-300 rounded @error('tanggal_penarikan') border-red-500 @enderror" required>
            @error('tanggal_penarikan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jumlah_penarikan" class="block font-medium text-gray-700">Jumlah Penarikan <span class="text-red-500">*</span></label>
            <input type="number" id="jumlah_penarikan" name="jumlah_penarikan" value="{{ old('jumlah_penarikan') }}"
                   min="1000" max="{{ $anggota->saldo ?? 0 }}" step="1000"
                   class="w-full mt-1 p-2 border border-gray-300 rounded @error('jumlah_penarikan') border-red-500 @enderror"
                   placeholder="Minimal Rp 1.000" required>
            <small class="text-gray-500">Jumlah minimal penarikan: Rp 1.000</small>
            @error('jumlah_penarikan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="keterangan" class="block font-medium text-gray-700">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="4"
                      class="w-full mt-1 p-2 border border-gray-300 rounded @error('keterangan') border-red-500 @enderror"
                      placeholder="Masukkan keterangan penarikan (opsional)">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-center grid grid-cols-2 gap-x-6">
            @if(!isset($pinjaman) || !$pinjaman)
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Ajukan Penarikan
                </button>
            @else
                <button type="button" disabled class="bg-gray-400 text-white px-6 py-2 rounded cursor-not-allowed">
                    <i class="fas fa-ban mr-2"></i>Tidak Bisa Menarik
                </button>
            @endif
            <a href="{{ route('anggota.penarikan.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlah_penarikan');
    const maxSaldo = {{ $anggota->saldo ?? 0 }};

    jumlahInput.addEventListener('input', function() {
        const nilai = parseInt(this.value);
        if (nilai > maxSaldo) {
            alert('Jumlah penarikan tidak boleh melebihi saldo Anda: Rp ' + maxSaldo.toLocaleString('id-ID'));
            this.value = maxSaldo;
        }
    });
});
</script>
@endsection
