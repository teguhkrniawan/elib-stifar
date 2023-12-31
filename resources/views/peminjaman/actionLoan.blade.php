<script>
    $('#formLoan').on('submit', function(e) {

        e.preventDefault();
        let pass = "";

        Swal.fire({
            title: "Masukkan password siakad kamu!",
            input: "password",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Lanjut",
            cancelButtonText: "Batal",
            showLoaderOnConfirm: true,
            preConfirm: async (password) => {
                pass = password
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                
                const formData = new FormData(this)
                formData.append('password', pass)

                $.ajax({
                        url: '{{ url('/peminjaman/insert') }}',
                        method: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: () => {
                            $('#btn-pinjam').text('Loading ...')
                        }
                    })
                    .success(res => {
                        $('#btn-pinjam').text('PINJAM BUKU')
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil Melakukan Peminjaman",
                            text: `klik cetak untuk mencetak bukti transaksi ini`,
                            confirmButtonText: "Cetak",
                            allowOutsideClick: false
                        }).then( result => {
                            if(result.isConfirmed){
                                const idPeminjaman = res.DATA.idPeminjaman
                                window.location.href = '/peminjaman/cetak?p='+idPeminjaman
                            }
                        })
                    })
                    .error(err => {
                        $('#btn-pinjam').text('PINJAM BUKU')
                        Swal.fire({
                            icon: "error",
                            title: "Gagal Meminjam",
                            text: `${err.responseJSON.MSG}`,
                        });
                    })
            }
        });


    });
</script>
