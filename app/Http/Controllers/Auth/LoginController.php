<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function redirectTo()
    {
        $user = auth()->user();

        if ($user->role->name === 'admin') {
            return route('admin');
        }

        if ($user->role->name === 'petugas') {
            return route('petugas');
        }

        if ($user->role->name === 'anggota') {
            return route('anggota');
        }

        return route('home');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
