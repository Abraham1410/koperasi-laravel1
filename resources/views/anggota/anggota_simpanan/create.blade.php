@extends('layouts.anggota')

@section('title', 'Tambah Simpanan')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-6">
    <h2 class="text-2xl text-center text-white font-bold pb-6">Tambah Simpanan</h2>

    {{-- Alert for errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alert for success --}}
    @if (session('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Alert for error --}}
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('anggota.simpanan.store') }}" enctype="multipart/form-data" class="space-y-6 block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        @csrf

        <div>
            <label for="kodeTransaksiSimpanan" class="block font-medium text-gray-700">Kode Transaksi</label>
            <input type="text" id="kodeTransaksiSimpanan" name="kodeTransaksiSimpanan" value="{{ $kodeTransaksiSimpanan }}" readonly class="w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100">
        </div>

        <div>
            <label for="tanggal_simpanan" class="block font-medium text-gray-700">Tanggal Simpanan <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal_simpanan" name="tanggal_simpanan" value="{{ old('tanggal_simpanan', date('Y-m-d')) }}" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
        </div>

        <div>
            <label for="id_jenis_simpanan" class="block font-medium text-gray-700">Jenis Simpanan <span class="text-red-500">*</span></label>
            <select id="id_jenis_simpanan" name="id_jenis_simpanan" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
                <option value="" disabled selected>Pilih Jenis Simpanan</option>
                @foreach($jenisSimpanan as $jenis)
                    <option value="{{ $jenis->id }}"
                        data-nominal="{{ $jenis->id == 1 ? '250000' : ($jenis->id == 4 ? '20000' : '0') }}"
                        {{ old('id_jenis_simpanan') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="jml_simpanan" class="block font-medium text-gray-700">Jumlah Simpanan <span class="text-red-500">*</span></label>
            <input type="number" id="jml_simpanan" name="jml_simpanan" value="{{ old('jml_simpanan') }}" class="w-full mt-1 p-2 border border-gray-300 rounded" min="0" step="1000">
            <small class="text-gray-500">*Untuk simpanan sukarela dan insidental, masukkan jumlah yang diinginkan</small>
        </div>

        <div>
            <label for="bukti_pembayaran" class="block font-medium text-gray-700">Bukti Pembayaran <span class="text-red-500">*</span></label>
            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,application/pdf" class="w-full mt-1 p-2 border border-gray-300 rounded" required>
            <small class="text-gray-500">Format yang diterima: JPG, JPEG, PNG, PDF (Maksimal 2MB)</small>
        </div>

        <div class="text-center grid grid-cols-2 gap-x-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Submit</button>
            <a href="{{ route('anggota.simpanan.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">Kembali</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('id_jenis_simpanan');
        const jumlahInput = document.getElementById('jml_simpanan');

        jenisSelect.addEventListener('change', function() {
            const selected = jenisSelect.options[jenisSelect.selectedIndex];
            const nominal = selected.getAttribute('data-nominal');

            if (nominal && nominal !== '0') {
                jumlahInput.value = nominal;
                jumlahInput.readOnly = true;
                jumlahInput.classList.add('bg-gray-100');
            } else {
                jumlahInput.value = '';
                jumlahInput.readOnly = false;
                jumlahInput.classList.remove('bg-gray-100');
            }
        });

        // Format number input
        jumlahInput.addEventListener('input', function() {
            if (!jumlahInput.readOnly) {
                const value = this.value.replace(/\D/g, '');
                this.value = value;
            }
        });
    });
</script>
@endsection
