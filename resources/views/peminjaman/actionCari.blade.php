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
                url: '{{ url("/mahasiswa/detail") }}',
                method: 'POST',
                data: new FormData(this),
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: () => {
                    $('#btn-cari').text('Loading ...')
                }
            })
            .success( res => {
                $('#btn-cari').text('CARI')
                $('#nim-input').val('')
                const data = res.DATA
                // apabila response data null
                if(!data){
                    $('.pesan-error').text("NIM Not Found")
                }
                // apabila response data ada
                if(data){
                    const m = res.DATA.id;
                    window.location.href = '/peminjaman/keranjang?m=' +m
                }
            })
            .error( err => {
                $('#btn-cari').text('CARI')
                $('.pesan-error').text(res.MSG)
            })
        }
    })
</script>
