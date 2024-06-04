@extends('layout.dashboard')

@section('content')

<button class="bg-blue-500 hover:bg-blue-700 border border-black text-white px-4 py-2 my-4 rounded" onclick="toggleCollapse('form')">
    Tambah {{ $data['title'] }}
</button>

<form action="{{route('export.pdf')}}" method="post">
    @csrf
    <label for="">Start Date</label>
    <input type="date" name="start_date" id="start_date">
    <label for="">End Date</label>
    <input type="date" name="end_date" id="end_date">
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 border border-black text-white px-4 py-2 my-4 rounded">Export</button>
</form>

<div id="form" class="hidden overflow-hidden border border-black transition-transform ease-in-out duration-300 max-h-0 bg-white p-5 rounded-lg shadow-lg">
    <form id="kasusForm" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="usia_ibu" class="block text-gray-700 text-sm font-bold mb-2">Nama Istri/Suami</label>
            <input type="text" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="nama" id="nama" placeholder="Masukkan Usia Ibu" required>
            <input type="number" name="id" id="id" hidden>
        </div>
        <div class="mb-4">
            <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
            <input type="text" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="alamat" id="alamat" placeholder="Masukkan Alamat" required>
        </div>
        <div class="mb-4">
            <label for="usia_ibu" class="block text-gray-700 text-sm font-bold mb-2">Usia Ibu</label>
            <input type="number" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="usia_ibu" id="usia_ibu" placeholder="Masukkan Usia Ibu" required>
        </div>
        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
            <input type="date" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="tanggal" id="tanggal" required>
        </div>
        <div class="mb-4">
            <label for="id_penyebab" class="block text-gray-700 text-sm font-bold mb-2">Penyebab</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="id_category" id="id_category" required>
                <option selected disabled>Pilih Penyebab</option>
                @foreach($data['penyebab'] as $option)
                    <option value="{{ $option->id }}">{{ $option->nama_category }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="img" class="block mb-2 text-sm font-medium text-black">Bukti Kematian</label>
            <input class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-400" aria-describedby="file_input_help" name="bukti_kematian" id="bukti_kematian" type="file" required accept=".png, .jpg, .jpeg">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG, JPEG</p>
        </div>
        <div class="mb-4">
            <label for="masa_kematian" class="block text-gray-700 text-sm font-bold mb-2">Masa Kematian</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="pilih_masa" id="pilih_masa" onchange="toggleForm()">
                <option selected disabled>Pilih Masa Kematian</option>
                <option value="hamil">Hamil</option>
                <option value="persalinan">Persalinan</option>
                <option value="nifas">Nifas</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="tempat_kematian" class="block text-gray-700 text-sm font-bold mb-2">Tempat Kematian</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="tempat_kematian" id="tempat_kematian" required>
                <option selected disabled>Pilih Tempat Kematian</option>
                <option value="bpm">BPM</option>
                <option value="perjalanan">Perjalanan</option>
                <option value="puskesmas">Puskesmas</option>
                <option value="rumah_ibu">Rumah Ibu</option>
                <option value="rumah_sakit_umum">Rumah Sakit Umum</option>
                <option value="rumah_sakit_luar">Rumah Sakit Luar</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="alur" class="block text-gray-700 text-sm font-bold mb-2">Alur</label>
            <select multiple name="alur[]" id="alur" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option selected>Pilih Alur</option>
                @foreach($data['poi'] as $data)
                <option value="{{$data->id}}">{{$data->nama_titik}}</option>
                @endforeach
            </select>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Pilih sesuai urutan alur estafet, gunakan ctrl+klik kiri</p>
        </div>
        <div class="mb-4">
            <label for="estafet_rujukan" class="block text-gray-700 text-sm font-bold mb-2">Estafet Rujukan</label>
            <input type="text" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="estafet_rujukan" id="estafet_rujukan" placeholder="Masukkan Estafet Rujukan" required>
        </div>
        <div class="mb-4">
            <label for="gravida" class="block text-gray-700 text-sm font-bold mb-2">Gravida</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="gravida" id="gravida">
                <option selected disabled>Pilih Gravida</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="penolong_pertama" class="block text-gray-700 text-sm font-bold mb-2">Penolong Pertama</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="penolong_pertama" id="penolong_pertama">
                <option selected disabled>Pilih Penolong Pertama</option>
                <option value="non_medis">Non Medis</option>
                <option value="medis">Medis</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="jenis" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kematian</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="jenis" id="jenis">
                <option selected disabled>Pilih Jenis Kematian</option>
                <option value="kematian_mati">Kelahiran Mati</option>
                <option value="kematian_hidup">Kelahiran Hidup</option>
            </select>
        </div>
        <div id="form_hamil" class="masa-form hidden mb-4">
            <label for="umur_kehamilan" class="block text-gray-700 text-sm font-bold mb-2">Umur Kehamilan (Minggu)</label>
            <input type="text" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="umur_kehamilan" id="umur_kehamilan" placeholder="Masukkan Umur Kehamilan" required>
        </div>

        <div id="form_persalinan" class="masa-form hidden mb-4">
            <label for="< 6 Jam PP" class="block text-gray-700 text-sm font-bold mb-2">< 6 Jam PP</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="persalinan" id="persalinan" required>
                <option selected value="1">True</option>
            </select>
        </div>

        <div id="form_nifas" class="masa-form hidden mb-4">
            <label for="nifas" class="block text-gray-700 text-sm font-bold mb-2">Nifas</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="nifas" id="nifas">
                <option selected disabled>Pilih Nifas</option>
                <option value="0">6-24 Jam PP</option>
                <option value="1">1-3 Hari PP</option>
                <option value="2">4-28 Hari PP</option>
                <option value="3">29-42 Hari PP</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="hari_kematian" class="block text-gray-700 text-sm font-bold mb-2">Hari Kematian</label>
            <select class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="hari_kematian" id="hari_kematian" required>
                <option selected disabled>Pilih Hari Kematian</option>
                <option value="1">Hari Kerja</option>
                <option value="0">Hari Libur</option>
            </select>
        </div>
        <button type="button" onclick="saveKasus()" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
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
    <table id="kasusTable" class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama
                </th>
                <th scope="col" class="px-6 py-3">
                    Alamat
                </th>
                <th scope="col" class="px-6 py-3">
                    Usia Ibu
                </th>
                <th scope="col" class="px-6 py-3">
                    Tanggal
                </th>
                <th scope="col" class="px-6 py-3">
                    Penyebab Kematian
                </th>
                <th scope="col" class="px-6 py-3">
                    Bukti Kematian
                </th>
                <th scope="col" class="px-6 py-3">
                    Tempat Kematian
                </th>
                <th scope="col" class="px-6 py-3">
                    Estafet Rujukan
                </th>
                <th scope="col" class="px-6 py-3">
                    Alur
                </th>
                <th scope="col" class="px-6 py-3">
                    Masa Kematian
                </th>
                <th scope="col" class="px-6 py-3">
                    Hari Kematian
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

<script src="{{ asset('assets/js/Kasus.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const alurSelect = document.getElementById('alur');
    const estafetInput = document.getElementById('estafet_rujukan');

    alurSelect.addEventListener('change', function() {
        const selectedOptionsCount = alurSelect.selectedOptions.length;
        estafetInput.value = selectedOptionsCount + 'x';
    });
});

function toggleForm() {
    var selectedOption = document.getElementById("pilih_masa").value;
    var forms = document.getElementsByClassName("masa-form");

    for (var i = 0; i < forms.length; i++) {
        forms[i].style.display = "none";
    }

    document.getElementById("form_" + selectedOption).style.display = "block";
}
</script>

@endSection()
