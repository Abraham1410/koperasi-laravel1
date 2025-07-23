@extends('layouts.anggota')

@section('title', 'Riwayat Penarikan')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-center text-white font-semibold pb-6">Riwayat Penarikan Dana</h2>

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

    {{-- Info Total Penarikan --}}
    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-6 border border-blue-300 text-center">
        Total penarikan Anda: <strong>Rp {{ number_format($totalPenarikan ?? 0, 0, ',', '.') }}</strong>
    </div>

    {{-- Table Container --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex flex-wrap justify-between items-center p-4 space-y-2 md:space-y-0">
            {{-- Date Filter --}}
            <form method="GET" class="flex gap-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded px-2 py-1">
                <span class="text-sm self-center">to</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded px-2 py-1">
                <button type="submit" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 transition">
                    <i class="fas fa-filter"></i>
                </button>
                @if(request('start_date') || request('end_date'))
                    <a href="{{ route('anggota.penarikan.main') }}" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>

            {{-- Search --}}
            <form method="GET" class="flex items-center gap-2">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari kode transaksi..." class="border rounded px-3 py-1">
                <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="uppercase text-xs font-semibold text-gray-600 bg-gray-100">
                    <tr>
                        <th class="px-4 py-3">Kode Penarikan</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Jumlah Penarikan</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($penarikan as $item)
                        <tr>
                            <td class="px-4 py-2 font-medium">{{ $item->kodeTransaksipenarikan }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_penarikan)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 text-green-600 font-semibold">Rp {{ number_format($item->jumlah_penarikan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $item->keterangan ?: '-' }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('anggota.penarikan.show', $item->penarikan_id) }}"
                                   class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Belum ada data penarikan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($penarikan->hasPages())
            <div class="p-4">
                {{ $penarikan->links() }}
            </div>
        @endif

        <div class="p-4 text-sm text-gray-600">
            Menampilkan {{ $penarikan->firstItem() ?? 0 }} - {{ $penarikan->lastItem() ?? 0 }} dari {{ $penarikan->total() }} entri
        </div>
    </div>

    <div class="text-center mt-12">
        <a href="{{ route('anggota.penarikan.index') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>
@endsection
