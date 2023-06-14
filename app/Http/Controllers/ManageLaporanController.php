<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pustaka;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

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
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'pustakas.isbn', 'detail_peminjaman.tgl_pinjam', 'detail_pengembalian.tgl_pinjam', 'detail_pengembalian.tgl_kembali', 'kondisis.jenis_kondisi', 'detail_pengembalian.nominal_denda')
            ->get();

        return view('petugas.laporan.index', compact('data'));
    }

    public function printByMonth(Request $request)
    {
        $start = Carbon::parse($request->stat_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');
        


        $data = Pengembalian::query()
            ->join('detail_pengembalian', 'detail_pengembalian.no_kembali', 'pengembalian.no_kembali')
            ->join('detail_peminjaman', 'detail_peminjaman.no_det_pinjaman', 'detail_pengembalian.no_det_pinjam')
            ->join('kondisis', 'kondisis.kd_kondisi', 'detail_pengembalian.kd_kondisi')
            ->join('users', 'users.id', 'pengembalian.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'pustakas.isbn', 'detail_pengembalian.tgl_pinjam', 'detail_pengembalian.tgl_kembali', 'kondisis.jenis_kondisi', 'detail_pengembalian.nominal_denda')
            ->whereBetween('detail_pengembalian.tgl_kembali', [$start, $end])
            ->get();

        

        $pdf = Pdf::loadView('petugas.laporan.pdf', compact('data', 'start', 'end'));

        $pdf->setPaper('A4', 'portrait');

        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-Transaksi.pdf"'
        ]);
    }

    public function indexPustaka()
    {
        $data = Pustaka::query()
            ->join('kategoris', 'kategoris.id_kategori', 'pustakas.id_kategori')
            ->join('pengarangs', 'pengarangs.id_pengarang', 'pustakas.id_pengarang')
            ->join('penerbits', 'penerbits.id_penerbit', 'pustakas.id_penerbit')
            ->select('pustakas.*', 'kategoris.kategori', 'pengarangs.nama_pengarang', 'penerbits.nama_penerbit')
            ->get();

        return view('petugas.laporan.indexPustaka', compact('data'));
    }

    public function printPustaka()
    {

        $data = Pustaka::query()
            ->join('kategoris', 'kategoris.id_kategori', 'pustakas.id_kategori')
            ->join('pengarangs', 'pengarangs.id_pengarang', 'pustakas.id_pengarang')
            ->join('penerbits', 'penerbits.id_penerbit', 'pustakas.id_penerbit')
            ->select('pustakas.*', 'kategoris.kategori', 'pengarangs.nama_pengarang', 'penerbits.nama_penerbit')
            ->get();

        $pdf = Pdf::loadView('petugas.laporan.pdf-pustaka', compact('data'));

        $pdf->setPaper('A4', 'portrait');


        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-Pustaka.pdf"'
        ]);
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

    public function printPinjam(Request $request)
    {
        $start = Carbon::parse($request->stat_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');

        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'peminjaman.created_at as tgl_pinjam', 'detail_peminjaman.status')
            ->where('detail_peminjaman.status', 'Dipinjam')
            ->whereBetween('detail_peminjaman.tgl_pinjam', [$start, $end])
            ->get();
        
        $pdf = Pdf::loadView('petugas.laporan.pdf-pinjam', compact('data', 'start', 'end'));

        $pdf->setPaper('A4', 'portrait');

        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-Peminjaman.pdf"'
        ]);
    
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

            $nominal_denda = $jumlah_hari_terlambat * 500;
            $item->jumlah_hari_terlambat = $jumlah_hari_terlambat;
            $item->nominal_denda = $nominal_denda;
        });

        return view('petugas.laporan.indexDenda', compact('data'));
    }

    public function printDenda(Request $request)
    {
        $today = \Carbon\Carbon::now();
        $batasTelat = $today->subDays(16)->format('Y-m-d');

        $start = Carbon::parse($request->stat_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');

        $data = Peminjaman::query()
            ->join('detail_peminjaman', 'detail_peminjaman.no_pinjam', 'peminjaman.no_pinjam')
            ->join('users', 'users.id', 'peminjaman.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'detail_peminjaman.tgl_pinjam', 'detail_peminjaman.status')
            ->where('detail_peminjaman.status', 'Dipinjam')
            ->whereDate('detail_peminjaman.tgl_pinjam', '<=', $batasTelat)
            ->whereBetween('detail_peminjaman.tgl_pinjam', [$start, $end])
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

            $nominal_denda = $jumlah_hari_terlambat * 500;
            $item->jumlah_hari_terlambat = $jumlah_hari_terlambat;
            $item->nominal_denda = $nominal_denda;
        });

        $pdf = Pdf::loadView('petugas.laporan.pdf-Denda', compact('data', 'start', 'end'));

        $pdf->setPaper('A4', 'portrait');


        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-Denda.pdf"'
        ]);
    }
}
