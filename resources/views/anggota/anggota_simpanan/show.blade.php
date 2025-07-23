@extends('layouts.anggota')
@section('title', 'Detail Simpanan')
@section('content')
<div class="max-w-2xl mx-auto px-4 pt-8 pb-16">
    <h2 class="text-2xl text-white font-semibold text-center pb-6">Detail Simpanan</h2>

    {{-- Alert for messages --}}
    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Informasi Simpanan</h3>
            <div class="grid grid-cols-1 gap-4">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Kode Transaksi:</span>
                    <span class="text-gray-800">{{ $detailSimpanan->kode }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Tanggal Simpanan:</span>
                    <span class="text-gray-800">{{ date('d F Y', strtotime($detailSimpanan->tgl)) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Jenis Simpanan:</span>
                    <span class="text-gray-800">{{ $detailSimpanan->jenis_simpanan_nama }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Jumlah Simpanan:</span>
                    <span class="text-gray-800 font-semibold">Rp {{ number_format($detailSimpanan->jmlh, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Tercatat
                    </span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Dibuat Oleh:</span>
                    <span class="text-gray-800">{{ $detailSimpanan->created_by }}</span>
                </div>
                @if($detailSimpanan->updated_by)
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Diperbarui Oleh:</span>
                    <span class="text-gray-800">{{ $detailSimpanan->updated_by }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Informasi Anggota</h3>
            <div class="flex items-start space-x-4 mb-4">
                @if($detailSimpanan->anggota_image)
                    <img src="{{ asset($detailSimpanan->anggota_image) }}"
                         alt="Foto Anggota"
                         class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ $detailSimpanan->anggota_name }}</h4>
                    <p class="text-sm text-gray-600">NIP: {{ $detailSimpanan->anggota_nip }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Telepon:</span>
                    <span class="text-gray-800">{{ $detailSimpanan->anggota_telphone ?: '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Alamat:</span>
                    <span class="text-gray-800 text-right">{{ $detailSimpanan->anggota_alamat ?: '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Pekerjaan:</span>
                    <span class="text-gray-800">{{ $detailSimpanan->anggota_pekerjaan ?: '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-600">Agama:</span>
                    <span class="text-gray-800">{{ $detailSimpanan->anggota_agama ?: '-' }}</span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Bukti Pembayaran</h3>
            @if($detailSimpanan->bukti)
                <div class="text-center">
                    <img src="{{ asset($detailSimpanan->bukti) }}"
                         alt="Bukti Pembayaran"
                         class="max-w-full h-auto rounded-lg shadow-md border mx-auto mb-3"
                         style="max-height: 400px;">
                    <div class="flex justify-center space-x-2">
                        <a href="{{ asset($detailSimpanan->bukti) }}"
                           target="_blank"
                           class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Penuh
                        </a>
                        <a href="{{ asset($detailSimpanan->bukti) }}"
                           download
                           class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh
                        </a>
                    </div>
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada bukti pembayaran</p>
                </div>
            @endif
        </div>

        <div class="flex justify-center space-x-3">
            <a href="{{ route('anggota.simpanan.main') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <a href="{{ route('anggota.simpanan.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Simpanan Baru
            </a>
        </div>
    </div>
</div>
@endsection
