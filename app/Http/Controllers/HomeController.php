<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('home');
    }

    public function profile(){
        $id = Auth::user()->id;
        $data = User::query()
        ->join('roles', 'roles.id', 'users.role_id')
        ->where('users.id', $id)->first();

        return view('profile', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $data = User::find($id);
        // dd($data);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $data->gambar))) {
                unlink(public_path('assets/img/' . $data->gambar));
            }

            // Simpan gambar baru
            $gambar = time() . 'profil' . '.' . $request->gambar->extension();
            $path = $request->file('gambar')->move('assets/img', $gambar);
            $data->gambar = $gambar;
        }

        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->alamat = $request->alamat;
        $data->save();

        if ($data->save()) {
            return redirect()->route('home')->with('success', 'Data profil berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate anggota' );
        }
    }
}
