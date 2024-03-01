@extends('layout.auth')

@section('content')

<div class="bg-white rounded-lg shadow-lg">
    <div class="w-[500px] h-[500px] p-10">
        <h1 class="text-center text-4xl font-semibold mt-5 text-blue-500">Selamat Datang</h1>
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
                <button class="rounded-lg bg-blue-500 font-semibold text-white p-2 w-full">Masuk</button>
            </form>
        </div>
    </div>
</div>

@endSection()

@section('script')

<script>
    async function Login() {
        const formData = $('#formLogin').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: BASEURL + 'login',
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#formLogin')[0].reset();
                    alert('Login Successful!');
                    window.location.href = BASEURL + 'dashboard';
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to Login. Please try again later.');
                }
            });
    }
</script>

@endSection()