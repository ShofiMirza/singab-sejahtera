@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Pembangunan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Keluarga</th>
                                <th>Nama KK</th>
                                <th>RT/RW</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($detailBantuan as $bantuan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('detail-bantuan.index', $bantuan->keluarga->id) }}">
                                        {{ $bantuan->keluarga->id }}
                                    </a>
                                </td>
                                <td>{{ $bantuan->keluarga->nama_kk }}</td>
                                <td>{{ $bantuan->keluarga->rt }}/{{ $bantuan->keluarga->rw }}</td>
                                <td>{{ $bantuan->tanggal_mulai->format('d/m/Y') }}</td>
                                <td>{{ $bantuan->tanggal_selesai ? $bantuan->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($bantuan->tanggal_selesai)
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning">Dalam Proses</span>
                                    @endif
                                </td>
                                <td>{{ $bantuan->catatan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data bantuan</td>
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