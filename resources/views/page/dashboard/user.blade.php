@extends('layout.dashboard')

@section('content')

<button class="bg-blue-500 hover:bg-blue-700 border border-black text-white px-4 py-2 my-4 rounded" onclick="toggleCollapse('form')">
    Tambah {{ $data['title'] }}
</button>

<div id="form" class="hidden overflow-hidden border border-black transition-transform ease-in-out duration-300 max-h-0 bg-white p-5 rounded-lg shadow-lg">
    <form id="userForm" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
            <input type="text" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="name" id="name" placeholder="Masukkan Nama" required>
            <input type="number" id="id" name="id" hidden>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="email" id="email" placeholder="Masukkan Email" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
            <select type="text" class="disabled:bg-gray-300 w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="role" id="role" placeholder="Role" required>
                <option selected>Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="dinkes">Dinkes</option>
                <option value="bidan">Bidan</option>
            </select>
        </div>
        <div class="mb-4" id="password_section">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="password" id="password" placeholder="Masukkan Password" required>
        </div>
        <div class="mb-4" id="password_section2">
            <label for="konfirmasi_password" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
            <input type="password" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="konfirmasi_password" id="konfirmasi_password" placeholder="Masukkan Konfirmasi Password" required>
        </div>
        <button type="button" onclick="saveUser()" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
    </form>    
</div>

<div class="relative overflow-x-auto shadow-lg rounded-lg mt-5 p-5 bg-gray-50 border border-black">
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 kasusnter-events-none">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:placeholder-gray-400 dark:text-white0" placeholder="Cari data">
        </div>
    </div>
    <table id="userTable" class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Pengguna
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
        <span id="pagination-info" class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto"></span>
        <ul id="pagination" class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            <li>
                <a href="#" onclick="previousPage()" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg">Previous</a>
            </li>
            <li>
                <a href="#" onclick="nextPage()" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg">Next</a>
            </li>
        </ul>
    </nav>
</div>


@endSection()

@section('script')

<script src="{{ asset('assets/js/User.js') }}"></script>

@endSection()