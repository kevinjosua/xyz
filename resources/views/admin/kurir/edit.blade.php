@extends('layouts.main')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h3>Form Edit Kurir</h3>
        <div class="card p-5">
            <form method="POST" action="{{ route('kurir.update', $kurir->user->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_kurir">Nama Kurir</label>
                    <input type="text" name="nama_kurir" class="form-control"
                        value="{{ old('nama_kurir', $kurir->user->name) }}">
                    @error('nama_kurir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_hp">Nomor HP Kurir</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $kurir->no_hp) }}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jenis_kurir">Jenis Kurir</label>
                    <select name="jenis_kurir" class="form-select">
                        <option value="Darat" {{ old('jenis_kurir', $kurir->jenis_kurir) == 'Darat' ? 'selected' : '' }}>
                            Darat</option>
                        <option value="Laut" {{ old('jenis_kurir', $kurir->jenis_kurir) == 'Laut' ? 'selected' : '' }}>
                            Laut
                        </option>
                    </select>
                    @error('jenis_kurir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="form-group">
                    <label for="username">Username Kurir</label>
                    <input type="text" name="username" class="form-control"
                        value="{{ old('username', $kurir->user->username) }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Kosongkan jika tidak ingin mengubah password">
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
