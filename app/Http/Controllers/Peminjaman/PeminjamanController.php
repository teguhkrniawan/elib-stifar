<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Sqids\Sqids;

class PeminjamanController extends Controller
{
    // return view halaman peminjaman
    public function index(){
        return view('peminjaman.index');
    }

    // return view halaman keranjang
    public function indexKeranjang(Request $request){

        // ambil query, hash id dari url
        $mhs_id = $request->query('m');
        $sqids  = new Sqids(env('UNIQUE_KEY'), 20);
        $mhs_id = $sqids->decode($mhs_id);
        
        // coba ambil data mahasiswa
        $mhs = Mahasiswa::where('id', $mhs_id)->first();
        if($mhs != null){
            $mhs->id = $sqids->encode([$mhs->id]);
            return view('peminjaman.keranjang', [
                'mhs' => $mhs
            ]);
        }

        return redirect('/');
    }

}
