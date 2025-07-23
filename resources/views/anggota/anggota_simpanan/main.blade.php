@extends('layouts.anggota')

@section('title', 'Simpanan')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-center text-white font-semibold text-gray-800 pb-6">Data Simpanan Saya</h2>

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

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex flex-wrap justify-between items-center p-4 space-y-2 md:space-y-0">
            <form method="GET" action="{{ route('anggota.simpanan.main') }}" class="flex gap-2">
                <input type="date" name="start_date" class="border rounded px-2 py-1" value="{{ $startDate }}">
                <span class="text-sm self-center">To</span>
                <input type="date" name="end_date" class="border rounded px-2 py-1" value="{{ $endDate }}">
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                    <i class="fas fa-filter"></i>
                </button>
                @if($startDate || $endDate)
                    <a href="{{ route('anggota.simpanan.main') }}" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>

            <form method="GET" action="{{ route('anggota.simpanan.main') }}" class="flex items-center gap-2">
                @if($startDate)
                    <input type="hidden" name="start_date" value="{{ $startDate }}">
                @endif
                @if($endDate)
                    <input type="hidden" name="end_date" value="{{ $endDate }}">
                @endif
                <input type="search" name="search" class="border rounded px-3 py-1" placeholder="Cari kode transaksi..." value="{{ $search }}">
                <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="uppercase text-xs font-semibold text-gray-600 bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Kode Transaksi</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Jenis Simpanan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($simpanan as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $simpanan->firstItem() + $index }}</td>
                            <td class="px-4 py-2 font-medium">{{ $item->kodeTransaksiSimpanan }}</td>
                            <td class="px-4 py-2">{{ date('d/m/Y', strtotime($item->tanggal_simpanan)) }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($item->jml_simpanan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $item->jenis_simpanan_nama }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Tercatat
                                </span>
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('anggota.simpanan.show', ['id' => $item->simpanan_id]) }}"
                                class="text-blue-500 hover:text-blue-700 transition"
                                title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                @if($search || $startDate || $endDate)
                                    Tidak ada data simpanan yang sesuai dengan filter.
                                @else
                                    Anda belum memiliki data simpanan.
                                    <a href="{{ route('anggota.simpanan.create') }}" class="text-blue-500 hover:text-blue-700">
                                        Buat simpanan pertama Anda.
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($simpanan->hasPages())
            <div class="p-4 border-t">
                {{ $simpanan->appends(request()->query())->links() }}
            </div>
        @endif

        <div class="p-4 text-sm text-gray-600 border-t">
            @if($simpanan->total() > 0)
                Menampilkan {{ $simpanan->firstItem() }} - {{ $simpanan->lastItem() }} dari {{ $simpanan->total() }} entri
            @endif
        </div>
    </div>

    <div class="text-center mt-12">
        <a href="{{ route('anggota.dashboard') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300 mr-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('anggota.simpanan.create') }}" class="inline-block bg-blue-600 px-6 py-3 text-sm font-medium text-white rounded-2xl shadow-sm hover:shadow-md hover:bg-blue-700 transition duration-300">
            <i class="fas fa-plus mr-2"></i> Tambah Simpanan
        </a>
    </div>
</div>
@endsection
