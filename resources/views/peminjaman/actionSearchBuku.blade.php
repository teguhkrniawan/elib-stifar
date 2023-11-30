<script>
    // apabila input text dapat aksi berupa enter press, atau scan
    $('#noPanggil').keydown(function(e) {
        const keyCode = event.which;
        if (keyCode == 13) {
            e.preventDefault();
            $.ajax({
                    url: "{{ url('/buku/detail') }}",
                    method: "GET",
                    data: {
                        kode_panggil: this.value
                    },
                    beforeSend: () => {
                        console.log('loading ...')
                    }
                })
                .success(res => {

                    // save to localstorage
                    // $('.container-cart').empty()
                    const cartStorage = JSON.parse(localStorage.getItem('cartBook')) || [];
                    const newData = res.DATA;

                    if (newData) {
                        const isExists = cartStorage.some(item => item.id == newData.id)
                        if (!isExists) {
                            cartStorage.push(newData)
                            localStorage.setItem('cartBook', JSON.stringify(cartStorage))
                        }
                        if (isExists) {
                            Swal.fire({
                                icon: "warning",
                                title: "Telah terdaftar",
                                text: `Buku dengan kode panggil ${this.value} sudah ada di daftar pinjamanmu`,
                            });
                        }
                    }

                    // lalu panggil dari data storage
                    let children = ""
                    cartStorage.map((item) => {
                        children += `
                        <div class="border rounded bg-gradient-to-r from-emerald-500 to-lime-600 shadow-b shadow-md p-3 mt-3">
                            <div class="flex justify-between items-center">
                                <input type="hidden" value="${item.id}" name="idBuku[]"></input>
                                <div class="identitas-buku text-white flex flex-col gap-[2px]">
                                    <h5 class="font-medium">${item.judul_buku} (${item.kode_panggil})</h5>
                                    <p class="text-xs">Penulis: ${item.penulis}</p>
                                    <p class="text-xs">Penerbit: ${item.penerbit}, Tahun 2023</p>
                                </div>
                                <i class="fa-solid fa-trash text-white text-[24px] pe-5 cursor-pointer delete-cart " data-id=${item.id}></i>
                            </div>
                        </div>
                        `
                    })

                    if (cartStorage.length == 0) {
                        children += `  <div class="text-center mt-3 flex flex-col items-center justify-center h-[250px] scan-kosong">
                                <img src="{{ url('images/scanner.png') }}" alt="scanner" class="w-32">
                                <p class="mt-3 font-bold">SILAHKAN SCAN BUKU</p>
                                <p class="text-xs">Buku dengan <b>nomor panggil</b> yang sama tidak boleh lebih dari 1</p>
                            </div>`
                    }

                    if (cartStorage.length > 0) {
                        $('#container-btn').removeClass('hidden')
                    }

                    $('.container-cart').empty().html(children)
                    $('#jlh-buku').html(`(${cartStorage.length})`)
                    $('#noPanggil').val('')

                })
                .error(err => {
                    $('#noPanggil').val('')
                })
        }
    })
</script>
