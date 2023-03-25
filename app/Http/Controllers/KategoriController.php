<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {

        $kategori = Kategori::all();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $request->validate([
                'kategori' => 'required|max:255',
            ]);

            Kategori::create([
                'kategori' => $request->kategori,
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan error dengan alert
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        $category = Kategori::where('id_kategori', $id)->first();
        // dd($category);
        $category->kategori = $request->kategori;
        $category->save();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
{
    $category = Kategori::find($id);

    if (!$category) {
        return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
    }

    $category->delete();

    return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
}
}
