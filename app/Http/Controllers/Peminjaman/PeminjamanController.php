<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Sqids\Sqids;

class PeminjamanController extends Controller
{
    // return view halaman peminjaman
    public function index()
    {
        return view('peminjaman.index');
    }

    // return view halaman keranjang
    public function indexKeranjang(Request $request)
    {

        // ambil query, hash id dari url
        $mhs_id = $request->query('m');
        $sqids  = new Sqids(env('UNIQUE_KEY'), 20);
        $mhs_id = $sqids->decode($mhs_id);

        // coba ambil data mahasiswa
        $mhs = Mahasiswa::where('id', $mhs_id)->first();
        if ($mhs != null) {
            $mhs->id = $sqids->encode([$mhs->id]);
            return view('peminjaman.keranjang', [
                'mhs' => $mhs
            ]);
        }

        return redirect('/');
    }

    // fungsi untuk menyimpan buku yang dipilih user kedalam database
    public function insertPeminjaman(Request $request)
    {

        // lakukan perulangan untuk mendapatkan daftar buku yang ada di keranjang
        $arrIdBuku = $request->idBuku;
        $sqids = new Sqids(env('UNIQUE_KEY'), 20);

        foreach ($arrIdBuku as $key => $idBuku) {
            // decode id yang telah di encrypt
            $idBukuNew = $sqids->decode($idBuku);

            // apabila encrypt nya cocok
            if ($idBukuNew) {
                $idBuku = $idBukuNew;
            } else {
                $idBuku = $idBuku;
            }

            // apabila buku yang mau di save tidak ada pada database
            $buku = Buku::where('id', $idBuku)->first();
            if (!$buku) {
                return response()->json([
                    'MSG' => 'Kami mendeteksi bahwa ada buku yang tidak tersedia, harap ulangi proses input keranjang ',
                    'TYPE' => 'E'
                ], 400);
            }
        }

        /**
         * ambil data mahasiswa
         */
        $idMhsDecode = $sqids->decode($request->idMhs);
        $mhs = Mahasiswa::where('id', $idMhsDecode)->first();

        if (!$mhs) {
            return response()->json([
                'MSG' => 'Kami tidak dapat mendeteksi identitas mahasiswa!',
                'TYPE' => 'E'
            ], 400);
        }

        $mhs_nama = $mhs->nama_mahasiswa;
        $mhs_nim  = $mhs->nim;
        $mhs_pass = $mhs->password;

        if($request->password == ''){
            return response()->json([
                'MSG' => 'Kata sandi tidak boleh kosong!',
                'TYPE' => 'E'
            ], 400);
        }

        $hashCheck = Hash::check($request->password, $mhs_pass);
        if(!$hashCheck){
            return response()->json([
                'MSG' => 'Kata sandi tidak cocok dengan data kami !',
                'TYPE' => 'E'
            ], 400);
        }

        /**
         * dibawah ini adalah proses agar tidak terjadi
         * rece condition dalam peminjaman
         */
        DB::beginTransaction();
        try {
            $insertGetId = DB::table('tbl_peminjaman')
                ->insertGetId([
                    'nim' => $mhs_nim,
                    'nama_mahasiswa' => $mhs_nama,
                    'jumlah_buku'    => COUNT($arrIdBuku),
                    'tanggal_pengembalian' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            DB::commit();   

            // setelah berhasil di commit barulah beri response
            return response()->json([
                'MSG' => "Sukses",
                'TYPE' => "S",
                'DATA' => [
                    'idPeminjaman' => $insertGetId
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'MSG' => 'Something went wrong',
                'TYPE' => 'E'
            ], 400);
        }
    }
}
