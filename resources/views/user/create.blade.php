@extends('layouts.kurir')

@section('content')
    <div class="container">
        <h3>Input Data Pengiriman BBM</h3>
        <div class="card p-5">
            <form method="POST" action="{{ route('store.data') }}" enctype="multipart/form-data">
                @csrf

                {{-- Ambil jenis kurir dari user yang login --}}
                @php
                    $user = Auth::user();
                    $kurir = \App\Models\Kurir::where('id_user', $user->id)->first();
                    $jenisKurir = $kurir ? $kurir->jenis_kurir : '';
                @endphp

                <div class="form-group">
                    <label for="tujuan">Tujuan</label>
                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan"
                        name="tujuan" placeholder="Masukan Tujuan" value="{{ old('tujuan') }}">
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                        name="tanggal" value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="waktu">Waktu</label>
                    <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu"
                        name="waktu" value="{{ old('waktu') }}">
                    @error('waktu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="armada">Armada</label>
                    <input type="text" class="form-control" id="armada" name="armada"
                        value="{{ $jenisKurir }}" readonly>
                    {{-- <input type="hidden" name="armada" value="{{ $jenisKurir }}"> --}}
                </div>

                {{-- Jika jenis kurir adalah darat, tampilkan nomor kendaraan --}}
                <div class="form-group" id="field_nomor_kendaraan"
                    style="display: {{ $jenisKurir == 'Darat' ? 'block' : 'none' }};">
                    <label for="nomor_kendaraan">Nomor Kendaraan</label>
                    <input type="text" class="form-control @error('nomor_kendaraan') is-invalid @enderror"
                        id="nomor_kendaraan" name="nomor_kendaraan" placeholder="Masukan Nomor Kendaraan"
                        value="{{ old('nomor_kendaraan') }}">
                    @error('nomor_kendaraan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jika jenis kurir adalah laut, tampilkan dropdown nomor kapal --}}
                <div class="form-group" id="field_nomor_kapal"
                    style="display: {{ $jenisKurir == 'Laut' ? 'block' : 'none' }};">
                    <label for="nomor_kapal">Nomor Kapal</label>
                    <select id="nomor_kapal" class="form-select">
                        <option value="">Pilih Kapal</option>
                        <option value="Kapal 1">Kapal 1</option>
                        <option value="Kapal 2">Kapal 2</option>
                        <option value="Kapal 3">Kapal 3</option>
                    </select>
                    <input type="hidden" id="nomor_kendaraan_hidden" name="nomor_kendaraan"
                        value="{{ old('nomor_kendaraan') }}">
                    @error('nomor_kendaraan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="muatan">Jumlah Muatan</label>
                    <input type="text" class="form-control @error('muatan') is-invalid @enderror" id="muatan"
                        name="muatan" placeholder="Masukan Jumlah Muatan" value="{{ old('muatan') }}">
                    @error('muatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gambar">Unggah Gambar</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                        name="gambar" placeholder="Masukan Nama Kurir" value="{{ old('gambar') }}" multiple>
                    <small class="form-text text-muted">Tambahkan gambar flowmeter disini</small>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let armadaInput = document.querySelector("#armada");
            let nomorKendaraanField = document.querySelector("#field_nomor_kendaraan");
            let nomorKapalField = document.querySelector("#field_nomor_kapal");
            let nomorKendaraanInput = document.querySelector("#nomor_kendaraan");
            let nomorKapalSelect = document.querySelector("#nomor_kapal");
            let nomorKendaraanHidden = document.querySelector("#nomor_kendaraan_hidden");
    
            function toggleFields() {
                if (armadaInput.value === "Darat") {
                    nomorKendaraanField.style.display = "block";
                    nomorKapalField.style.display = "none";
                    nomorKendaraanHidden.value = nomorKendaraanInput.value;
                } else if (armadaInput.value === "Laut") {
                    nomorKendaraanField.style.display = "none";
                    nomorKapalField.style.display = "block";
                    nomorKendaraanHidden.value = nomorKapalSelect.value;
                }
            }
    
            // Event Listener untuk perubahan di dropdown kapal
            nomorKapalSelect.addEventListener("change", function () {
                nomorKendaraanHidden.value = this.value;
            });
    
            // Event Listener untuk perubahan di input nomor kendaraan
            nomorKendaraanInput.addEventListener("input", function () {
                nomorKendaraanHidden.value = this.value;
            });
    
            toggleFields();
        });
    </script>
    
@endsection
