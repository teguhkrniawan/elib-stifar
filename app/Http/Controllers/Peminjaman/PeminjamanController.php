<?php

namespace App\Http\Controllers\Peminjaman;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Sqids\Sqids;

class PeminjamanController extends Controller
{
    // return view halaman peminjaman, saat input mahasiswa duluan
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

        $today    = date('Y-m-d');
        $nextWeek = DataHelper::nextWeek($today);
        $newtWeekString = DataHelper::convertTanggal($nextWeek); 

        // coba ambil data mahasiswa
        $mhs = Mahasiswa::where('id', $mhs_id)->first();
        if ($mhs != null) {
            $mhs->id = $sqids->encode([$mhs->id]);
            return view('peminjaman.keranjang', [
                'mhs' => $mhs,
                'tgl_tempo' => $newtWeekString
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
            // simpan ke tabel peminjaman

            $today    = date('Y-m-d');
            $nextWeek = DataHelper::nextWeek($today);

            $insertGetId = DB::table('tbl_peminjaman')
                ->insertGetId([
                    'nim' => $mhs_nim,
                    'nama_mahasiswa' => $mhs_nama,
                    'jumlah_buku'    => COUNT($arrIdBuku),
                    'tanggal_jatuh_tempo' => $nextWeek,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            foreach ($arrIdBuku as $key => $idBuku) {

                // simpan ke detail peminjaman
                DB::table('tbl_detail_peminjaman')
                    ->insert([
                        'nim' => $mhs_nim,
                        'id_peminjaman' => $insertGetId,
                        'id_buku' => $sqids->decode($idBuku)[0],
                        'jumlah' => 1
                    ]);

                // update stok buku
                DB::table('tbl_buku')
                        ->where('id', $sqids->decode($idBuku)[0])
                        ->update([
                            'stok' => DB::raw('stok - 1')
                        ]);
            }
            DB::commit();   

            $idPeminjaman = $sqids->encode([$insertGetId]);

            // setelah berhasil di commit barulah beri response
            return response()->json([
                'MSG' => "Sukses",
                'TYPE' => "S",
                'DATA' => [
                    'idPeminjaman' => $idPeminjaman
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

    // fungsi untuk melakukan cetak struk / resi
    public function cetakResi(Request $request){

        $sqids = new Sqids(env('UNIQUE_KEY'), 20);
        $idPeminjaman = $request->query('p');
        $idPeminjaman = $sqids->decode($idPeminjaman);
        if(!$idPeminjaman){
            return '<p>Error !!</p>';
        }

        // cek didatabase berdasarkan database peminjaman
        $list_buku = Buku::listPinjamanById($idPeminjaman[0]);
        $master_peminjaman = Peminjaman::where('id', $idPeminjaman)->first();


        return view('peminjaman.cetak', [
            'list_buku' => $list_buku,
            'master_peminjaman' => $master_peminjaman
        ]);
    }
}
