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
            <div class="text-center">
                <h3 class="text-xs">Digital Library</h3>
                <p class="text-xs">Sekolah Tinggi Ilmu Farmasi Riau</p>
                <p>-- PEMINJAMAN --</p>
            </div>

            <p class="text-xs mt-5">12/12/2023 - 18:09</p>
            <p class="text-xs">NIM : 92830821</p>
            <div class="flex justify-between text-xs mt-[30px] border-b border-dashed pb-3 border-black">
                <p class="text-xs me-5 ">Judul buku yang sangat bagus untuk dkembangkan oleh pemula</p>
                <p class="text-xs">x1</p>
            </div>


            <div class="text-center text-xs mt-[30px] pb-5">
                <p>Terimaksih telah menggunakan Digital Library</p>
                <p>simpan resi ini, dan tunjukkan ke petugas sebagai bukti peminjaman buku</p>
            </div>
        </div>
    </div>

    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var printOptions = {
                silent: true, // Suppress the print dialog
                printBackground: true, // Include background graphics and colors
                deviceWidth: "8.5in", // Set the width of the printed page
                deviceHeight: "11in" // Set the height of the printed page
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
