@extends('layouts.app')
@section('description', 'digital library stifar Riau')
@section('keywords', 'digital stifar')


@section('content')
    <div class="h-screen flex flex-col justify-between">

        {{-- NAVBAR --}}
        @include('includes.nav')

        {{-- VEGAS SCREEN --}}
        <div class="background-menu h-screen items-center flex justify-center">
            <div class="flex gap-[7vw] py-auto flex-col md:flex-row">
                <a href="{{ url('/peminjaman') }}">
                    <div
                        class="box1 p-[50px] text-center rounded bg-cyan-600 border border-gray-200 border-2 cursor-pointer">
                        <i class="fa-solid fa-book text-[30px] text-white pb-3"></i>
                        <p class="text-white font-bold">PEMINJAMAN <br> MANDIRI</p>
                    </div>
                </a>

                <div class="box1 p-[50px] text-center rounded bg-yellow-500 border border-gray-200 border-2 cursor-pointer">
                    <i class="fa-solid fa-clock text-[30px] text-white pb-3"></i>
                    <p class="text-white font-bold">PENGEMBALIAN <br> BUKU</p>
                </div>

                <a href="{{ url('/denda') }}">
                    <div
                        class="box1 p-[50px] text-center rounded bg-emerald-600 border border-gray-200 border-2 cursor-pointer">
                        <i class="fa-solid fa-file-invoice-dollar text-[30px] text-white pb-3"></i>
                        <p class="text-white font-bold">PEMBAYARAN <br> DENDA</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Footer --}}
        @include('includes.footer', [
            'bgColor' => '',
        ])
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(e) {
            $('body').vegas({
                slides: [{
                        src: '{{ url('images/pcr-lib.jpg') }}'
                    },
                    {
                        src: '{{ url('images/pcr-lib2.jpg') }}'
                    },
                    {
                        src: '{{ url('images/pcr-lib3.jpg') }}'
                    }
                ],
                overlay: '{{ url('assets/vegas/overlays/07.png') }}'
            })
        })
    </script>
@endpush
