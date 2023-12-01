<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Sqids\Sqids;

class MahasiswaController extends Controller
{
    // get mahasiswa
    public function detailMahasiswa(Request $request)
    {
        if ($request->nim == '') {
            return response()->json([
                'MSG' => 'NIM Not Found',
                'TYPE' => 'E'
            ], 400);
        }

        try {
            // cari informasi mahasiswa by NIM
            $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

            // apabila tidak null
            if ($mahasiswa) {
                // hash id mahasiswa agar tidak mudah dibaca
                $sqids = new Sqids(env('UNIQUE_KEY'), 20);
                $enskripsi_id = $sqids->encode([$mahasiswa->id]);
                $mahasiswa->id = strval($enskripsi_id);
            }
            
            return response()->json([
                'MSG' => "Sukses",
                'TYPE' => "S",
                'DATA' => $mahasiswa
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'MSG' => 'Something went wrong',
                'TYPE' => 'E'
            ], 400);
        }
    }
}
