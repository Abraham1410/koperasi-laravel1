@extends('layouts.anggota')

@section('title', 'Edit Profil Anggota')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-8">
    <h1 class="text-xl font-bold mb-4">Lengkapi Profil</h1>

    @if (session('message'))
        <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <a href="{{ route('anggota.dashboard') }}" class="btn btn-secondary mb-3">
        <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <form method="POST" action="{{ route('anggota.profile.update') }}">
        @csrf

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip', $anggota->nip ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="telphone" class="form-label">No Telepon</label>
            <input type="text" name="telphone" id="telphone" class="form-control" value="{{ old('telphone', $anggota->telphone ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="pekerjaan" class="form-label">Pekerjaan</label>
            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan', $anggota->pekerjaan ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
