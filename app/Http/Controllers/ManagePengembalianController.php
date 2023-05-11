<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;

class ManagePengembalianController extends Controller
{
    public function index()
    {

        $data = Pengembalian::query()
            ->join('users', 'users.id', 'pengembalian.id_user')
            ->get();

        return view('petugas.pengembalian.index', compact('data'));
    }

    public function detail($id)
    {

        $data = Pengembalian::query()
            ->join('detail_pengembalian', 'detail_pengembalian.no_kembali', 'pengembalian.no_kembali')
            ->join('detail_peminjaman', 'detail_peminjaman.no_det_pinjaman', 'detail_pengembalian.no_det_pinjam')
            ->join('kondisis', 'kondisis.kd_kondisi', 'detail_pengembalian.kd_kondisi')
            ->join('users', 'users.id', 'pengembalian.id_user')
            ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
            ->where('pengembalian.no_kembali', $id)
            ->get();


        return view('petugas.pengembalian.view', compact('data'));
    }
}
