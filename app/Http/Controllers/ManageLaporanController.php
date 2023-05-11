<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ManageLaporanController extends Controller
{
    public function index()
    {
        $data = Pengembalian::query()
            ->join('detail_pengembalian', 'detail_pengembalian.no_kembali', 'pengembalian.no_kembali')
            ->join('detail_peminjaman', 'detail_peminjaman.no_det_pinjaman', 'detail_pengembalian.no_det_pinjam')
            ->join('kondisis', 'kondisis.kd_kondisi', 'detail_pengembalian.kd_kondisi')
            ->join('users', 'users.id', 'pengembalian.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'pustakas.isbn', 'detail_peminjaman.tgl_pinjam', 'detail_pengembalian.tgl_kembali', 'kondisis.jenis_kondisi', 'detail_pengembalian.nominal_denda')
            ->get();

        return view('petugas.laporan.index', compact('data'));
    }

    public function print()
    {
        $data = Pengembalian::query()
            ->join('detail_pengembalian', 'detail_pengembalian.no_kembali', 'pengembalian.no_kembali')
            ->join('detail_peminjaman', 'detail_peminjaman.no_det_pinjaman', 'detail_pengembalian.no_det_pinjam')
            ->join('kondisis', 'kondisis.kd_kondisi', 'detail_pengembalian.kd_kondisi')
            ->join('users', 'users.id', 'pengembalian.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'pustakas.isbn', 'pengembalians.tgl_pinjam', 'pengembalians.tgl_kembali', 'kondisis.jenis_kondisi', 'pengembalians.nominal_denda')
            ->get();

        $pdf = Pdf::loadView('petugas.laporan.pdf', compact('data'));

        $pdf->setPaper('A4', 'portrait');


        return $pdf->download('laporan.pdf');
    }

    public function indexPinjam()
    {
        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'peminjaman.created_at as tgl_pinjam', 'detail_peminjaman.status')
            ->where('detail_peminjaman.status', 'Dipinjam')
            ->get();

        return view('petugas.laporan.indexPinjam', compact('data'));
    }

    public function printPinjam()
    {
        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'peminjaman.created_at as tgl_pinjam', 'detail_peminjaman.status')
            ->where('detail_peminjaman.status', 'Dipinjam')
            ->get();

        $pdf = Pdf::loadView('petugas.laporan.pdf-pinjam', compact('data'));

        $pdf->setPaper('A4', 'portrait');


        return $pdf->download('laporan-Peminjaman.pdf');
    }

    public function indexDenda()
    {
        $today = \Carbon\Carbon::now();
        $batasTelat = $today->subDays(16)->format('Y-m-d');

        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'detail_peminjaman.tgl_pinjam', 'detail_peminjaman.status')
            ->where('detail_peminjaman.status', 'Dipinjam')
            ->whereDate('detail_peminjaman.tgl_pinjam', '<=', $batasTelat)
            ->get();


        $data->each(function ($item) {
            $date = \Carbon\Carbon::now();
            $tgl_pinjam = $item->tgl_pinjam;

            $datetime1 = \Carbon\Carbon::parse($tgl_pinjam);
            $datetime2 = $date;

            $interval = $datetime1->diff($datetime2);
            $jumlah_hari_terlambat = $interval->days - 16;
            if ($jumlah_hari_terlambat < 0) {
                $jumlah_hari_terlambat = 0;
            }

            $nominal_denda = $jumlah_hari_terlambat * 2000;
            $item->jumlah_hari_terlambat = $jumlah_hari_terlambat;
            $item->nominal_denda = $nominal_denda;
        });

        return view('petugas.laporan.indexDenda', compact('data'));
    }

    public function printDenda()
    {
        $today = \Carbon\Carbon::now();
        $batasTelat = $today->subDays(16)->format('Y-m-d');

        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'detail_peminjaman.tgl_pinjam', 'detail_peminjaman.status')
            ->where('detail_peminjaman.status', 'Dipinjam')
            ->whereDate('detail_peminjaman.tgl_pinjam', '<=', $batasTelat)
            ->get();


        $data->each(function ($item) {
            $date = \Carbon\Carbon::now();
            $tgl_pinjam = $item->tgl_pinjam;

            $datetime1 = \Carbon\Carbon::parse($tgl_pinjam);
            $datetime2 = $date;

            $interval = $datetime1->diff($datetime2);
            $jumlah_hari_terlambat = $interval->days - 16;
            if ($jumlah_hari_terlambat < 0) {
                $jumlah_hari_terlambat = 0;
            }

            $nominal_denda = $jumlah_hari_terlambat * 2000;
            $item->jumlah_hari_terlambat = $jumlah_hari_terlambat;
            $item->nominal_denda = $nominal_denda;
        });

        $pdf = Pdf::loadView('petugas.laporan.pdf-denda', compact('data'));

        $pdf->setPaper('A4', 'portrait');


        return $pdf->download('laporan-Denda.pdf');
    }
}
