@extends('layouts.anggota')

@section('title', 'Detail Pinjaman')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-center text-white font-semibold pb-6">Detail Pinjaman</h2>

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

    {{-- Loan Information Card --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Pinjaman</h4>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <table class="w-full text-sm">
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Kode Pinjaman</th>
                        <td class="py-2 font-semibold text-blue-600">{{ $pinjaman->kodeTransaksiPinjaman }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Nama Anggota</th>
                        <td class="py-2">{{ $pinjaman->anggota_name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Tanggal Pinjam</th>
                        <td class="py-2">{{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjam)->format('d F Y') }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Jatuh Tempo</th>
                        <td class="py-2">{{ \Carbon\Carbon::parse($pinjaman->jatuh_tempo)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Pinjaman Pokok</th>
                        <td class="py-2 font-semibold text-green-600">Rp {{ number_format($pinjaman->jml_pinjam, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full text-sm">
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Lama Pinjaman</th>
                        <td class="py-2">{{ $pinjaman->jml_cicilan }} Bulan</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Bunga</th>
                        <td class="py-2">{{ $pinjaman->bunga_pinjam }}%</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Total Dengan Bunga</th>
                        <td class="py-2 font-semibold text-red-600">Rp {{ number_format($pinjaman->total_pinjaman_dengan_bunga, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Status Pengajuan</th>
                        <td class="py-2">
                            @if($pinjaman->status_pengajuan == 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu Persetujuan
                                </span>
                            @elseif($pinjaman->status_pengajuan == 1)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Disetujui
                                </span>
                            @elseif($pinjaman->status_pengajuan == 2)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Ditolak
                                </span>
                            @elseif($pinjaman->status_pengajuan == 3)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-check-double mr-1"></i>
                                    Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left py-2 pr-4 text-gray-600 font-medium">Dibuat Oleh</th>
                        <td class="py-2">{{ $pinjaman->created_by_name }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Rejection Reason --}}
        @if($pinjaman->status_pengajuan == 2 && $pinjaman->keterangan_ditolak_pengajuan)
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <h5 class="font-medium text-red-800 mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Alasan Penolakan
                </h5>
                <p class="text-red-700 text-sm">{{ $pinjaman->keterangan_ditolak_pengajuan }}</p>
            </div>
        @endif
    </div>

    {{-- Installments Section (Only if approved) --}}
    @if($pinjaman->status_pengajuan == 1)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800">Daftar Angsuran</h5>
            </div>
            <div class="p-6">
                @if($angsuran->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-sm text-left text-gray-700">
                            <thead class="uppercase text-xs font-semibold text-gray-600 bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Kode Angsuran</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Jumlah Pokok</th>
                                    <th class="px-4 py-3">Bunga</th>
                                    <th class="px-4 py-3">Denda</th>
                                    <th class="px-4 py-3">Cicilan Ke-</th>
                                    <th class="px-4 py-3">Sisa Pinjaman</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($angsuran as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 font-medium text-blue-600">{{ $item->kodeTransaksiAngsuran }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_angsuran)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($item->jml_angsuran, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($item->bunga_pinjaman, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">
                                            @if($item->denda > 0)
                                                <span class="text-red-600">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">{{ $item->cicilan }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($item->sisa_angsuran, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">
                                            @if($item->status == 0)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Belum Lunas
                                                </span>
                                            @elseif($item->status == 1)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Lunas
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 font-semibold">Rp {{ number_format($item->total_angsuran_dengan_bunga, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">
                                            @if($item->status == 0)
                                                <button onclick="viewAngsuranDetail('{{ $item->angsuran_id }}')"
                                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    Detail
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <th colspan="9" class="px-4 py-3 text-right font-semibold text-gray-800">Total Angsuran Dibayar:</th>
                                    <th class="px-4 py-3 font-bold text-green-600">Rp {{ number_format($total_angsuran, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Pagination for installments --}}
                    @if($angsuran->hasPages())
                        <div class="mt-4">
                            {{ $angsuran->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium">Belum ada angsuran</p>
                        <p class="text-sm text-gray-400">Angsuran akan muncul setelah admin memproses pembayaran</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="bg-white shadow-md rounded-lg p-6 mt-6">
            <h5 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h5>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-blue-600 text-sm font-medium">Total Pinjaman + Bunga</div>
                    <div class="text-blue-800 text-xl font-bold">Rp {{ number_format($pinjaman->total_pinjaman_dengan_bunga, 0, ',', '.') }}</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-green-600 text-sm font-medium">Total Dibayar</div>
                    <div class="text-green-800 text-xl font-bold">Rp {{ number_format($total_angsuran, 0, ',', '.') }}</div>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <div class="text-orange-600 text-sm font-medium">Sisa Pembayaran</div>
                    <div class="text-orange-800 text-xl font-bold">Rp {{ number_format($pinjaman->total_pinjaman_dengan_bunga - $total_angsuran, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    @endif

    {{-- Back Button --}}
    <div class="mt-6 text-center">
        <a href="{{ route('anggota.pinjaman.main') }}"
           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Pinjaman
        </a>
    </div>
</div>

{{-- Modal for Angsuran Detail (Optional) --}}
<div id="angsuranDetailModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-lg w-full mx-auto">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Detail Angsuran</h3>
            <button onclick="closeAngsuranModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="angsuranDetailContent" class="p-6">
            {{-- Content will be loaded here --}}
        </div>
    </div>
</div>

<script>
function viewAngsuranDetail(angsuranId) {
    // You can implement AJAX call to get detailed angsuran information
    // For now, just show a placeholder modal
    document.getElementById('angsuranDetailModal').classList.remove('hidden');
    document.getElementById('angsuranDetailContent').innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-spinner fa-spin text-2xl text-gray-400 mb-2"></i>
            <p class="text-gray-500">Memuat detail angsuran...</p>
        </div>
    `;

    // Simulate loading - replace this with actual AJAX call
    setTimeout(() => {
        document.getElementById('angsuranDetailContent').innerHTML = `
            <div class="space-y-4">
                <p class="text-gray-600">Detail angsuran dengan ID: ${angsuranId}</p>
                <p class="text-sm text-gray-500">Fitur ini dapat dikembangkan lebih lanjut untuk menampilkan informasi detail angsuran, bukti pembayaran, dan keterangan lainnya.</p>
            </div>
        `;
    }, 1000);
}

function closeAngsuranModal() {
    document.getElementById('angsuranDetailModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('angsuranDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAngsuranModal();
    }
});
</script>
@endsection
