@extends('layout.dashboard')

@section('content')

<div class="text-xl font-bold">
    {{ $data['title'] }}
</div>

<div class="mt-5">
    <h1 class="text-2xl my-5">Selamat Datang di Halaman Beranda Sistem Informasi Angka Kematian Ibu Kabupaten Bondowoso</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <a href="#" class="block max-w-lg p-6 bg-white shadow-xl rounded-lg">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-black">Artikel</h5>
            <p class="font-normal text-black">{{ $data['artikel'] }}</p>
        </a>  
        <a href="#" class="block max-w-lg p-6 bg-white shadow-xl rounded-lg">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-black">Kasus</h5>
            <p class="font-normal text-black">{{ $data['kasus'] }}</p>
        </a>  
        <a href="#" class="block max-w-lg p-6 bg-white shadow-xl rounded-lg">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-black">Pengguna</h5>
            <p class="font-normal text-black">{{ $data['pengguna'] }}</p>
        </a> 
    </div>
</div>

@endSection()

@section('script')

<script>
    
</script>

@endSection()