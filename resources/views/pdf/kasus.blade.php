<!DOCTYPE html>
<html>
<head>
    <title>Data Report Kasus</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Data Report Kasus</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-400">
                <thead>
                    <tr>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">ID</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Nama Ibu/Bapak</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Alamat</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Usia Ibu</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Tanggal Kematian</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Penyebab Kematian</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Tempat Kematian</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Estafet Rujukan</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Alur</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Masa Kematian</th>
                        <th class="px-4 py-2 bg-gray-200 text-gray-700 border border-gray-400">Hari Kematian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td class="px-4 py-2 border border-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->nama }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->alamat }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->usia_ibu }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->tanggal }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->category->nama_category }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->tempat_kematian }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->estafet_rujukan }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->alur }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->masa_kematian }}</td>
                        <td class="px-4 py-2 border border-gray-400">
                            @if($item->hari_kematian === '1')
                                Hari Kerja
                            @else 
                                Hari Libur
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
