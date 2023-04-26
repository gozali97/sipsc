<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $guarded = [];
    public $incrementing = false;
    protected $primaryKey = 'no_pinjam';

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'no_pinjam');
    }
}
