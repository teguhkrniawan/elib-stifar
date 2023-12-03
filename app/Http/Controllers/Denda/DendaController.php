<?php

namespace App\Http\Controllers\Denda;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sqids\Sqids;

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
            $sqids = new Sqids(env('UNIQUE_KEY'), 20);
            $enskripsi_id = $sqids->encode([$denda->id]);
            if ($denda->status_peminjaman == 'DENDA') {
                return response()->json([
                    'MSG' => "Mahasiswa terindikasi denda",
                    'TYPE' => 'S',
                    'DATA' => [
                        'idPeminjaman' => $enskripsi_id
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
    public function indexPay(Request $request)
    {
        $idPeminjaman = $request->query('p');
        $sqids = new Sqids(env('UNIQUE_KEY'), 20);
        $idPeminjaman = $sqids->decode($idPeminjaman);
        if($idPeminjaman){
            $idPeminjaman = $idPeminjaman[0];
            $data = Peminjaman::where('id', $idPeminjaman)->first();

            // get info mahasiswa
            $mhs = Mahasiswa::where('nim', $data->nim)->first();

            // get info detail peminjaman
            $arrBuku_P = [];
            $list_buku_dipinjam = DetailPeminjaman::where('id_peminjaman', $idPeminjaman)->get();
            foreach ($list_buku_dipinjam as $key => $item_detail) {
                $buku = Buku::where('id', $item_detail->id_buku)->first();
                array_push($arrBuku_P, [
                    'judul_buku' => $buku->judul_buku,
                    'jumlah' => $item_detail->jumlah
                ]);
            }

            // midtrans get snap token
            \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            try {
                $status = \Midtrans\Transaction::status($idPeminjaman);
                if($status->transaction_status == 'pending'){
                    return view('denda.detailDenda', [
                        'data' => $status
                    ]);
                }
    
                if($status->transaction_status == 'settlement'){

                    $status->gross_amount =  number_format($status->gross_amount, 0, ',', '.');
                    $status->settlement_time =  date('d-M-Y H:i', strtotime( $status->settlement_time));

                    $list_buku = Buku::listPinjamanById($idPeminjaman);

                    return view('denda.cetak', [
                        'data' => $status,
                        'mhs'  => $mhs,
                        'list_buku' => $list_buku
                    ]);
                }
            } catch (\Throwable $th) {
                // params
                $params = array(
                    'transaction_details' => array(
                        'order_id'      => $idPeminjaman,
                        'gross_amount'  => $data->denda,
                    ),
                    'customer_details'  => array(
                        'name' => $mhs->nama_mahasiswa,
                        'phone'=> '6282188900921'
                    )
                );
    
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                return view('denda.pay', [
                    'peminjaman' => $data,
                    'mhs'        => $mhs,
                    'detail_buku' => $arrBuku_P,
                    'token'       => $snapToken  
                ]);
            }


            
        }

        return redirect('/');
    }

    // fungsi setelah pengguna melakukan pembayaran
    public function afterPay(Request $request){
        $idPeminjaman = $request->order_id;
        // update
        DB::table('tbl_peminjaman')
                ->where('id', $idPeminjaman)
                ->update([
                    'status_peminjaman' => 'LUNAS'
                ]);
    }

    // fungsi cetak
    public function cetak(Request $request){
        return view('denda.cetak');
    }
}
