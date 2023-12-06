<script>
    $('#formMahasiswa').on('submit', function(e) {
        e.preventDefault();

        // lakukan pengecekan serverg
        const nim = $('#nim-input').val()
        if (nim == '') {
            $('.pesan-error').text('NIM is required')
        }

        // lakukan request ke server melalui ajax
        if (nim != '') {
            $.ajax({
                    url: '{{ url('/pengembalian/cek') }}',
                    method: 'POST',
                    data: new FormData(this),
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $('#btn-cari').text('Loading ...')
                    }
                })
                .success(res => {
                    $('#btn-cari').text('CARI')
                    $('#nim-input').val('')
                    const data = res.DATA
                    // apabila response data null
                    if (!data) {
                        $('.pesan-error').text("NIM Not Found")
                    }
                    // apabila response data ada
                    if (data) {
                        if (res.TYPE == 'W') {
                            Swal.fire({
                                icon: "warning",
                                title: "Tidak ada peminjaman",
                                text: `kamu tidak memiliki peminjaman buku, silahkan melakukan peminjaman`,
                            });
                        }

                        if (res.TYPE == 'S') {
                            const p = res.DATA.id_pinjaman;
                            const m = res.DATA.mhs.id
                            window.location.href = '/pengembalian/keranjang?p=' + p + '&m=' + m
                        }
                    }
                })
                .error(err => {
                    $('#btn-cari').text('CARI')
                    $('.pesan-error').text("")
                    $('#nim-input').val('')
                    Swal.fire({
                        icon: "error",
                        title: "Peringatan",
                        text: `${err.responseJSON.MSG}`,
                    });
                })
        }
    })
</script>
