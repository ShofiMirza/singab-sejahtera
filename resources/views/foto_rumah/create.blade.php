@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Upload Foto Rumah - {{ $keluarga->nama_kk }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('foto-rumah.store', $keluarga->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Foto Depan</label>
                                <input type="file" class="form-control @error('foto_depan') is-invalid @enderror" 
                                    name="foto_depan" accept="image/*" required>
                                @error('foto_depan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Foto Samping</label>
                                <input type="file" class="form-control @error('foto_samping') is-invalid @enderror" 
                                    name="foto_samping" accept="image/*" required>
                                @error('foto_samping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Foto Dalam</label>
                                <input type="file" class="form-control @error('foto_dalam') is-invalid @enderror" 
                                    name="foto_dalam" accept="image/*" required>
                                @error('foto_dalam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('keluarga.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 