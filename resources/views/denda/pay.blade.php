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

            <div class="flex justify-center bg-opacity-30 mb-[100px]">
                <form action="">
                    <div class="gap-[20px] p-5 rounded-md border border-black bg-white flex flex-col" style="width: 500px">

                        <div class="flex text-center flex-col">
                            <h3>PEMBAYARAN DENDA</h3>
                            <p class="text-xs">Berikut adalah informasi tagihan anda!</p>
                        </div>

                        <div class="flex flex-col overflow-y-scroll">
                            <table class="mb-5">
                                <tbody>
                                    <tr class="">
                                        <td class=" px-2 font-bold">NAMA</td>
                                        <td class=" text-center font-bold">:</td>
                                        <td class="px-2 font-bold uppercase">TEGUH KURNIAWAN</td>
                                    </tr>
                                    <tr class="">
                                        <td class=" px-2 font-bold">NIM</td>
                                        <td class=" text-center font-bold">:</td>
                                        <td class="px-2 font-bold">1572736</td>
                                    </tr>
                                    <tr class="">
                                        <td class=" px-2 font-bold">PRODI</td>
                                        <td class=" text-center font-bold">:</td>
                                        <td class="px-2 font-bold uppercase">KESEHATAN MASYARAKAT</td>
                                    </tr>
                                    <tr class="">
                                        <td class=" px-2 font-bold">DENDA</td>
                                        <td class=" text-center font-bold">:</td>
                                        <td class="px-2 font-bold text-red-500">Rp 20.000</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex pt-3 justify-between px-4 border-b border-dashed border-black border-md pb-3">
                                <p class="me-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo, voluptatibus.</p>
                                <p>X1</p>
                            </div>
                            <div class="flex pt-3 justify-between px-4 border-b border-dashed border-black border-md pb-3">
                                <p class="me-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo, voluptatibus.</p>
                                <p>X1</p>
                            </div>
                            <div class="flex pt-3 justify-between px-4 border-b border-dashed border-black border-md pb-3">
                                <p class="me-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo, voluptatibus.</p>
                                <p>X1</p>
                            </div>
                        </div>

                        <div class="flex justify-center" id="container-btn">
                            <button type="submit" id="btn-bayar"
                                class="text-center w-[30%] py-3 text-white rounded-full font-bold mt-5 bg-emerald-800">BAYAR</button>
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
