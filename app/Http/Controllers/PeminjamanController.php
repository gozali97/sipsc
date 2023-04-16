<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
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
        ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
        ->join('users', 'users.id', 'peminjaman.id_user')
        ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
        ->select('peminjaman.no_pinjam','detail_peminjaman.status as sts', 'pustakas.judul','pustakas.deskripsi','pustakas.tahun_terbit', 'pustakas.gambar', 'pustakas.isbn', 'peminjaman.status')
        ->where('peminjaman.id_user', $id)
        ->where('peminjaman.status', 1)
        ->get();
        // dd($data);

        return view('anggota.pinjam.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $existingPeminjamanCount = DetailPeminjaman::where('id_user', $user_id)
                ->where('status', 1)
                ->count();

            if ($existingPeminjamanCount >= 3) {
                return redirect()->back()->with('error', 'Kamu tidak diperbolehkan meminjam lebih dari 2 buku.');
            }

            $existingPeminjaman = DetailPeminjaman::where('id_user', $user_id)
                ->whereIn('id_pustaka', $request->pustaka) // Ubah menjadi whereIn untuk mencocokkan dengan array of IDs
                ->where('status', 1)
                ->first();

            if ($existingPeminjaman) {
                return redirect()->back()->with('error', 'Maaf, kamu hanya diperbolehkan meminjam 1 buku yang sama.');
            }

            $jumlahData = Peminjaman::count();

            if ($jumlahData > 0) {
                $nomorUrutan = $jumlahData + 1;
                $kode = 'P00' . $nomorUrutan;
            } else {
                $kode = 'P001';
            }

            $jumlah = count($request->pustaka);

            $pustaka = Pustaka::whereIn('id_pustaka', $request->pustaka)->get();

            if ($pustaka->count() === $jumlah) {
                $pinjam = new Peminjaman;
                $pinjam->no_pinjam = $kode;
                $pinjam->id_user = $request->id_user;
                $pinjam->status = 1;
                $pinjam->jumlah = $jumlah;
                if($pinjam->save()){

                    $pinjamDetail = [];
                    $nomor = 0;

                    $lastDetail = DetailPeminjaman::max('no_det_pinjaman');

                    if ($lastDetail) {
                        $nomor = intval(substr($lastDetail, 4));
                    } else {
                        $no_detail = 'PD001';
                    }

                    foreach($request->pustaka as $key => $pinjamDetails){
                        $nomor++;
                        $no_detail = 'PD' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
                        $detail = [
                            'no_det_pinjaman' => $no_detail,
                            'no_pinjam' => $pinjam->no_pinjam,
                            'id_pustaka' => $pinjamDetails,
                            'id_user' => $request->id_user,
                            'tgl_pinjam' => date('Y-m-d H:i:s'),
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                        $pinjamDetail[] = $detail;

                    }
                    DetailPeminjaman::insert($pinjamDetail);
                }

                $pustaka->each(function ($item) {
                    $item->jumlah -= 1;
                    $item->save();
                });

                return redirect()->route('list.index')->with('success', 'Pustaka berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('error', 'Maaf, pustaka yang anda pilih tidak tersedia.');
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pustaka.');
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $category = Peminjaman::where('id_penerbit', $id)->first();
    //     // dd($category);
    //     $category->nama_penerbit = $request->penerbit;
    //     $category->alamat = $request->alamat;
    //     $category->save();

    //     return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil diupdate.');
    // }

    // public function destroy($id)
    // {
    //     $category = Peminjaman::find($id);

    //     if (!$category) {
    //         return redirect()->back()->with('error', 'Penerbit tidak ditemukan.');
    //     }

    //     $category->delete();

    //     return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil dihapus.');
    // }
}
