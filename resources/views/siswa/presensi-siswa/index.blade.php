@extends('layouts.app')
@section('content')
    <div class="container">
        <section class="section">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h1>Presensi Menu</h1>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Status Presensi Hari Ini -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Status Presensi Hari Ini</h4>
                </div>
                <div class="card-body">
                    @if (!$userCheckedInToday)
                        <div class="alert alert-primary text-left">
                            <strong>Belum Ada Presensi</strong><br>
                            Anda belum melakukan presensi hari ini!
                            <br>
                            <button class="btn btn-success mt-3" data-toggle="modal" data-target="#checkInModal">
                                <i class="fas fa-clock mr-2"></i>Presensi Sekarang
                            </button>
                        </div>
                    @else
                        <div class="alert alert-success text-left">
                            <strong>Sudah Presensi</strong><br>
                            Anda telah melakukan presensi hari ini.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Presensi -->
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Presensi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($presensi as $index => $item)
                                    <tr>
                                        <td>{{ $index + $presensi->firstItem() }}</td>
                                        <td>{{ $item->created_at->format('d F Y') }}</td>
                                        <td>{{ $item->presensi->name ?? 'N/A' }}</td>
                                        <td>{{ optional($item->presensi->start_date)->format('H:i') ?? 'N/A' }}</td>
                                        <td>{{ optional($item->presensi->end_date)->format('H:i') ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $item->status->badge_color }}">
                                                {{ $item->status->name }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data presensi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $presensi->links() }}
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Presensi -->
        <div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkInModalLabel">Form Presensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('siswa.presensi-siswa.store') }}" id="presensiForm">
                            @csrf
                            <div class="form-group">
                                <label for="status">Pilih Status Kehadiran</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->uuid }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Tambahkan validasi form jika diperlukan
            $(document).ready(function() {
                $('#presensiForm').submit(function(e) {
                    let status = $('#status').val();
                    if (!status) {
                        e.preventDefault();
                        alert('Silakan pilih status kehadiran');
                    }
                });
            });
        </script>
    @endpush
@endsection
