<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
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
        $anggota = User::where('role_id', 3)->get();
        $pustaka = Pustaka::all();

        $data = Peminjaman::query()
        ->join('users', 'users.id', 'peminjaman.id_user')
        ->where('peminjaman.jumlah', '<>', 0)
        ->get();

        $kondisi = Kondisi::all();

        return view('petugas.peminjaman.index', compact('data', 'anggota', 'pustaka'));
    }

    public function view($id){

        $data = Peminjaman::query()
        ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
        ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
        ->join('users', 'users.id', 'peminjaman.id_user')
        ->select('peminjaman.*', 'detail_peminjaman.*', 'users.nama','users.kelas', 'pustakas.*')
        ->where('peminjaman.no_pinjam',$id)
        ->where('detail_peminjaman.status', 1)
        ->get();

        $kondisi = Kondisi::all();

        return view('petugas.peminjaman.view', compact('data', 'kondisi'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'kondisi' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $date = \Carbon\Carbon::now();

            $peminjaman = DetailPeminjaman::query()
            ->where('no_det_pinjaman',$request->pinjam)
            ->first();

            $tgl_pinjam = $peminjaman->tgl_pinjam;

            $datetime1 = new \DateTime($tgl_pinjam);
            $datetime2 = $date;
            $interval = $datetime1->diff($datetime2);
            $jumlah_hari_terlambat = $interval->days - 16; // kurangi 2 hari grace period
            if ($jumlah_hari_terlambat < 0) {
                $jumlah_hari_terlambat = 0;
            }
            $nominal_denda = $jumlah_hari_terlambat * 2000;

            $tgl_kembali = $date->format('Y-m-d H:i:s');

            $jumlahData = Pengembalian::count();

            if ($jumlahData > 0) {
                $nomorUrutan = $jumlahData + 1;
                $kode = 'PK00' . $nomorUrutan;
            } else {
                $kode = 'PK001';
            }

            $pengembalian = Pengembalian::create([
                'no_kembali' => $kode,
                'no_pinjam' => $request->pinjam,
                'id_user' => $peminjaman->id_user,
                'tgl_kembali' => $tgl_kembali,
                'nominal_denda' => $nominal_denda,
                'jml_terlambat' => $jumlah_hari_terlambat,
                'kd_kondisi' => $request->kondisi,
            ]);

             // Update status peminjaman menjadi 0
            $peminjaman->update([
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $pinjam = Peminjaman::query()->where('no_pinjam', $peminjaman->no_pinjam)->first();
            $pinjam->update([
                'jumlah' => $pinjam->jumlah - 1,
            ]);
            // if ($pinjam->jumlah > 0) {
            //     $pinjam->update([
            //         'jumlah' => max(0, $pinjam->jumlah - 1),
            //     ]);
            // }

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
        try {
            // dd($request->all());
            $user_id = $request->id_user;
            $existingPeminjamanCount = DetailPeminjaman::where('id_user', $user_id)
                ->where('status', 1)
                ->count();

            if ($existingPeminjamanCount >= 2) {
                return redirect()->back()->with('error', 'Tidak diperbolehkan meminjamkan lebih dari 2 buku.');
            }

            $existingPeminjaman = DetailPeminjaman::where('id_user', $user_id)
                ->whereIn('id_pustaka', $request->pustaka)
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
