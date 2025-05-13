@extends('layouts.main')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h3>Kurir</h3>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('kurir.create') }}">Tambah Kurir</a>
                </div>
            </div>
        </div>
        <div class="card p-5">
            <table id="example" class="display nowrap table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Kurir</th>
                        <th>Username</th>
                        <th>No HP</th>
                        <th>Tanggal Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kurir as $k)
                        <tr>
                            <td>{{ $k->nama_kurir }}</td>
                            <td>{{ $k->user->username }}</td>
                            <td>{{ $k->no_hp }}</td>
                            <td>{{ \Carbon\Carbon::parse($k->created_at)->translatedFormat('d F Y') }}</td>
                            <td>
                                <a style="color: rgb(90, 90, 54)" href="{{ route('kurir.edit', $k->id_kurir) }}" class="btn btn-warning btn-sm"><i
                                        class="fas fa-pen"></i></a>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $k->id_kurir }}"
                                    data-name="{{ $k->nama_kurir }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus kurir <strong id="kurirName"></strong> dan akunnya?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="{{ url('/kurir/delete/' . $k->id_kurir) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    
    <script>
        new DataTable('#example', {
            // autoFill: true
            scrollX: true

        });
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var kurirId = $(this).data('id');
                var kurirName = $(this).data('name');

                $('#kurirName').text(kurirName);
                // $('#deleteForm').attr('action', '/kurir/delete/' + kurirId);
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection
