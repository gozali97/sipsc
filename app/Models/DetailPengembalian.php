<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    use HasFactory;
    protected $table = 'detail_pengembalian';
    protected $primaryKey = 'no_det_kembali';
    protected $guarded = [];
}
