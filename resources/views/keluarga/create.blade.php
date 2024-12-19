@extends('layouts.app')

@section('content')
<style>
/* Remove spinner arrows from number inputs */
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    margin: 0; 
}
input[type=number] {
    -moz-appearance: textfield;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Data Keluarga</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('keluarga.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">ID Keluarga</label>
                        <input type="text" class="form-control @error('id') is-invalid @enderror" 
                            name="id" value="{{ old('id') }}" 
                            placeholder="Contoh: KLG-001">
                        @error('id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control @error('nama_kk') is-invalid @enderror" 
                            name="nama_kk" value="{{ old('nama_kk') }}">
                        @error('nama_kk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Patokan Rumah</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                            name="alamat" rows="3">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">RT</label>
                            <input type="text" class="form-control @error('rt') is-invalid @enderror" 
                                name="rt" value="{{ old('rt') }}" 
                                placeholder="Contoh: 001">
                            @error('rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RW</label>
                            <input type="text" class="form-control @error('rw') is-invalid @enderror" 
                                name="rw" value="{{ old('rw') }}" 
                                placeholder="Contoh: 001">
                            @error('rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="number" class="form-control @error('latitude') is-invalid @enderror" 
                                name="latitude" value="{{ old('latitude') }}" 
                                step="0.00000001"
                                placeholder="-6.65646850">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="number" class="form-control @error('longitude') is-invalid @enderror" 
                                name="longitude" value="{{ old('longitude') }}" 
                                step="0.00000001"
                                placeholder="110.69031800">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror" name="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="Sangat Miskin" {{ old('kategori') == 'Sangat Miskin' ? 'selected' : '' }}>Sangat Miskin</option>
                            <option value="Miskin" {{ old('kategori') == 'Miskin' ? 'selected' : '' }}>Miskin</option>
                            <option value="Rentan Miskin" {{ old('kategori') == 'Rentan Miskin' ? 'selected' : '' }}>Rentan Miskin</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kondisi Rumah</label>
                        <select class="form-select @error('kondisi_rumah') is-invalid @enderror" name="kondisi_rumah">
                            <option value="">Pilih Kondisi Rumah</option>
                            <option value="Rusak Berat" {{ old('kondisi_rumah') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            <option value="Sedang" {{ old('kondisi_rumah') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Baik" {{ old('kondisi_rumah') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        </select>
                        @error('kondisi_rumah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Bantuan</label>
                        <select class="form-select @error('status_bantuan') is-invalid @enderror" name="status_bantuan">
                            <option value="">Pilih Status Bantuan</option>
                            <option value="Belum Dibantu" {{ old('status_bantuan') == 'Belum Dibantu' ? 'selected' : '' }}>Belum Dibantu</option>
                            <option value="Sedang Diproses" {{ old('status_bantuan') == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="Sudah Dibantu" {{ old('status_bantuan') == 'Sudah Dibantu' ? 'selected' : '' }}>Sudah Dibantu</option>
                        </select>
                        @error('status_bantuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Rumah</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Depan</label>
                                    <input type="file" class="form-control @error('foto_depan') is-invalid @enderror" 
                                        name="foto_depan" accept="image/*">
                                    @error('foto_depan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Samping</label>
                                    <input type="file" class="form-control @error('foto_samping') is-invalid @enderror" 
                                        name="foto_samping" accept="image/*">
                                    @error('foto_samping')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Dalam</label>
                                    <input type="file" class="form-control @error('foto_dalam') is-invalid @enderror" 
                                        name="foto_dalam" accept="image/*">
                                    @error('foto_dalam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
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