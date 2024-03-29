@extends('layout.dashboard')

@section('content')

<button class="bg-blue-500 hover:bg-blue-700 border border-black text-white px-4 py-2 my-4 rounded" onclick="toggleCollapse('form')">
    Tambah {{ $data['title'] }}
</button>

<div id="form" class="hidden overflow-hidden border border-black transition-transform ease-in-out duration-300 max-h-0 bg-white p-5 rounded-lg shadow-lg">
    <form id="artikelForm" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
            <input type="text" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="title" id="title" placeholder="Masukkan Judul" required>
            <input type="number" id="id" name="id" hidden>
        </div>
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Artikel</label>
            <textarea class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" id="description" name="description"></textarea>
        </div>
        <div class="mb-4">
            <label for="published" class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <select type="text" class="disabled:bg-gray-300 w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="category" id="category" placeholder="Category" required>
                <option selected>Pilih Kategori</option>
                <option value="artikel">Artikel</option>
                <option value="informasi">Informasi</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="published" class="block text-gray-700 text-sm font-bold mb-2">Published</label>
            <select type="text" class="disabled:bg-gray-300 w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="published" id="published" placeholder="Published" required>
                <option selected>Pilih Status Published</option>
                <option value="1">Published</option>
                <option value="0">Unpublished</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-black" for="img">Upload file img</label>
            <input class="block w-full text-sm border border-gray-300 rounded-lg cursor-artikelnter bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-400" aria-describedby="file_input_help" name="img" id="img" type="file" required>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="img">.PNG , .JPG, .JPEG</p>
        </div>
        <button type="button" onclick="saveArtikel()" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
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
    <table id="artikelTable" class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Author
                </th>
                <th scope="col" class="px-6 py-3">
                    Artikel
                </th>
                <th scope="col" class="px-6 py-3">
                    Kategori
                </th>
                <th scope="col" class="px-6 py-3">
                    Img
                </th>
                <th scope="col" class="px-6 py-3">
                    Published
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

<script src="{{ asset('assets/js/Artikel.js') }}"></script>

@endSection()