<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'tbl_mahasiswa';

    protected $fillable = [
        'id',
        'nim',
        'nama_mahasiswa',
        'prodi',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    /**
     * untuk melihat apakah mahasiswa pe
     */
    public static function cekAksesPeminjaman($nim){
        $response = [];

        $query = "SELECT id, status_peminjaman FROM tbl_peminjaman a WHERE a.nim = '$nim' AND (status_peminjaman = 'DENDA' OR status_peminjaman = 'PINJAM') ORDER BY id DESC LIMIT 1";
        $data  = DB::select($query);
        if(COUNT($data) > 0){
            $response = $data;
        }

        return $response;
    }

    public static function cekStatusDenda($nim){
        $response = [];

        $query = "SELECT id, status_peminjaman FROM tbl_peminjaman a WHERE a.nim = '$nim' AND status_peminjaman = 'DENDA'  ORDER BY id DESC LIMIT 1";
        $data  = DB::select($query);
        if(COUNT($data) > 0){
            $response = $data;
        }

        return $response;
    }

    public static function cekStatusPengembalian($nim){
        $response = [];

        $query = "SELECT id, status_peminjaman FROM tbl_peminjaman a WHERE a.nim = '$nim' AND status_peminjaman = 'PINJAM'  ORDER BY id DESC LIMIT 1";
        $data  = DB::select($query);
        if(COUNT($data) > 0){
            $response = $data;
        }

        return $response;
    }
    
}
