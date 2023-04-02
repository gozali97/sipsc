<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;

class ManagePengembalianController extends Controller
{
    public function index()
    {

        $data = Pengembalian::query()
        ->join('kondisis', 'kondisis.kd_kondisi', 'pengembalians.kd_kondisi')
        ->join('peminjaman', 'peminjaman.no_pinjam', 'pengembalians.no_pinjam')
        ->join('users', 'users.id', 'peminjaman.id_user')
        ->join('pustakas', 'pustakas.id_pustaka', 'peminjaman.id_pustaka')
        ->select('pengembalians.tgl_kembali','pengembalians.nominal_denda', 'kondisis.jenis_kondisi','pengembalians.jml_terlambat', 'pengembalians.kd_kondisi','peminjaman.no_pinjam','peminjaman.tgl_pinjam','peminjaman.id_user','users.nama', 'pustakas.id_pustaka', 'pustakas.judul','pustakas.deskripsi','pustakas.tahun_terbit', 'pustakas.gambar', 'pustakas.isbn', 'peminjaman.status')
        ->get();

        return view('petugas.pengembalian.index', compact('data'));
    }
}
