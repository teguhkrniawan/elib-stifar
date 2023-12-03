<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'tbl_detail_peminjaman';

    protected $fillable = [
        'id',
        'id_peminjaman',
        'nim',
        'id_buku',
        'jumlah'
    ];

    protected $casts = [
        'id' => 'string',
    ];

}
