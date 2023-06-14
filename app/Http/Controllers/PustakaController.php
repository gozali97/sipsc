<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Pustaka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PustakaController extends Controller
{
    public function index()
    {

        $pustaka = Pustaka::query()
            ->select('pustakas.id_pustaka', 'pustakas.judul', 'pustakas.jumlah', 'pustakas.isbn', 'pustakas.id_kategori', 'pustakas.id_pengarang', 'pustakas.id_penerbit', 'pustakas.tahun_terbit', 'pustakas.status', 'pustakas.gambar', 'kategoris.kategori', 'pengarangs.nama_pengarang as pengarang', 'penerbits.nama_penerbit as penerbit')
            ->join('kategoris', 'kategoris.id_kategori', 'pustakas.id_kategori')
            ->join('pengarangs', 'pengarangs.id_pengarang', 'pustakas.id_pengarang')
            ->join('penerbits', 'penerbits.id_penerbit', 'pustakas.id_penerbit')
            //->where('status', 1)
            ->get();

        $kategori = Kategori::all();
        $pengarang = Pengarang::all();
        $penerbit = Penerbit::all();

        return view('petugas.pustaka.index', compact('pustaka', 'kategori', 'pengarang', 'penerbit'));
    }

    

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'judul' => 'required|max:255',
                'jumlah' => 'required',
                'terbit' => 'required',
                'deskripsi' => 'required',
                'isbn' => 'required',
                'status' => 'required',
                'gambar' => 'required|image',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $gambar  = time() . 'pustaka' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);



            Pustaka::create([
                'judul' => $request->judul,
                'id_kategori' => $request->kategori,
                'id_pengarang' => $request->pengarang,
                'id_penerbit' => $request->penerbit,
                'jumlah' => $request->jumlah,
                'tahun_terbit' => $request->terbit,
                'isbn' => $request->isbn,
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambar,
                'status' => $request->status,
            ]);

            //
            return redirect()->route('pustaka.index')->with('success', 'Data Pustaka berhasil ditambahkan.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pustaka: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        $data = Pustaka::find($id);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $data->gambar))) {
                unlink(public_path('assets/img/' . $data->gambar));
            }

            // Simpan gambar baru
            $gambar = time() . 'pustaka' . '.' . $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);
            $data->gambar = $gambar;
        }

        $data->judul = $request->judul;
        $data->id_kategori = $request->kategori;
        $data->id_pengarang = $request->pengarang;
        $data->id_penerbit = $request->penerbit;
        $data->jumlah = $request->jumlah;
        $data->tahun_terbit = $request->terbit;
        $data->isbn = $request->isbn;
        $data->deskripsi = $request->deskripsi;
        $data->status = $request->status;
        $data->save();

        if ($data->save()) {
            return redirect()->route('pustaka.index')->with('success', 'Data Pustaka berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate pustaka');
        }
    }

    public function destroy($id)
    {
        $pustaka = Pustaka::find($id);
        // dd($pustaka);

        if (!$pustaka) {
            return redirect()->back()->with('error', 'Data Pustaka tidak ditemukan.');
        }

        // Hapus gambar dari server
        $gambarPath = public_path('assets/img/' . $pustaka->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        $pustaka->delete();

        return redirect()->route('pustaka.index')->with('success', 'Pustaka berhasil dihapus.');
    }
}
