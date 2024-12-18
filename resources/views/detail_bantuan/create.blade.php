@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Data Bantuan - {{ $keluarga->nama_kk }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('detail-bantuan.store', $keluarga->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai Pembangunan</label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                    name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai Pembangunan</label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                    name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                                <small class="text-muted">Kosongkan jika belum selesai</small>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                            name="catatan" rows="3">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('keluarga.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection