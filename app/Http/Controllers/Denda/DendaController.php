<?php

namespace App\Http\Controllers\Denda;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    // fungsi untuk return view denda
    public function index(Request $request)
    {
        return view('denda.index');
    }

    // fungsi untuk cek apakah mahasiswa memiliki denda atau tidak
    public function cekDenda(Request $request)
    {

        $nim = $request->nim;
        

        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
        if (!$mahasiswa) {
            return response()->json([
                'MSG' => "NIM Not Found",
                'TYPE' => 'W',
                'DATA' => []
            ]);
        }

        $denda = Mahasiswa::cekStatusDenda($nim);
        if (COUNT($denda) > 0) {
            $denda = $denda[0];
            if ($denda->status_peminjaman == 'DENDA') {
                return response()->json([
                    'MSG' => "Mahasiswa terindikasi denda",
                    'TYPE' => 'S',
                    'DATA' => [
                        'idPeminjaman' => $denda->id
                    ]
                ]);
            }
        }

        return response()->json([
            'MSG' => "Tidak ada denda",
            'TYPE' => 'W',
        ]);
    }

    // fungsi untuk return view pay denda
    public function indexPay(Request $request){
        return view('denda.pay');
    }
}
