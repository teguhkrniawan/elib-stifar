<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // fungsi agar mendpatkan list buku apa saja yang di pinjam by id peminjaman
    public static function listPinjamanById($id){
        $response = [];
        $query = "SELECT 
                        a.id,
                        (SELECT judul_buku FROM tbl_buku WHERE id = a.id_buku) AS judul_buku,
                        (SELECT kode_panggil FROM tbl_buku WHERE id = a.id_buku) AS kode_panggil,
                        jumlah
                    FROM tbl_detail_peminjaman a
                    WHERE a.id_peminjaman = '$id'";
        $data = DB::select($query);
        if(COUNT($data) > 0){
            $response = $data;
        }

        return $response;
    }
}
