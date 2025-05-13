<?php

namespace App\Http\Controllers;

use App\Models\kurir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class KurirController extends Controller
{
    public function index()
    {
        $kurir = kurir::with('user')->get();
        // dd($kurir);
        return view("admin.kurir.index", compact('kurir'));
        // return 'pepek';
    }

    public function create()
    {
        // $kurir = kurir::all();
        return view("admin.kurir.create");
        // return 'pepek';
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kurir' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'jenis_kurir' => 'required|string|max:50',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'nama_kurir.required' => 'Nama kurir wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'jenis_kurir.required' => 'Jenis kurir wajib dipilih.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        try {
            // Gunakan transaksi database
            DB::beginTransaction();

            // Simpan user terlebih dahulu
            $user = new User();
            $user->name = $request->nama_kurir;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->roles = 'kurir'; // Pastikan selalu "kurir"
            $user->save(); // Simpan user

            // Pastikan user berhasil dibuat sebelum menyimpan kurir
            if (!$user) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Gagal menyimpan data user.']);
            }

            // Simpan data kurir
            $kurir = new Kurir();
            $kurir->nama_kurir = $request->nama_kurir;
            $kurir->no_hp = $request->no_hp;
            $kurir->jenis_kurir = $request->jenis_kurir;
            $kurir->id_user = $user->id; // Ambil ID user yang baru dibuat
            $kurir->save(); // Simpan data kurir

            // Pastikan kurir berhasil disimpan
            if (!$kurir) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Gagal menyimpan data kurir.']);
            }

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect()->route('kurir')->with('success', 'Kurir berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        // return 'test';
        $kurir = kurir::with('user')->findOrFail($id);
        // dd($kurir);
        return view('admin.kurir.edit', compact('kurir'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kurir' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'jenis_kurir' => 'required|in:Darat,Laut',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8',
        ], [
            'nama_kurir.required' => 'Nama kurir wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'jenis_kurir.required' => 'Jenis kurir wajib dipilih.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        try {
            DB::beginTransaction();

            // Update data user
            $user = User::findOrFail($id);
            $user->name = $request->nama_kurir;
            $user->username = $request->username;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update data kurir yang berelasi dengan user
            $kurir = Kurir::where('id_user', $user->id)->firstOrFail();
            $kurir->nama_kurir = $request->nama_kurir;
            $kurir->no_hp = $request->no_hp;
            $kurir->jenis_kurir = $request->jenis_kurir;
            $kurir->save();

            DB::commit();

            return redirect()->route('kurir')->with('success', 'Data kurir berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }



    public function delete($id)
    {

        // dd($id);
        DB::beginTransaction();
        try {
            // Ambil data kurir beserta user yang berelasi
            $kurir = Kurir::findOrFail($id);
            $user = User::findOrFail($kurir->id_user); // Pastikan 'id_user' ada di tabel 'kurir'

            // Hapus kurir terlebih dahulu
            $kurir->delete();

            // Hapus user setelah kurir dihapus
            $user->delete();

            DB::commit();

            return redirect()->route('kurir')->with('success', 'Kurir berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kurir')->with('error', 'Gagal menghapus kurir.');
        }
    }
}
