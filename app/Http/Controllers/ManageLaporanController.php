<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ManageLaporanController extends Controller
{
    public function index()
    {
        $data = Pengembalian::query()
        ->join('users', 'users.id', 'pengembalians.id_user')
        ->join('kondisis', 'kondisis.kd_kondisi', 'pengembalians.kd_kondisi')
        ->join('detail_peminjaman','detail_peminjaman.no_det_pinjaman', 'pengembalians.no_pinjam')
        ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
        ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'pustakas.isbn', 'detail_peminjaman.tgl_pinjam', 'pengembalians.tgl_kembali', 'kondisis.jenis_kondisi', 'pengembalians.nominal_denda')
        ->get();

        return view('petugas.laporan.index', compact('data'));
    }

    public function print(){
        $data = Pengembalian::query()
        ->join('users', 'users.id', 'pengembalians.id_user')
        ->join('kondisis', 'kondisis.kd_kondisi', 'pengembalians.kd_kondisi')
        ->join('detail_peminjaman','detail_peminjaman.no_det_pinjaman', 'pengembalians.no_pinjam')
        ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
        ->select('users.id', 'users.nama', 'users.kelas', 'pustakas.judul', 'pustakas.isbn', 'detail_peminjaman.tgl_pinjam', 'pengembalians.tgl_kembali', 'kondisis.jenis_kondisi', 'pengembalians.nominal_denda')
        ->get();

        $pdf = Pdf::loadView('petugas.laporan.pdf', compact('data'));

        $pdf->setPaper('A4', 'portrait');


        return $pdf->download('laporan.pdf');
    }
}
