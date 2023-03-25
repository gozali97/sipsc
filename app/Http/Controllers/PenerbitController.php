<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {

        $penerbit = Penerbit::all();

        return view('petugas.penerbit.index', compact('penerbit'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $request->validate([
                'penerbit' => 'required|max:255',
                'alamat' => 'required|max:255',
            ]);

            Penerbit::create([
                'nama_penerbit' => $request->penerbit,
                'alamat' => $request->alamat,
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('penerbit.index')->with('success', 'Data Penerbit berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error dengan alert
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        $category = Penerbit::where('id_penerbit', $id)->first();
        // dd($category);
        $category->nama_penerbit = $request->penerbit;
        $category->alamat = $request->alamat;
        $category->save();

        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil diupdate.');
    }

    public function destroy($id)
    {
        $category = Penerbit::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Penerbit tidak ditemukan.');
        }

        $category->delete();

        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil dihapus.');
    }
}
