@extends('layouts.app')

@section('content')
    <div class="h-full flex flex-col">

        {{-- NAVBAR --}}
        @include('includes.nav')

        <div id="snap-container" class="p-[30px] flex justify-center"></div>

        {{-- VEGAS SCREEN --}}
        <div class="background-menu">

            {{-- Breadcubs --}}
            <div class="flex w-full px-[50px] py-5 bg-opacity-30 ">
                <a href="{{ url('/') }}">
                    <span class="rounded-full bg-red-700 p-3 font-bold text-white text-xs"><i
                            class="fa-solid fa-arrow-left me-3"></i>Menu
                        Utama</span>
                </a>
            </div>

            <div class="flex justify-center bg-opacity-30 mb-[100px]">
                <form id="formDenda">
                    <div class="gap-[20px] p-5 rounded-md border border-black bg-white flex flex-col" style="width: 500px">

                        <div class="flex text-center flex-col">
                            <h3 class="font-bold">DETAIL PEMBAYARAN</h3>
                            <p>Silahkan bayar tagihan anda sebelum <b>{{ date('d-M-Y H:i', strtotime($data->expiry_time)) }}</b></p>

                            <h1 class="text-red-700 font-bold text-[30px]">Rp. {{ number_format($data->gross_amount, 0, ',', '.') }}</h1>

                            <p>Transfer Melalui Virtual Account : <span class="uppercase">{{ $data->va_numbers[0]->bank }}</span></p>
                            <p>Virtual Account : {{ $data->va_numbers[0]->va_number }}</p>
                        </div>
                    </div>
                </form>
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
            // Library Vegas JS
            $('body').vegas({
                slides: [{
                    src: '{{ url('images/pcr-lib2.jpg') }}'
                }],
                overlay: '{{ url('assets/vegas/overlays/07.png') }}'
            })
        })
    </script>
@endpush
