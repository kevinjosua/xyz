@extends('layouts.kurir')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h3>Rekap Data Pengiriman</h3>
            </div>
        </div>
        <div class="card p-5">
            <table id="example" class="display nowrap table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Armada</th>
                        <th>Nomor Kendaraan</th>
                        <th>Muatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengiriman as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->tujuan }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->waktu)->format('h:i A') }}</td>
                            <td>{{ $data->armada }}</td>
                            <td>{{ $data->nomor_kendaraan }}</td>
                            <td>{{ $data->muatan }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
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
    </script>
@endsection
