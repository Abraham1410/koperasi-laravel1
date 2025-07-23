@extends('layouts.anggota')
@section('title', 'Pinjaman Saya')
@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-center text-white font-semibold text-gray-800 pb-6">Data Pinjaman Saya</h2>

    {{-- Alert for messages --}}
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

    {{-- Action Button --}}
    <div class="mb-4">
        <a href="{{ route('anggota.pinjaman.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200 inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Ajukan Pinjaman Baru
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex flex-wrap justify-between items-center p-4 space-y-2 md:space-y-0">
            {{-- Date Filter --}}
            <form method="GET" action="{{ route('anggota.pinjaman.main') }}" class="flex gap-2">
                <input type="date" name="start_date" class="border rounded px-2 py-1" value="{{ $startDate }}">
                <span class="text-sm self-center">To</span>
                <input type="date" name="end_date" class="border rounded px-2 py-1" value="{{ $endDate }}">
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                    <i class="fas fa-filter"></i>
                </button>
                @if($startDate || $endDate)
                    <a href="{{ route('anggota.pinjaman.main') }}" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>

            {{-- Search Filter --}}
            <form method="GET" action="{{ route('anggota.pinjaman.main') }}" class="flex items-center gap-2">
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
                        <th class="px-4 py-3">Tanggal Pinjam</th>
                        <th class="px-4 py-3">Jumlah Pinjam</th>
                        <th class="px-4 py-3">Bunga (%)</th>
                        <th class="px-4 py-3">Lama Cicilan</th>
                        <th class="px-4 py-3">Jatuh Tempo</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pinjaman as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $pinjaman->firstItem() + $index }}</td>
                            <td class="px-4 py-2 font-medium text-blue-600">{{ $item->kodeTransaksiPinjaman }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($item->jml_pinjam, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $item->bunga_pinjam }}%</td>
                            <td class="px-4 py-2">{{ $item->jml_cicilan }} bulan</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                @if($item->status_pengajuan == 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu Persetujuan
                                    </span>
                                @elseif($item->status_pengajuan == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Disetujui
                                    </span>
                                @elseif($item->status_pengajuan == 2)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @elseif($item->status_pengajuan == 3)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-check-double mr-1"></i>
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('anggota.pinjaman.show', $item->pinjaman_id) }}"
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 transition duration-200 inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </a>

                                    @if($item->status_pengajuan == 2)
                                        <button type="button"
                                                class="bg-orange-500 text-white px-3 py-1 rounded text-xs hover:bg-orange-600 transition duration-200 inline-flex items-center"
                                                onclick="showRejectionReason('{{ $item->keterangan_ditolak_pengajuan }}')">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Alasan
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada data pinjaman</p>
                                    <p class="text-sm text-gray-400">Data pinjaman akan muncul setelah Anda mengajukan pinjaman</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pinjaman->hasPages())
            <div class="px-4 py-3 bg-white border-t border-gray-200">
                {{ $pinjaman->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    {{-- Back Button --}}
    <div class="text-center mt-12">
        <a href="{{ route('anggota.pinjaman.index') }}" class="inline-block bg-white px-6 py-3 text-sm font-medium text-gray-800 rounded-2xl shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>

{{-- Modal for rejection reason --}}
<div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Alasan Penolakan</h3>
                <button type="button" onclick="closeRejectionModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-2 px-7 py-3">
                <p id="rejectionReason" class="text-sm text-gray-500"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeModalBtn" onclick="closeRejectionModal()"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showRejectionReason(reason) {
        document.getElementById('rejectionReason').textContent = reason || 'Tidak ada keterangan.';
        document.getElementById('rejectionModal').classList.remove('hidden');
    }

    function closeRejectionModal() {
        document.getElementById('rejectionModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('rejectionModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectionModal();
        }
    });
</script>
@endpush
@endsection
