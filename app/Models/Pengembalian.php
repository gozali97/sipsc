<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalians';
    protected $guarded = [];
    public $incrementing = false;
    protected $primaryKey = 'no_kembali';
}