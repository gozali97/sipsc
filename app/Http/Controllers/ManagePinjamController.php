<?php

namespace App\Http\Controllers;
use DateTime;

use App\Models\Kondisi;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pustaka;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManagePinjamController extends Controller
{
    public function index()
    {
        $kondisi = Kondisi::all();

        $data = Peminjaman::query()
        ->join('users', 'users.id', 'peminjaman.id_user')
        ->join('pustakas', 'pustakas.id_pustaka', 'peminjaman.id_pustaka')
        ->select('peminjaman.no_pinjam','peminjaman.id_user','users.nama', 'pustakas.id_pustaka', 'pustakas.judul','pustakas.deskripsi','pustakas.tahun_terbit', 'pustakas.gambar', 'pustakas.isbn', 'peminjaman.status')
        ->where('peminjaman.status', 1)
        ->get();

        return view('petugas.peminjaman.index', compact('data', 'kondisi'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'kondisi' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $date = \Carbon\Carbon::now();

            $peminjaman = Peminjaman::where('no_pinjam',$request->no_pinjam)->first();
            $tgl_pinjam = $peminjaman->created_at->format('Y-m-d');

            $datetime1 = new \DateTime($tgl_pinjam);
            $datetime2 = $date;
            $interval = $datetime1->diff($datetime2);
            $jumlah_hari_terlambat = $interval->days - 2; // kurangi 2 hari grace period
            if ($jumlah_hari_terlambat < 0) {
                $jumlah_hari_terlambat = 0;
            }
            $nominal_denda = $jumlah_hari_terlambat * 2000;

            $tgl_kembali = $date->format('Y-m-d H:i:s');

            $pengembalian = Pengembalian::create([
                'no_pinjam' => $request->no_pinjam,
                'id_user' => $request->id_user,
                'tgl_kembali' => $tgl_kembali,
                'nominal_denda' => $nominal_denda,
                'jml_terlambat' => $jumlah_hari_terlambat,
                'kd_kondisi' => $request->kondisi,
            ]);

             // Update status peminjaman menjadi 0
            $peminjaman->update([
                'status' => 0,
            ]);

            // Update jumlah buku pada pustaka
            $pustaka = Pustaka::where('id_pustaka', $request->id_pustaka)->first();
            $pustaka->update([
                'jumlah' => $pustaka->jumlah + 1,
            ]);

            return redirect()->route('listpinjam.index')->with('success', 'Data Peminjaman berhasil di kembalikan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat konfirmasi Pustaka.');
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
