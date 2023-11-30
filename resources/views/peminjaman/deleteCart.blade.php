<script>
    $(document).on('click', '.delete-cart', function(e) {
        const id = $(this).data('id')
        let children = ""
        Swal.fire({
            title: "Apa kamu yakin?",
            text: "kamu akan menghapus daftar buku ini dari daftar pinjaman",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                const cartStorage = JSON.parse(localStorage.getItem('cartBook')) || [];
                const newData = cartStorage.filter(item => item.id != id);
                localStorage.setItem('cartBook', JSON.stringify(newData));

                // Kosongkan dan isi ulang .container-cart setelah perubahan localStorage
                updateContainerCart();
            }

        });
    })

    function updateContainerCart() {
        let children = "";
        const cartStorage = JSON.parse(localStorage.getItem('cartBook')) || [];
        cartStorage.map((item) => {
            children += `
            <div class="border rounded bg-gradient-to-r from-emerald-500 to-lime-600 shadow-b shadow-md p-3 mt-3">
                <div class="flex justify-between items-center">
                    <div class="identitas-buku text-white flex flex-col gap-[2px]">
                        <input type="hidden" value="${item.id}" name="idBuku[]"></input>
                        <h5 class="font-medium">${item.judul_buku} (${item.kode_panggil})</h5>
                        <p class="text-xs">Penulis: ${item.penulis}</p>
                        <p class="text-xs">Penerbit: ${item.penerbit}, Tahun 2023</p>
                    </div>
                    <i class="fa-solid fa-trash text-white text-[24px] pe-5 cursor-pointer delete-cart " data-id=${item.id}></i>
                </div>
            </div>
        `;
        });

        // Kosongkan dan isi ulang .container-cart
        if(cartStorage.length == 0){
            children += `  <div class="text-center mt-3 flex flex-col items-center justify-center h-[250px] scan-kosong">
                                <img src="{{ url('images/scanner.png') }}" alt="scanner" class="w-32">
                                <p class="mt-3 font-bold">SILAHKAN SCAN BUKU</p>
                                <p class="text-xs">Buku dengan <b>nomor panggil</b> yang sama tidak boleh lebih dari 1</p>
                            </div>`
            $('#container-btn').addClass('hidden')
        }
        $('.container-cart').empty().html(children);
        $('#jlh-buku').html(`(${cartStorage.length})`);
        $('#noPanggil').focus()
    }
</script>
