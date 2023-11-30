@extends('layouts.app')

@section('content')
    <div class="h-full flex flex-col">

        {{-- NAVBAR --}}
        @include('includes.nav')

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

            {{-- content cart --}}
            <form id="formMahasiswa">
                @csrf
                <div class="flex w-full mt-[10%] items-center justify-center bg-opacity-30">
                    <div class="p-5 rounded-md border border-black text-center bg-white h-[250px]">
                        <h4 class="text-md font-bold">Silahkan ketik NIM kamu</h4>
                        <p class="text-sm">Silahkan klik cari apabila kamu sudah selesai input NIM kamu</p>
                        <input 
                            id="nim-input"
                            name="nim"
                            pattern="/^-?\d+\.?\d*$/" 
                            onKeyPress="return limitLength(this.value, 8)" 
                            onkeydown="preventMinus(event)"
                            placeholder="NIM" 
                            type="number" 
                            class="border rounded w-full py-2 px-3 text-black mt-5 leading-tight focus:outline-none focus:shadow-outline">
                        <p class="text-red-500 text-xs italic text-left pesan-error"></p>
                        <div class="flex flex-col gap-[15px] mt-[10px]">
                            <button id="btn-cari" type="submit" class="btn rounded bg-teal-700 text-white py-1 px-3 text-lg mt-3">CARI</button>
                            <a href="{{ url('/') }}" class="text-xs text-blue-600 cursor-pointer">Kembali ke Menu Utama</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        @include('includes.footer', [
            'bgColor' => ''
        ])
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(e) {
            // Library Vegas JS
            $('body').vegas({
                slides: [
                    {
                        src: '{{ url('images/pcr-lib2.jpg') }}'
                    }
                ],
                overlay: '{{ url('assets/vegas/overlays/07.png') }}'
            })
        })
    </script>
    @include('peminjaman.actionCari')
@endpush

