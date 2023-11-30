<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = "tbl_buku";

    protected $fillable = [
        'id',
        'kode_panggil',
        'judul_buku',
        'penulis',
        'penerbit',
        'cover_img',
        'stok',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
