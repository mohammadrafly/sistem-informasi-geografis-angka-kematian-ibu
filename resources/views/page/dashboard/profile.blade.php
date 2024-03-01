@extends('layout.dashboard')

@section('content')

<div class="text-xl font-bold">
    {{ $data['title'] }}
</div>

<div class="mt-5"> 
    <form id="profileForm">
        @csrf
        <div class="grid gap-6 mb-6">
            <div class="mb-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" class="text-black text-sm rounded-lg focus:ring-blue-300 focus:border-blue-300 block w-full p-2.5" placeholder="Masukkan Nama" required />
                <input type="text" id="id" name="id" hidden value="{{Auth::user()->id}}">
            </div> 
            <div class="mb-2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="text-black text-sm rounded-lg focus:ring-blue-300 focus:border-blue-300 block w-full p-2.5" placeholder="Masukkan Email" required />
            </div> 
            <div class="mb-2">
                <label for="role" class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                <input disabled type="text" id="role" name="role" class="text-black text-sm rounded-lg bg-gray-300 focus:ring-blue-300 focus:border-blue-300 block w-full p-2.5" placeholder="Role" required />
            </div> 
        <button type="button" onclick="updateProfile()" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
    </form>
</div>

<div class="text-xl mt-10 font-semibold">
    Update Password
</div>

<div class="mt-5"> 
    <form id="passwordForm">
        @csrf
        <div class="grid gap-6 mb-6">
            <div class="mb-2">
                <label for="old_password" class="block mb-2 text-sm font-medium text-gray-700">Password Lama</label>
                <input type="password" id="old_password" name="old_password" class="text-black text-sm rounded-lg focus:ring-blue-300 focus:border-blue-300 block w-full p-2.5" placeholder="Masukkan Password Lama" required />
            </div> 
            <div class="mb-2">
                <label for="new_password" class="block mb-2 text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" id="new_password" name="new_password" class="text-black text-sm rounded-lg focus:ring-blue-300 focus:border-blue-300 block w-full p-2.5" placeholder="Masukkan Password Baru" required />
            </div> 
            <div class="mb-2">
                <label for="new_password_konfirmasi" class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" id="konfirmasi_new_password" name="konfirmasi_new_password" class="text-black text-sm rounded-lg focus:ring-blue-300 focus:border-blue-300 block w-full p-2.5" placeholder="Masukkan Konfirmasi Password Baru" required />
            </div> 
        <button type="button" onclick="updatePassword()" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
    </form>
</div>

@endSection()

@section('script')

<script>
$(document).ready(function() {
    profile();
});

function profile() {
    const id = $('#id').val();   
    $.ajax({
        url: BASEURL + 'dashboard/profile/' + id,
        type: 'GET',
        success: function(response) {
            $('#name').val(response.message.name);
            $('#email').val(response.message.email);
            $('#role').val(response.message.role);
        },
        error: function(error) {
            console.error('Error getting profile:', error.responseText);
        }
    });
}

function updateProfile() {
    const id = $('#id').val();   
    const formData = $('#profileForm').serialize();
    ajaxRequest('dashboard/profile/' + id, 'POST', formData,
        function(response) {
            alert(response.message);
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save profile. Please try again later.');
        }
    );
}

function updatePassword() {
    const id = $('#id').val();   
    const formData = $('#passwordForm').serialize();
    ajaxRequest('dashboard/profile/password/' + id, 'POST', formData,
        function(response) {
            alert(response.message);
        },
        function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Failed to save password. Please try again later.');
        }
    );
}
</script>

@endSection()