<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email</title>
    @vite('resources/css/app.css')
</head>
<body class="text-gray-200">
    <div class="flex justify-center items-center w-full bg-gray-200">
        <div class="flex flex-col bg-white w-[50%] h-screen text-black">
            <div class="h-32 bg-green-600 flex flex-col items-center rounded-b-lg">
                <h3 class="font-bold text-white mt-5 text-[28px]">DIGILIB STIFAR RIAU</h3>
                <p class="text-white tracking-widest">-- Penalty Receipt --</p>
            </div>
            <div class="content p-5">

                <h1 class="font-bold text-lg">Rp. {{ $data['ammount'] }}</h1>

                <h3 class="italic text-gray-400 text-xs">{{ $data['tgl_pembayaran'] }}</h3>

                <p class="text-medium mt-5 text-justify">
                    Pembayaran denda atas keterlambatan pengembalian buku <b>Berhasil</b>. Silahkan simpan email ini sebagai
                    bukti struk yang sah. Berikut kami tampilkan list buku yang terhitung denda :
                </p>

                <table class="border w-full border-black mt-5">
                    <thead>
                        <tr class="font-bold">
                            <td width="10px" class="border border-black px-2">No</td>
                            <td class="px-2 border border-black">Items</td>
                            <td width="30px" class="px-2 border border-black">Qty</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data['arrBuku'] as $item)
                            <tr>
                                <td width="10px" class="border border-black px-2">{{ $no++ }}</td>
                                <td class="px-2 border border-black">{{ $item['judul_buku'] }}</td>
                                <td width="30px" class="px-2 border border-black">X1</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p class="mt-5 text-justify italic text-xs">
                    Apabila ada kesalahan pada email ini, silahkan hubungi IT Helpdesk STIFAR Riau.
                </p>
            </div>
        </div>
    </div>
</body>
</html>