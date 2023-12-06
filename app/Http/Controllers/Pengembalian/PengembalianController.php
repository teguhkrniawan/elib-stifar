<?php

namespace App\Http\Controllers\Pengembalian;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Sqids\Sqids;

class PengembalianController extends Controller
{
    // fungsi index
    public function index(Request $request)
    {
        return view('pengembalian.index');
    }

    // fungsi untuk melakukan cek mahasiswa yang melakulan peminjaman
    public function cekPeminjaman(Request $request)
    {
        $cekStatusPeminjaman = Mahasiswa::cekStatusPengembalian($request->nim);
        $sqids  = new Sqids(env('UNIQUE_KEY'), 20);
        $mhs = Mahasiswa::where('nim', $request->nim)->select('id', 'nim', 'nama_mahasiswa', 'prodi')->first();

        // apabila mahasiswa ada meminjam buku
        if (COUNT($cekStatusPeminjaman) > 0) {
            $mhs->id       = $sqids->encode([$mhs->id]);
            $id_peminjaman = $cekStatusPeminjaman[0]->id;
            $data_p        = DetailPeminjaman::where('id_peminjaman', $id_peminjaman)->get();
            return response()->json([
                'MSG' => "OK",
                'TYPE' => "S",
                'DATA' => [
                    'jumlah_pinjaman' => COUNT($data_p),
                    'id_pinjaman'     => $sqids->encode([$id_peminjaman]),
                    'mhs'             => $mhs
                ]
            ]);
        }

        // apabola mahasiswa tidak ada meminjam buku
        if (COUNT($cekStatusPeminjaman) == 0) {
            return response()->json([
                'MSG' => "OK",
                'TYPE' => "W",
                'DATA' => []
            ]);
        }
    }

    // fungsi returb view index keranjang
    public function indexKeranjang(Request $request)
    {

        $mhs_id = $request->query('m');
        $id_peminjaman = $request->query('p');

        $sqids  = new Sqids(env('UNIQUE_KEY'), 20);
        $mhs_id = $sqids->decode($mhs_id);
        $idPeminjaman =  $sqids->decode($id_peminjaman);

        $mhs = Mahasiswa::where('id', $mhs_id)->first();
        $data_p  = DetailPeminjaman::where('id_peminjaman', $idPeminjaman)->get();

        if ($mhs != null) {
            $mhs->id = $sqids->encode([$mhs->id]);
            return view('pengembalian.keranjang', [
                'mhs' => $mhs,
                'id_peminjaman' => $id_peminjaman,
                'jumlah'        => COUNT($data_p)
            ]);
        }

        return redirect('/');
    }

    // fungsi untuk melakukan cek buku
    public function cekBuku(Request $request)
    {

        $mahasiswaId  = $request->m;
        $idPeminjaman = $request->p;

        $sqids          = new Sqids(env('UNIQUE_KEY'), 20);
        $mahasiswaId    = $sqids->decode($mahasiswaId)[0];
        $idPeminjaman   = $sqids->decode($idPeminjaman)[0];

        $kodeBuku     = $request->kode_panggil;
        $mhs      = Mahasiswa::where('id', $mahasiswaId)->first();

        $data = DetailPeminjaman::bookIsExists($kodeBuku, $idPeminjaman, $mhs->nim);
        if (COUNT($data) > 0) {
            $buku = Buku::where('kode_panggil', $kodeBuku)->first();
            if ($buku) {
                $sqids = new Sqids(env('UNIQUE_KEY'), 20);
                $buku->id = $sqids->encode([$buku->id]);
                return response()->json([
                    'MSG' => "Sukses",
                    'TYPE' => 'S',
                    'DATA' => $buku
                ]);
            }
        }

        if (COUNT($data) == 0) {
            return response()->json([
                'MSG' => "Tidak ada Buku",
                'TYPE' => 'W',
                'DATA' => []
            ]);
        }
    }

    // fungsi untuk pengembalian
    public function insert(Request $request)
    {

        $sqids = new Sqids(env('UNIQUE_KEY'), 20);
        $idPeminjaman = $sqids->decode($request->idPeminjaman);
        $peminjaman_d = Peminjaman::where('id', $idPeminjaman)->first();

        $today        = date('Y-m-d');
        $tempo        = $peminjaman_d->tanggal_jatuh_tempo;

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

        $hashCheck = Hash::check($request->password, $mhs->password);
        if (!$hashCheck) {
            return response()->json([
                'MSG' => 'Kata sandi tidak cocok dengan data kami !',
                'TYPE' => 'E'
            ], 400);
        }

        $arrBuku = COUNT($request->idBuku);
        $jumlah_buku_dipinjam = $peminjaman_d->jumlah_buku;
        if($arrBuku != $jumlah_buku_dipinjam){
            return response()->json([
                'MSG' => 'Pastikan semua buku yang kamu pinjam ada didalam list',
                'TYPE' => 'E'
            ], 400);
        }

        foreach ($request->idBuku as $key => $item) {
            DB::table('tbl_buku')
                ->where('id', $sqids->decode($item)[0])
                ->update([
                    'stok' => DB::raw('stok + 1')
                ]);
        }

        if ($today > $tempo) {
            $today = strtotime($today);
            $tempo = strtotime($tempo);
            $selisih = floor(($today - $tempo) / (60 * 60 * 24));

            $denda = $selisih * 5000;
            DB::table('tbl_peminjaman')
                ->where('id', $idPeminjaman)
                ->update([
                    'denda' => $denda,
                    'status_peminjaman' => 'DENDA'
                ]);
            return response()->json([
                'MSG' => "Success",
                'TYPE' => 'S',
                'DATA' => [
                    'idPeminjaman' => $request->idPeminjaman
                ]
            ]);
        }

        DB::table('tbl_peminjaman')
            ->where('id', $idPeminjaman)
            ->update([
                'status_peminjaman' => 'SELESAI'
            ]);
        return response()->json([
            'MSG' => "Success",
            'TYPE' => 'S',
            'DATA' => [
                'idPeminjaman' => $request->idPeminjaman
            ]
        ]);
    }

    // cetak resi
    public function cetak(Request $request){
        $sqids = new Sqids(env('UNIQUE_KEY'), 20);
        $idPeminjaman = $request->query('p');
        $idPeminjaman = $sqids->decode($idPeminjaman);
        if(!$idPeminjaman){
            return '<p>Error !!</p>';
        }

        // cek didatabase berdasarkan database peminjaman
        $list_buku = Buku::listPinjamanById($idPeminjaman[0]);
        $master_peminjaman = Peminjaman::where('id', $idPeminjaman)->first();


        return view('pengembalian.cetak', [
            'list_buku' => $list_buku,
            'master_pengembalian' => $master_peminjaman
        ]);
    }
}
