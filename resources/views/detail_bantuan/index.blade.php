@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Bantuan - {{ $keluarga->nama_kk }}</h5>
                <div>
                    <a href="{{ route('keluarga.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('detail-bantuan.create', $keluarga->id) }}" class="btn btn-primary">Tambah Bantuan</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="150">ID Keluarga</th>
                                <td>{{ $keluarga->id }}</td>
                            </tr>
                            <tr>
                                <th>Nama KK</th>
                                <td>{{ $keluarga->nama_kk }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $keluarga->alamat }}</td>
                            </tr>
                            <tr>
                                <th>RT/RW</th>
                                <td>{{ $keluarga->rt }}/{{ $keluarga->rw }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="150">Kategori</th>
                                <td>{{ $keluarga->kategori }}</td>
                            </tr>
                            <tr>
                                <th>Kondisi Rumah</th>
                                <td>{{ $keluarga->kondisi_rumah }}</td>
                            </tr>
                            <tr>
                                <th>Status Bantuan</th>
                                <td>{{ $keluarga->status_bantuan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keluarga->detailBantuan as $bantuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bantuan->tanggal_mulai->format('d/m/Y') }}</td>
                                <td>
                                    @if($bantuan->tanggal_selesai)
                                        {{ $bantuan->tanggal_selesai->format('d/m/Y') }}
                                    @elseif($keluarga->status_bantuan == 'Sedang Diproses')
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#selesaiModal{{ $bantuan->id }}">
                                            <i class="bi bi-check-lg"></i> Selesaikan
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $bantuan->catatan ?? '-' }}</td>
                                <td>
                                    @if(!$bantuan->tanggal_selesai)
                                        <form action="{{ route('detail-bantuan.destroy', $bantuan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Selesai Bantuan -->
                            @if(!$bantuan->tanggal_selesai && $keluarga->status_bantuan == 'Sedang Diproses')
                            <div class="modal fade" id="selesaiModal{{ $bantuan->id }}" tabindex="-1" aria-labelledby="selesaiModalLabel{{ $bantuan->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="selesaiModalLabel{{ $bantuan->id }}">Selesaikan Bantuan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('detail-bantuan.complete', $bantuan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Selesai</label>
                                                    <input type="date" class="form-control" name="tanggal_selesai" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data bantuan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 