<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\Dokumentasi;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InputDataController extends Controller
{
    // Menampilkan semua data pengiriman
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Cari data kurir berdasarkan ID user yang login
        $kurir = \App\Models\Kurir::where('id_user', $user->id)->first();

        // Jika kurir tidak ditemukan, tampilkan pesan error
        if (!$kurir) {
            return redirect()->back()->withErrors(['error' => 'Anda belum terdaftar sebagai kurir.']);
        }

        // Ambil pengiriman berdasarkan id_kurir yang sesuai dengan user login
        $pengiriman = Pengiriman::where('id_kurir', $kurir->id_kurir)->get();

        return view('user.index', compact('pengiriman'));
    }

    public function create()
    {

        return view('user.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Ambil user yang sedang login
        $user = Auth::user();
        $kurir = \App\Models\Kurir::where('id_user', $user->id)->first();

        if (!$kurir) {
            return redirect()->back()->withErrors(['error' => 'Kurir tidak ditemukan untuk user ini.']);
        }

        // Validasi input
        $rules = [
            'tujuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'armada' => 'required|string',
            'muatan' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Jika armada adalah "Darat", nomor_kendaraan wajib diisi
        if ($request->armada === 'Darat') {
            $rules['nomor_kendaraan'] = 'required|string|max:50';
        }

        $messages = [
            'tujuan.required' => 'Tujuan pengiriman wajib diisi.',
            'tanggal.required' => 'Tanggal pengiriman wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'waktu.required' => 'Waktu pengiriman wajib diisi.',
            'armada.required' => 'Silakan pilih jenis armada.',
            'muatan.required' => 'Jumlah muatan wajib diisi.',
            'muatan.numeric' => 'Jumlah muatan harus berupa angka.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, svg.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'nomor_kendaraan.required' => 'Nomor kendaraan wajib diisi untuk armada darat.',
            'nomor_kendaraan.string' => 'Nomor kendaraan harus berupa teks.',
            'nomor_kendaraan.max' => 'Nomor kendaraan maksimal 50 karakter.',
        ];

        $request->validate($rules, $messages);

        // Simpan data ke database
        $pengiriman = new Pengiriman();
        $pengiriman->id_kurir = $kurir->id_kurir;
        $pengiriman->tujuan = $request->tujuan;
        $pengiriman->tanggal = $request->tanggal;
        $pengiriman->waktu = $request->waktu;
        $pengiriman->armada = $request->armada;
        $pengiriman->nomor_kendaraan = $request->nomor_kendaraan;
        $pengiriman->muatan = $request->muatan;
        $pengiriman->save();

        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('dokumentasi', 'public');

            $dokumentasi = new Dokumentasi();
            $dokumentasi->id_pengiriman = $pengiriman->id_pengiriman;
            $dokumentasi->path = $path;
            $dokumentasi->save();
        }

        return redirect()->route('rekap.data')->with('success', 'Data berhasil disimpan!');
    }







    // Menampilkan halaman edit
    public function edit($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        return view('user.edit', compact('pengiriman'));
    }

    // Memperbarui data
    public function update(Request $request, $id)
    {
        $request->validate([
            'tujuan' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'armada' => 'required',
            'nomor_kendaraan' => 'required',
            'muatan' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pengiriman = Pengiriman::findOrFail($id);
        $data = $request->except('gambar');
        $pengiriman->update($data);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('dokumentasi', 'public');
            Dokumentasi::create([
                'id_pengiriman' => $pengiriman->id,
                'path' => $path,
            ]);
        }

        return redirect()->route('index.data')->with('success', 'Data berhasil diperbarui!');
    }

    // Menghapus data
    public function destroy($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        // Hapus dokumentasi terkait
        Dokumentasi::where('id_pengiriman', $id)->delete();

        $pengiriman->delete();
        return redirect()->route('index.data')->with('success', 'Data berhasil dihapus!');
    }
}
