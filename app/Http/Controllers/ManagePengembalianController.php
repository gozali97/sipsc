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
        ->join('detail_peminjaman', 'detail_peminjaman.no_det_pinjaman', 'pengembalians.no_pinjam')
        ->join('users', 'users.id', 'detail_peminjaman.id_user')
        ->join('pustakas', 'pustakas.id_pustaka', 'detail_peminjaman.id_pustaka')
        ->get();

        return view('petugas.pengembalian.index', compact('data'));
    }
}
