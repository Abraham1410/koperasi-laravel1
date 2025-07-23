@extends('layouts.anggota')

@section('title', 'Detail Penarikan')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-center text-white font-semibold pb-6">Detail Penarikan Dana</h2>

    {{-- Menampilkan pesan error --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Detail Card --}}
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h3 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-receipt mr-3"></i>
                Informasi Penarikan
            </h3>
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Kolom Kiri --}}
                <div class="space-y-4">
                    <div class="border-b pb-3">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kode Transaksi</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $penarikan->kodeTransaksipenarikan }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Anggota</label>
                        <p class="text-lg text-gray-900">{{ $penarikan->name }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Penarikan</label>
                        <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($penarikan->tanggal_penarikan)->format('d F Y') }}</p>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="space-y-4">
                    <div class="border-b pb-3">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jumlah Penarikan</label>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($penarikan->jumlah_penarikan, 0, ',', '.') }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Saldo Tersisa</label>
                        <p class="text-lg text-gray-900">Rp {{ number_format($penarikan->saldo, 0, ',', '.') }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Dibuat</label>
                        <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($penarikan->created_at)->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            <div class="mt-6 pt-6 border-t">
                <label class="block text-sm font-medium text-gray-600 mb-2">Keterangan</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900">{{ $penarikan->keterangan ?: 'Tidak ada keterangan' }}</p>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="mt-6 pt-6 border-t">
                <label class="block text-sm font-medium text-gray-600 mb-2">Status</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-2"></i>
                    Berhasil Diproses
                </span>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="text-center mt-8 space-x-4">
        <a href="{{ route('anggota.penarikan.main') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
            <i class="fas fa-list mr-2"></i>Kembali ke Riwayat
        </a>

        <button onclick="window.print()"
                class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
            <i class="fas fa-print mr-2"></i>Cetak
        </button>
    </div>
</div>

{{-- Print Styles --}}
<style>
@media print {
    .no-print, nav, footer {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .bg-gradient-to-r {
        background: #1e40af !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection
