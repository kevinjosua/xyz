@extends('layouts.main')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h3>Form Tambah Kurir</h3>
        <div class="card p-5">
            <form method="POST" action="{{ route('kurir.store') }}">
                @csrf
                <div class="form-group">
                    <label for="nama_kurir">Nama Kurir</label>
                    <input type="text" class="form-control @error('nama_kurir') is-invalid @enderror" id="nama_kurir"
                        name="nama_kurir" placeholder="Masukan Nama Kurir" value="{{ old('nama_kurir') }}">
                    @error('nama_kurir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_hp">Nomor HP Kurir</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                        name="no_hp" placeholder="Masukan Nomor HP Kurir" value="{{ old('no_hp') }}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jenis_kurir">Jenis Kurir</label>
                    <select name="jenis_kurir" id="jenis_kurir"
                        class="form-select @error('jenis_kurir') is-invalid @enderror">
                        <option value="">Pilih Jenis Kurir</option>
                        <option value="Darat" {{ old('jenis_kurir') == 'Darat' ? 'selected' : '' }}>Darat</option>
                        <option value="Laut" {{ old('jenis_kurir') == 'Laut' ? 'selected' : '' }}>Laut</option>
                    </select>
                    @error('jenis_kurir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="form-group">
                    <label for="username">Username Kurir</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        placeholder="Masukan Username" name="username" value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        placeholder="Masukan Password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
