<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = "tbl_peminjaman";
    
    protected $fillable = [
        'id',
        'nim',
        'nama_mahasiswa',
        'jumlah_buku',
        'tanggal_pengembalian',
        'tanggal_jatuh_tempo',
        'denda',
        'status_peminjaman',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
