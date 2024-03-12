@extends('layout.dashboard')

@section('content')

<button class="bg-blue-500 hover:bg-blue-700 border border-black text-white px-4 py-2 my-4 rounded" onclick="toggleCollapse('form')">
    Tambah {{ $data['title'] }}
</button>

<div id="form" class="hidden overflow-hidden border border-black transition-transform ease-in-out duration-300 max-h-0 bg-white p-5 rounded-lg shadow-lg">
    <form id="daerahForm" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Daerah</label>
            <input type="text" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="nama_daerah" id="nama_daerah" placeholder="Masukkan Nama Titik" required>
            <input type="number" id="id" name="id" hidden>
        </div>
        <div class="mb-4">
            <label for="hs-color-input" class="block mb-2 text-sm font-medium text-black">Pilih Warna</label>
            <input type="color" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" id="warna" name="warna" title="Choose your color">
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-black" for="geojson">Upload file geojson</label>
            <input class="block w-full text-sm border border-gray-300 rounded-lg cursor-daerahnter bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-400" aria-describedby="file_input_help" name="geojson" id="geojson" type="file" required>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="geojson">.geojson Only*</p>
        </div>
        <button type="button" onclick="saveDaerah()" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
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
    <table id="daerahTable" class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Daerah
                </th>
                <th scope="col" class="px-6 py-3">
                    Geojson
                </th>
                <th scope="col" class="px-6 py-3">
                    Warna
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

<div id="map" class="my-10 rounded-lg p-5 shadow-xl w-full h-96 border border-black"></div>

@endSection()

@section('script')

<script>
    var map = L.map('map').setView([-7.923474796128599, 113.81854654735284], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    function createGeoJSONFeature(coordinates) {
        return {
            "type": "FeatureCollection",
            "features": [
                {
                    "type": "Feature",
                    "properties": {},
                    "geometry": {
                        "coordinates": coordinates,
                        "type": coordinates.length === 2 ? "Point" : "Polygon"
                    }
                }
            ]
        };
    }

    function getGeojsonDaerah() {
        $.ajax({
            url: BASEURL + 'dashboard/daerah/get-daerah',
            success: function(data) {
            var dataArray = data.message;

            dataArray.forEach(function(featureData) {
                var Daerah = createGeoJSONFeature(JSON.parse(featureData.geojson.replace(/"/g, '')));

                var LayerDaerah = L.geoJSON(Daerah, {
                style: {
                    fillColor: featureData.warna,
                    color: featureData.warna,
                    weight: 2,
                    cursor: 'pointer'
                },
                onEachFeature: function(feature, layer) { 
                    layer.on({
                    mouseover: function(e) {
                        layer.setStyle({ fillOpacity: 0.3 });
                    },
                    mouseout: function(e) {
                        layer.setStyle({ fillOpacity: 0.2 });
                    },
                    click: function(e) {
                        var popupContent = featureData.nama_daerah;

                        if (popupContent) {
                            var popup = L.popup().setContent(popupContent);
                            layer.bindPopup(popup).openPopup();
                        } else {
                            console.warn('No popup content provided for this feature.');
                        }
                    }
                    });
                }
                }).addTo(map);
            });
            },
            error: function(xhr, status, error) {
            console.error('Error fetching GeoJSON:', error);
            }
        });
    }

    function getGeojsonPoi() {
        $.ajax({
            url: BASEURL + 'dashboard/poi/get-poi',
            success: function(data) {
            var dataArray = data.message;

            dataArray.forEach(function(featureData) {
                var Poi = createGeoJSONFeature(JSON.parse(featureData.geojson.replace(/"/g, '')));

                var LayerPoi = L.geoJSON(Poi, {
                    style: {
                        fillColor: featureData.warna,
                        color: featureData.warna,
                        weight: 2
                    },
                    onEachFeature: function(feature, layer) {
                        layer.on('click', function(e) {
                        var popupContent = `
                            <h4>${featureData.nama_titik} - ${featureData.category.nama_category}</h4>  
                            <p>${featureData.kasus.nama}</p>
                            <p></p>  
                        `;

                        var popup = L.popup({ closeButton: true })
                            .setContent(popupContent)
                            .setLatLng(e.latlng);

                        popup.openOn(map);
                        });
                    }
                }).addTo(map);
            });
            },
            error: function(xhr, status, error) {
            console.error('Error fetching GeoJSON:', error);
            }
        });
        }
    
    $(document).ready(function() {
        getGeojsonDaerah();
        getGeojsonPoi();
    });
</script>

<script src="{{ asset('assets/js/Daerah.js') }}"></script>

@endSection()