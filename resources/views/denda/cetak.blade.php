<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body>
    <div class="w-full bg-gray-200 h-screen flex justify-center font-bold">
        <div class="flex flex-col w-[300px] p-3 bg-white">
            <div class="text-center pb-5">
                <h3 class="text-xs">Digital Library</h3>
                <p class="text-xs">Sekolah Tinggi Ilmu Farmasi Riau</p>
                <p>-- BUKTI PELUNASAN DENDA --</p>
            </div>

            <table class="text-sm">
                <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td>{{ $mhs->nama_mahasiswa }}</td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>{{ $mhs->nim }}</td>
                </tr>
                <tr>
                    <td>PRODI</td>
                    <td>:</td>
                    <td>{{ $mhs->prodi }}</td>
                </tr>
                <tr>
                    <td>TOTAL</td>
                    <td>:</td>
                    <td>Rp. {{ $data->gross_amount }}</td>
                </tr>
                <tr>
                    <td>TGL BAYAR</td>
                    <td>:</td>
                    <td>{{ $data->settlement_time }}</td>
                </tr>
            </table>

            @foreach ($list_buku as $item)
                <div class="flex justify-between text-xs mt-[30px] border-b border-dashed pb-3 border-black">
                    <p class="text-xs me-5 ">{{ $item->judul_buku }} ({{ $item->kode_panggil }})</p>
                    <p class="text-xs">x1</p>
                </div>
            @endforeach

            <div class="text-center text-xs mt-[30px] pb-5">
                <p>Terimakasih telah menggunakan Digital Library</p>
                <p>Struk ini merupakan bukti pembayaran yang sah!</p>
            </div>
        </div>
    </div>

    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var printOptions = {
                silent: true,
                printBackground: true,
                deviceWidth: "8.5in",
                deviceHeight: "11in"
            };

            // Call the print function with options
            window.print(printOptions);
        });

        setTimeout(() => {
            window.location.href = '/'
        }, 3000);
    </script>
</body>

</html>
