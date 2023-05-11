<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\DetailPengembalian;
use DateTime;

use App\Models\Kondisi;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pustaka;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function view($id)
    {

        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->select('peminjaman.*', 'detail_peminjaman.status as statusPinjam', 'detail_peminjaman.no_det_pinjaman', 'detail_peminjaman.tgl_pinjam', 'users.nama', 'users.kelas', 'pustakas.*')
            ->where('peminjaman.no_pinjam', $id)
            ->where('detail_peminjaman.status', '<>', "Dikembalikan")
            ->get();

        $kondisi = Kondisi::all();

        return view('petugas.peminjaman.view', compact('data', 'kondisi'));
    }

    public function accPinjam($id)
    {
        try {
            $data = DetailPeminjaman::where('no_det_pinjaman', $id)->first();

            $data->status = "Dipinjam";
            $data->save();

            return response()->json(['status' => 'success', 'message' => 'Buku sudah dibawa oleh siswa.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat konfirmasi Pustaka.']);
        }
    }

    public function sync()
    {
        try {
            $detailPeminjaman = DetailPeminjaman::query()
                ->where('status', '=', 'Proses')
                ->whereDate('tgl_pinjam', '<=', Carbon::now()->subDays(1))
                ->get();
            // dd($detailPeminjaman);

            foreach ($detailPeminjaman as $detail) {

                $pustaka = Pustaka::where('id_pustaka', $detail->id_pustaka)->first();
                $pustaka->jumlah += 1;
                $pustaka->save();

                // Menghapus data peminjaman dan detail peminjaman
                $peminjaman = Peminjaman::where('no_pinjam', $detail->no_pinjam)->first();
                $peminjaman->detailPeminjaman()->delete();
                $peminjaman->delete();
            }

            return response()->json(['status' => 'success', 'message' => 'Data Peminjaman berhasil di sinkronisasi.']);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat sinkronisasi.', 'error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'kondisi' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $date = \Carbon\Carbon::now();

            $peminjaman = DetailPeminjaman::query()
                ->where('no_det_pinjaman', $request->pinjam)
                ->first();

            $tgl_pinjam = $peminjaman->tgl_pinjam;

            $datetime1 = new \DateTime($tgl_pinjam);
            $datetime2 = $date;
            $interval = $datetime1->diff($datetime2);
            $jumlah_hari_terlambat = $interval->days - 16;
            if ($jumlah_hari_terlambat < 0) {
                $jumlah_hari_terlambat = 0;
            }
            $nominal_denda = $jumlah_hari_terlambat * 2000;

            $tgl_kembali = $date->format('Y-m-d H:i:s');


            $pengembalian = new Pengembalian;
            $pengembalian->id_user = $peminjaman->id_user;
            $pengembalian->tgl_kembali = $tgl_kembali;
            $pengembalian->jumlah = 1;

            if ($pengembalian->save()) {

                $detailPengembalian = new DetailPengembalian;
                $detailPengembalian->no_kembali = $pengembalian->no_kembali;
                $detailPengembalian->no_det_pinjam = $request->pinjam;
                $detailPengembalian->nominal_denda = $nominal_denda;
                $detailPengembalian->jml_terlambat = $jumlah_hari_terlambat;
                $detailPengembalian->kd_kondisi = $request->kondisi;
                $detailPengembalian->tgl_pinjam = $peminjaman->tgl_pinjam;
                $detailPengembalian->tgl_kembali = $tgl_kembali;
                $detailPengembalian->save();
            }


            $peminjaman->update([
                'status' => "Dikembalikan",
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $pinjam = Peminjaman::query()->where('no_pinjam', $peminjaman->no_pinjam)->first();
            $pinjam->update([
                'jumlah' => $pinjam->jumlah - 1,
            ]);

            if ($pinjam->jumlah == 0) {
                $pinjam->status = 0;
            } else {
                $pinjam->save();
            }

            $pustaka = Pustaka::where('id_pustaka', $request->id_pustaka)->first();
            $pustaka->update([
                'jumlah' => $pustaka->jumlah + 1,
            ]);
            DB::commit();
            return redirect()->route('listpinjam.index')->with('success', 'Data Peminjaman berhasil di kembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat konfirmasi Pustaka.' . $e->getMessage());
        }
    }

    public function storeAll(Request $request)
    {
        try {

            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'kondisi' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $date = \Carbon\Carbon::now();

            $detailPeminjaman = Peminjaman::query()
                ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
                ->where('peminjaman.no_pinjam', $request->no_pinjam)
                ->get();

            $datetime2 = $date;

            $detailArray = [];

            foreach ($detailPeminjaman as $pinjam) {
                $tgl_pinjam = $pinjam->tgl_pinjam;

                $datetime1 = new \DateTime($tgl_pinjam);
                $interval = $datetime1->diff($datetime2);
                $jumlah_hari_terlambat = $interval->days - 16;
                $jumlah_hari_terlambat = $jumlah_hari_terlambat < 0 ? 0 : $jumlah_hari_terlambat;
                $nominal_denda = $jumlah_hari_terlambat * 2000;

                $detailArray[] = [
                    'jumlah_hari_terlambat' => $jumlah_hari_terlambat,
                    'nominal_denda' => $nominal_denda
                ];
            }

            $tgl_kembali = $date->format('Y-m-d H:i:s');

            $pengembalian = new Pengembalian;
            $pengembalian->id_user = $detailPeminjaman[0]->id_user;
            $pengembalian->tgl_kembali = $tgl_kembali;
            $pengembalian->jumlah = 2;

            if ($pengembalian->save()) {
                $pinjams = $request->input('pinjam');
                $id_pustakas = $request->input('id_pustaka');
                $kondisis = $request->input('kondisi');

                foreach ($pinjams as $index => $pinjam) {
                    $detailPengembalian = new DetailPengembalian;
                    $detailPengembalian->no_kembali = $pengembalian->no_kembali;
                    $detailPengembalian->no_det_pinjam = $pinjam;
                    $detailPengembalian->nominal_denda = $detailArray[$index]['nominal_denda'];
                    $detailPengembalian->jml_terlambat = $detailArray[$index]['jumlah_hari_terlambat'];
                    $detailPengembalian->kd_kondisi = $kondisis[$index];
                    $detailPengembalian->tgl_pinjam = $tgl_pinjam;
                    $detailPengembalian->tgl_kembali = $tgl_kembali;
                    $detailPengembalian->save();

                    $pustaka = Pustaka::where('id_pustaka', $id_pustakas[$index])->first();
                    $pustaka->update([
                        'jumlah' => $pustaka->jumlah + 1,
                    ]);
                }
            }

            foreach ($detailPeminjaman as $peminjaman) {
                $detail = DetailPeminjaman::query()->where('no_det_pinjaman', $peminjaman->no_det_pinjaman)->first();
                $detail->update([
                    'status' => "Dikembalikan",
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $pinjam = Peminjaman::query()->where('no_pinjam', $detailPeminjaman[0]->no_pinjam)->first();
            $pinjam->update([
                'jumlah' => $pinjam->jumlah - 2,
                'status' => 0,
            ]);

            DB::commit();

            return redirect()->route('listpinjam.index')->with('success', 'Data Peminjaman berhasil di kembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat konfirmasi Pustaka.' . $e->getMessage());
        }
    }

    public function insert(Request $request)
    {
        try {
            $user_id = $request->id_user;

            $existingPeminjamanCount = DetailPeminjaman::where('id_user', $user_id)
                ->where('status', '<>', 'Dikembalikan')
                ->count();

            if ($existingPeminjamanCount >= 2) {
                return redirect()->back()->with('error', 'Kamu tidak diperbolehkan meminjam lebih dari 2 buku.');
            } elseif ($existingPeminjamanCount === 0 && count($request->pustaka) > 2) {
                return redirect()->back()->with('error', 'Kamu hanya diperbolehkan meminjam 2 buku sekaligus.');
            }

            $existingPeminjaman = DetailPeminjaman::where('id_user', $user_id)
                ->whereIn('id_pustaka', $request->pustaka)
                ->where('status', '<>', 'Dikembalikan')
                ->first();

            if ($existingPeminjaman) {
                return redirect()->back()->with('error', 'Maaf, kamu hanya diperbolehkan meminjam 1 buku yang sama.');
            }


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
                return redirect()->route('listpinjam.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
            } else {
                throw new Exception('Ada pustaka yang tidak ditemukan.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pustaka.' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Peminjaman::where('no_pinjam', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Peminjaman tidak ditemukan.');
        }

        $detail = DetailPeminjaman::where('no_pinjam', $id)->get();
        $detail->each->delete();

        $data->delete();


        return redirect()->route('listpinjam.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
