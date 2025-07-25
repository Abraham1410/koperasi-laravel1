@extends('layouts.anggota')

@section('content')
    <!-- Header Section -->
    <section class="pt-28 pb-12">
        <div class="max-w-4xl mx-auto px-6 flex justify-center items-center">
            <h1 class="text-4xl md:text-5xl font-semibold flex items-center gap-x-2 
                    text-white drop-shadow-lg">
                <i class="fas fa-wallet"></i>
                Penarikan Dana
            </h1>
        </div>
    </section>

    <section class="py-2 max-w-4xl mx-auto px-6 grid">
        <div class="col-span-full flex justify-center">
            <div class="bg-blue-100 border text-blue-800 p-6 rounded-2xl mb-6 w-full max-w-md text-center">
                <h2 class="text-xl font-semibold">Saldo Anda Saat Ini</h2>
                <p class="text-xl">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
            </div>
        </div>
    </section>

    <!-- Penarikan Feature -->
    <section class="py-4 flex-grow">
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8 px-6">
            <!-- Ajukan Penarikan -->
            <a href="{{ route('anggota.penarikan.create') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                <div class="flex items-center gap-4 mb-2">
                    <i class="fas fa-money-bill-wave bg-white text-gray-800 rounded-full p-3 shadow"></i>
                    <h3 class="text-xl font-semibold text-black">Ajukan Penarikan</h3>
                </div>
                <p class="text-gray-600">Tarik dana simpanan Anda dengan mudah dan aman.</p>
            </a>

            <!-- Lihat Riwayat Penarikan -->
            <a href="{{ route('anggota.penarikan.main') }}" class="block !no-underline bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300 hover:bg-gray-50">
                <div class="flex items-center gap-4 mb-2">
                    <i class="fas fa-history bg-white text-gray-800 rounded-full p-3 shadow"></i>
                    <h3 class="text-xl font-semibold text-black">Riwayat Penarikan</h3>
                </div>
                <p class="text-gray-600">Lihat riwayat pengajuan penarikan dana Anda.</p>
            </a>
        </div>
    </section>

    <!-- Back to Main -->
    <div class="text-center mt-12">
        <a href="{{ route('anggota.dashboard') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
@endsection
