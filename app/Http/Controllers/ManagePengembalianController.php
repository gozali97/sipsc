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
        ->join('users', 'users.id', 'pengembalians.id_user')
        ->join('pustakas', 'pustakas.id_pustaka', 'pengembalians.id_pustaka')
        ->get();

        return view('petugas.pengembalian.index', compact('data'));
    }
}
