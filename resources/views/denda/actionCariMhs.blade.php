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
                    url: '{{ url('/denda/cekmhs') }}',
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
                    const type = res.TYPE

                    if(type == 'W'){
                        $('.pesan-error').text(res.MSG)
                    }
                    // apabila response data ada
                    if (type == 'S') {
                        console.log(data)
                        window.location.href = '/denda/pay?p='+res.DATA.idPeminjaman
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
