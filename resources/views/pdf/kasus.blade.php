<!DOCTYPE html>
<html>
<head>
    <title>Data Kematian Ibu - Provinsi Jawa Timur</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl flex justify-center items-center font-bold mb-4">Data Kematian Ibu Provinsi Jawa Timur</h2>
        <div class="flex mb-4">
            <div>
                <span class="font-bold">Kab/Kota:</span> Bondowoso
            </div>
            <div>
                <span class="font-bold">Tahun:</span> {{ $year }}
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">No</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Nama Istri/Suami</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Alamat</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Tanggal Kematian</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Usia Ibu (thn)</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Gravida</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Penyebab Kematian</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Masa Kematian</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Tempat Kematian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td class="px-4 py-2 border border-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->nama }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->alamat }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->tanggal }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->usia_ibu }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->gravida }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->category->nama_category }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->category->masa_kematian }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->tempat_kematian }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
