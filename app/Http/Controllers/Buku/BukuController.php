<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Sqids\Sqids;

class BukuController extends Controller
{
    // get detail buku
    public function getDetailBuku(Request $request){

        $kode_panggil = $request->kode_panggil;
        $buku = Buku::where('kode_panggil', $kode_panggil)->first();
        if($buku){
            $sqids = new Sqids(env('UNIQUE_KEY'), 20);
            $buku->id = $sqids->encode([$buku->id]);
            return response()->json([
                'MSG' => "Sukses",
                'TYPE'=> 'S',
                'DATA'=> $buku
            ]);
        }
    }
}
