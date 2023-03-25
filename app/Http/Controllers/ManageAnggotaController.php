<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManageAnggotaController extends Controller
{
    public function index()
    {

        $anggota = User::where('role_id', 3)->get();

        return view('petugas.anggota.index', compact('anggota'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $request->validate([
                'pengarang' => 'required|max:255',
            ]);

            User::create([
                'nama_pengarang' => $request->pengarang,
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('pengarang.index')->with('success', 'Data Pengarang berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error dengan alert
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        $category = User::where('id_pengarang', $id)->first();
        // dd($category);
        $category->nama_pengarang = $request->pengarang;
        $category->save();

        return redirect()->route('pengarang.index')->with('success', 'Pengarang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $category = User::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Pengarang tidak ditemukan.');
        }

        $category->delete();

        return redirect()->route('pengarang.index')->with('success', 'Pengarang berhasil dihapus.');
    }
}
