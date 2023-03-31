<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pustaka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnggotaBukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->kategori;
        $pustaka = Pustaka::query()->join('kategoris', 'kategoris.id_kategori', 'pustakas.id_kategori');

        $kategori = Kategori::all();

        if (!empty($search)) {
            $pustaka = $pustaka->where('pustakas.id_kategori', $search);
        }

        $pustaka = $pustaka->paginate(12);

        return view('anggota.buku.index', compact('pustaka', 'kategori'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'email' => 'required|max:255',
                'no_hp' => 'required|numeric',
                'alamat' => 'required|max:255',
                'gambar' => 'required|image',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $gambar  = time() . 'profil' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);

            Pustaka::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'gambar' => $gambar,
                'role_id' => 3,
            ]);

            // Redirect ke halaman index kategori dengan pesan sukses
            return redirect()->route('users.index')->with('success', 'Data Pengarang berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data anggota.');
        }
    }

    public function update(Request $request, $id)
    {

        $data = User::find($id);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $data->gambar))) {
                unlink(public_path('assets/img/' . $data->gambar));
            }

            // Simpan gambar baru
            $gambar = time() . 'profil' . '.' . $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);
            $data->gambar = $gambar;
        }

        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->alamat = $request->alamat;
        $data->save();

        if ($data->save()) {
            return redirect()->route('users.index')->with('success', 'Data Anggota berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate anggota' );
        }
    }

    public function resetPassword(Request $request, $id)
        {
            $anggota = User::find($id);

            if (!$anggota) {
                return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
            }

            $anggota->password = Hash::make($request->password);
            $anggota->save();

            return redirect()->back()->with('success', 'Password anggota berhasil direset.');
        }

        public function destroy($id)
        {
            $anggota = User::find($id);

            if (!$anggota) {
                return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
            }

            // Hapus gambar dari server
            $gambarPath = public_path('assets/img/' . $anggota->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }

            $anggota->delete();

            return redirect()->route('users.index')->with('success', 'Anggota berhasil dihapus.');
        }
}
