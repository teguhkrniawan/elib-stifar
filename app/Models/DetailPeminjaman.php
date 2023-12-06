<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // untuk melihat buku yang dipinjam, matching atau enggak saat peminjaman
    public static function bookIsExists(string $kodeBuku, int $idPeminjaman, int $nimMhs){
        
        $query = "SELECT *, (SELECT kode_panggil FROM tbl_buku WHERE id = a.id_buku ) AS kode_panggil
        FROM tbl_detail_peminjaman a
        WHERE nim = '".$nimMhs."' AND (SELECT kode_panggil FROM tbl_buku WHERE id = a.id_buku ) = '".$kodeBuku."' AND id_peminjaman = '".$idPeminjaman."'";
        
        $data = DB::select($query);
        if(COUNT($data) > 0){
            return $data;
        }

        return [];
    }

}
