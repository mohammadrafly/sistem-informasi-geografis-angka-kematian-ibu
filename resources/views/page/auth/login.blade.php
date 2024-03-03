@extends('layout.auth')

@section('content')

<div class="bg-white rounded-lg shadow-xl">
    <div class="w-[500px] h-[500px] pt-10 px-10">
        <div class="flex flex-col items-center justify-center mt-10">
            <h1 class="text-4xl font-semibold text-[#046db9]">Selamat Datang</h1>
            <p class="mt-4 text-lg text-gray-700">Silahkan masuk ke akun Anda.</p>
        </div>
        <div class="w-full">
            <form id="formLogin" onsubmit="event.preventDefault(); Login();">
                @csrf
                <div class="pt-10 text-sm">
                    <div for="email" class="py-1">Email</div>
                    <input class="border rounded-lg p-2 w-full text-sm bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" type="email" name="email" id="email" placeholder="Masukkan Email">
                </div>
                <div class="pt-5 pb-5 text-sm">
                    <div for="password" class="py-1">Password</div>
                    <input class="border rounded-lg p-2 w-full text-sm bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" type="password" name="password" id="password" placeholder="Masukkan Password">
                </div>
                <button class="rounded-lg bg-[#046db9] hover:bg-blue-500 font-semibold text-white p-2 w-full">Masuk</button>
            </form>
        </div>
    </div>

    <div class="flex flex-col items-center justify-center p-5">
        <a class="bg-[#046db9] hover:bg-blue-500 p-2 rounded-lg text-white" href="{{route('home')}}">Kembali</a>
    </div>
</div>

@endSection()

@section('script')

<script src="{{ asset('assets/js/Auth.js') }}"></script>

@endSection()