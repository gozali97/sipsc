<?php

namespace App\Http\Controllers;
use DateTime;

use App\Models\Kondisi;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pustaka;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManagePinjamController extends Controller
{
    public function index()
    {
        $kondisi = Kondisi::all();
        $anggota = User::where('role_id', 3)->get();
        $pustaka = Pustaka::all();

        $data = Peminjaman::query()
        ->join('users', 'users.id', 'peminjaman.id_user')
        ->join('pustakas', 'pustakas.id_pustaka', 'peminjaman.id_pustaka')
        ->select('peminjaman.no_pinjam','peminjaman.id_user','users.nama', 'pustakas.id_pustaka', 'pustakas.judul','pustakas.deskripsi','pustakas.tahun_terbit', 'pustakas.gambar', 'pustakas.isbn', 'peminjaman.tgl_pinjam', 'peminjaman.status')
        ->where('peminjaman.status', 1)
        ->get();

        return view('petugas.peminjaman.index', compact('data', 'kondisi', 'anggota', 'pustaka'));
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
            $tgl_pinjam = $peminjaman->tgl_pinjam;

            $datetime1 = new \DateTime($tgl_pinjam);
            $datetime2 = $date;
            $interval = $datetime1->diff($datetime2);
            $jumlah_hari_terlambat = $interval->days - 16; // kurangi 2 hari grace period
            if ($jumlah_hari_terlambat < 0) {
                $jumlah_hari_terlambat = 0;
            }
            $nominal_denda = $jumlah_hari_terlambat * 500;

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

    public function insert(Request $request)
    {
        // dd($request->all());
        try {
            $user_id = $request->id_user;
            $existingPeminjamanCount = Peminjaman::where('id_user', $user_id)
                ->where('status', 1)
                ->count();

            if ($existingPeminjamanCount >= 2) {
                return redirect()->back()->with('error', 'Maaf, tidak diperbolehkan meminjam lebih dari 2 buku.');
            }

            $existingPeminjaman = Peminjaman::where('id_user', $user_id)
                ->where('id_pustaka', $request->pustaka)
                ->where('status', 1)
                ->first();

            if ($existingPeminjaman) {
                return redirect()->back()->with('error', 'Maaf, hanya diperbolehkan meminjam 1 buku yang sama.');
            }

            $pustaka = Pustaka::find($request->pustaka);

            if ($pustaka && $pustaka->jumlah > 0) {
                $peminjaman = Peminjaman::create([
                    'id_user' => $user_id,
                    'id_pustaka' => $request->pustaka,
                    'tgl_pinjam' => date('Y-m-d H:i:s'),
                    'status' => 1,
                    'jumlah' => 1,
                ]);

                $pustaka->jumlah -= 1;
                $pustaka->save();

                return redirect()->route('listpinjam.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('error', 'Maaf, pustaka yang anda pilih tidak tersedia.');
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pustaka.');
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
