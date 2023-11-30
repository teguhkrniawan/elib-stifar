@extends('layouts.app')

@section('content')
    <div class="h-full flex flex-col">

        {{-- NAVBAR --}}
        @include('includes.nav')

        {{-- VEGAS SCREEN --}}
        <div class="background-menu">
            {{-- Breadcubs --}}
            <div class="flex w-full px-[50px] pt-4 bg-opacity-30 ">
                <a href="{{ url('/') }}">
                    <span class="rounded-full bg-red-700 p-3 font-bold text-white text-xs"><i
                            class="fa-solid fa-arrow-left me-3"></i>Menu
                        Utama</span>
                </a>
            </div>

            {{-- content left and right --}}
            <div class="w-full grid grid-cols-12 gap-2 mt-5 px-2">
                {{-- content left --}}
                <div class="col-span-4 bg-white rounded-md">
                    <div class="p-5">
                        <h3 class="text-md font-bold">IDENTITAS MAHASISWA</h3>
                        <div class="identitas flex justify-center mt-5">
                            <img src="{{ url('images/mhs.jpg') }}" alt="identitas-siswa" class="w-32">
                        </div>
                        <div class="flex items-center justify-center">
                            <table class="mt-5">
                                <tbody>
                                    <tr class="">
                                        <td class=" px-2 font-bold">NAMA</td>
                                        <td class=" text-center font-bold">:</td>
                                        <td class="px-2 font-bold uppercase">{{ $mhs ? $mhs->nama_mahasiswa : '' }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class=" px-2 font-bold">NIM</td>
                                        <td class=" text-center font-bold">:</td>
                                        <td class="px-2 font-bold">{{ $mhs ? $mhs->nim : '' }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class=" px-2 font-bold">PRODI</td>
                                        <td class=" text-center font-bold">:</td>
                                        <td class="px-2 font-bold uppercase">{{ $mhs ? $mhs->prodi : '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <marquee class="uppercase pt-5">Buku yang dipinjam hari ini, harap dikembalikan Tanggal <b>07 Des
                                2023</b></marquee>
                    </div>
                </div>

                {{-- content right --}}
                <div class="col-span-8 bg-white shadow">
                    <div class="p-5">
                        <form id="formLoan">
                            <div class="flex justify-between mb-3 px-3">
                                <h3 class="font-bold">DAFTAR BUKU <span id="jlh-buku"></span></h3>
                                <input id="noPanggil" type="text"
                                    class="border px-3 focus:border-gray-100 focus:outline-none" placeholder="No Panggil">
                            </div>
    
                            <div class="container-cart overflow-y-scroll h-[250px]">
                                <div class="text-center mt-3 flex flex-col items-center justify-center h-[250px] scan-kosong">
                                    <img src="{{ url('images/scanner.png') }}" alt="scanner" class="w-32">
                                    <p class="mt-3 font-bold">SILAHKAN SCAN BUKU</p>
                                    <p class="text-xs">Buku dengan <b>nomor panggil</b> yang sama tidak boleh lebih dari 1</p>
                                </div>
                            </div>
    
                            <div class="flex justify-center hidden" id="container-btn">
                                <button type="submit"
                                    class="text-center w-[30%] py-3 text-white rounded-full font-bold mt-5 bg-emerald-800">PINJAM
                                    BUKU</button>
                            </div>
                        </form>
                    </div>
                </div>
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
            // Library vegas js
            $('body').vegas({
                slides: [{
                    src: '{{ url('images/pcr-lib2.jpg') }}'
                }],
                overlay: '{{ url('assets/vegas/overlays/07.png') }}'
            })


            // focus ke input untuk scan 
            $('#noPanggil').focus()

            // hapus storage
            localStorage.removeItem('cartBook')
        })
    </script>
    @include('peminjaman.actionSearchBuku')
    @include('peminjaman.deleteCart')
@endpush
