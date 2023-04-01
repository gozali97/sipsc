<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pustaka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;

        $data = Peminjaman::query()
        ->join('users', 'users.id', 'peminjaman.id_user')
        ->join('pustakas', 'pustakas.id_pustaka', 'peminjaman.id_pustaka')
        ->select('peminjaman.no_pinjam', 'pustakas.judul','pustakas.deskripsi','pustakas.tahun_terbit', 'pustakas.gambar', 'pustakas.isbn', 'peminjaman.status')
        ->where('peminjaman.id_user', $id)
        ->get();

        return view('anggota.pinjam.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $existingPeminjamanCount = Peminjaman::where('id_user', $user_id)
                ->where('status', 1)
                ->count();

            if ($existingPeminjamanCount >= 2) {
                return redirect()->back()->with('error', 'Kamu tidak diperbolehkan meminjam lebih dari 2 buku.');
            }

            $existingPeminjaman = Peminjaman::where('id_user', $user_id)
                ->where('id_pustaka', $request->pustaka)
                ->where('status', 1)
                ->first();

            if ($existingPeminjaman) {
                return redirect()->back()->with('error', 'Maaf, kamu hanya diperbolehkan meminjam 1 buku yang sama.');
            }

            $pustaka = Pustaka::find($request->pustaka);

            if ($pustaka && $pustaka->jumlah > 0) {
                $peminjaman = Peminjaman::create([
                    'id_user' => $user_id,
                    'id_pustaka' => $pustaka->id_pustaka,
                    'status' => 1,
                    'jumlah' => 1,
                ]);

                $pustaka->jumlah -= 1;
                $pustaka->save();

                return redirect()->route('list.index')->with('success', 'Data Penerbit berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('error', 'Maaf, pustaka yang anda pilih tidak tersedia.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        $category = Peminjaman::where('id_penerbit', $id)->first();
        // dd($category);
        $category->nama_penerbit = $request->penerbit;
        $category->alamat = $request->alamat;
        $category->save();

        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil diupdate.');
    }

    public function destroy($id)
    {
        $category = Peminjaman::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Penerbit tidak ditemukan.');
        }

        $category->delete();

        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil dihapus.');
    }
}
