<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Pustaka;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;

        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('peminjaman.no_pinjam', 'detail_peminjaman.status as sts', 'pustakas.judul', 'pustakas.deskripsi', 'pustakas.tahun_terbit', 'pustakas.gambar', 'pustakas.isbn', 'peminjaman.status')
            ->where('peminjaman.id_user', $id)
            ->where('peminjaman.status', 1)
            ->get();

        $detail = DetailPeminjaman::query()
        ->join('detail_pengembalian', 'detail_pengembalian.no_det_pinjam', 'detail_peminjaman.no_det_pinjaman')
        ->join('kondisis', 'kondisis.kd_kondisi', 'detail_pengembalian.kd_kondisi')
        ->whereIn('detail_peminjaman.no_pinjam', $data->pluck('no_pinjam'))
        ->get();

        $data = $data->map(function ($item) use ($detail) {
            $item->detail = collect($detail)->filter(function ($detailItem) use ($item) {
                return $detailItem['no_pinjam'] == $item->no_pinjam;
            })->values();
            return $item;
        });
        
        return view('anggota.pinjam.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            
            $existingPeminjamanCount = DetailPeminjaman::where('id_user', $user_id)
                ->where('status','<>', 'Dikembalikan')
                ->count();
                // dd($existingPeminjamanCount, $user_id);

            if ($existingPeminjamanCount >= 2) {
                return redirect()->back()->with('error', 'Kamu tidak diperbolehkan meminjam lebih dari 2 buku.');
            } elseif ($existingPeminjamanCount === 0 && count($request->pustaka) > 2) {
                return redirect()->back()->with('error', 'Kamu hanya diperbolehkan meminjam 2 buku sekaligus.');
            }elseif ($existingPeminjamanCount === 1 && count($request->pustaka) === 2) {
                return redirect()->back()->with('error', 'Kamu hanya diperbolehkan meminjam 1 buku jika sudah ada peminjaman aktif.');
            }

            $existingPeminjaman = DetailPeminjaman::where('id_user', $user_id)
                ->whereIn('id_pustaka', $request->pustaka)
                ->where('status', '<>', 'Dikembalikan')
                ->first();

            if ($existingPeminjaman) {
                return redirect()->back()->with('error', 'Maaf, kamu hanya diperbolehkan meminjam 1 buku yang sama.');
            }
            
            // $ready = Peminjaman::where('id_user', $user_id)->get();
            // $bukuBelumKembali = 0;

            // foreach ($ready as $r) {
            //      if ($r->jumlah == 1) {
            //         $bukuBelumKembali++;
            //     }
               
            // }
            
            // foreach ($ready as $p) {
            // if ($bukuBelumKembali >= 2) {
            //     return redirect()->back()->with('error', 'Kamu hanya diperbolehkan meminjam 2 buku.');
            // }
            
            
            //  if ($p->jumlah !== 0) {
            //         return redirect()->back()->with('error', 'Maaf, kamu masih belum mengembalikan buku.');
            //     }
            // }

            $jumlah = count($request->pustaka);

            $pustaka = Pustaka::whereIn('id_pustaka', $request->pustaka)->get();

            $notAvailable = $pustaka->filter(function ($item) {
                return $item->jumlah <= 0;
            });

            if ($notAvailable->isNotEmpty()) {
                $notAvailableTitles = $notAvailable->implode('judul', ', ');
                return redirect()->back()->with('error', 'Maaf, stok buku ' . $notAvailableTitles . ' tidak tersedia.');
            }

            if ($pustaka->count() === $jumlah) {
                DB::beginTransaction();

                $pinjam = new Peminjaman;
                $pinjam->id_user = $request->id_user;
                $pinjam->status = 1;
                $pinjam->jumlah = $jumlah;
                if ($pinjam->save()) {

                    $pinjamDetail = [];

                    foreach ($request->pustaka as $key => $pinjamDetails) {

                        $detail = [
                            'no_pinjam' => $pinjam->no_pinjam,
                            'id_pustaka' => $pinjamDetails,
                            'id_user' => $request->id_user,
                            'tgl_pinjam' => date('Y-m-d H:i:s'),
                            'status' => "Proses",
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
                DB::commit();
                return redirect()->back()->with('success', 'Peminjaman buku berhasil.');
            } else {
                throw new Exception('Ada pustaka yang tidak ditemukan.');
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal melakukan peminjaman buku. ' . $e->getMessage());
        }
    }


}
