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
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kelahiran Hidup</label>
            <input type="number" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" name="kelahiran_hidup" id="kelahiran_hidup" placeholder="Masukkan Jumalah Kelahiran Hidup" required>
        </div>
        <div class="mb-4">
            <label for="hs-color-input" class="block mb-2 text-sm font-medium text-black">Pilih Warna</label>
            <input type="color" class="w-full border p-2 rounded border-gray-300 bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" id="warna" name="warna" title="Choose your color">
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-black" for="geojson">Upload file geojson</label>
            <input class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50 text-gray-400 focus:outline-none placeholder-gray-500" aria-describedby="file_input_help" name="geojson" id="geojson" type="file" required>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="geojson">.geojson Only*</p>
        </div>
        <button type="button" onclick="saveDaerah()" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>

<div class="relative overflow-x-auto shadow-lg rounded-lg mt-5 p-5 bg-gray-50 border border-black">
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:placeholder-gray-400 dark:text-white" placeholder="Cari data">
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
                    Kelahiran Hidup
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
    var allLayers = {}; // To keep track of all daerah layers

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

                    allLayers[featureData.nama_daerah] = LayerDaerah;
                });

                addLegend(); // Add legend after layers are created
            },
            error: function(xhr, status, error) {
                console.error('Error fetching GeoJSON:', error);
            }
        });
    }

    var allPois = [];

    function getGeojsonPoi() {
        const url = BASEURL + 'dashboard/poi/get-poi';
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const dataArray = data;
                dataArray.forEach(featureData => {
                    const Poi = createGeoJSONFeature(JSON.parse(featureData.geojson.replace(/"/g, '')));
                    const LayerPoi = L.geoJSON(Poi, {
                        style: {
                            fillColor: featureData.warna,
                            color: featureData.warna,
                            weight: 2
                        },
                        pointToLayer: function(feature, latlng) {
                            const iconUrl = featureData.category.nama_category === 'AKI' ? `
                                <svg class="w-5 h-5 bg-white rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="${featureData.warna}" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                </svg>
                            ` : `
                                <svg class="w-5 h-5 bg-white rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="${featureData.warna}" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                                </svg>
                            `;

                            return L.marker(latlng, {
                                icon: L.divIcon({
                                    html: iconUrl,
                                    iconSize: [1, 1],
                                    iconAnchor: [5, 5]
                                })
                            });
                        },
                        onEachFeature: function(feature, layer) {
                            layer.category = featureData.category.nama_category;
                            allPois.push(layer);
                            layer.on('click', function(e) {
                                const rumahSakitPois = allPois.filter(poi => poi.category === 'Rumah Sakit');

                                const nearestRumahSakitPoi = L.GeometryUtil.closestLayer(map, rumahSakitPois, e.latlng);
                                const nearestRumahSakitPoiLatLng = nearestRumahSakitPoi.latlng;

                                const namaValue = 'Nama: ' + featureData.kasus?.nama ?? '';
                                const alamatValue = 'Alamat: ' + featureData.kasus?.alamat ?? '';
                                const tanggalKematianValue = 'Tanggal Kematian: ' + featureData.kasus?.tanggal ?? '';
                                const usiaValue = 'Usia Ibu: ' + featureData.kasus?.usia_ibu ?? '';
                                const penyebabValue = 'Penyebab Kematian: ' + featureData.penyebab?.nama_category ?? '';
                                const estafetValue = 'Estafet Rujukan: ' + featureData.kasus?.estafet_rujukan ?? '';
                                const alurValue = 'Alur: ' + featureData.kasus?.alur ?? '';
                                const masaValue = 'Masa Kematian: ' + featureData.kasus?.masa_kematian ?? '';
                                let content = '';
                                let roundedDistance = '';

                                const matchingFeatureData = dataArray.find(featureDataItem => {
                                    const coordinatesString = featureDataItem.geojson;
                                    const coordinatesArray = JSON.parse(coordinatesString);
                                    const formattedCoordinates = {
                                        lat: coordinatesArray[1],
                                        lng: coordinatesArray[0]
                                    };
                                    const featureDataLatLng = L.latLng(formattedCoordinates);
                                    return match = featureDataLatLng.equals(nearestRumahSakitPoiLatLng);
                                });

                                const coordinatesString = featureData.geojson;
                                const coordinatesArray = JSON.parse(coordinatesString);
                                const featureDataLatLng = L.latLng(coordinatesArray[1], coordinatesArray[0]);
                                const distanceInMeters = featureDataLatLng.distanceTo(nearestRumahSakitPoiLatLng);
                                roundedDistance = Math.round(distanceInMeters);

                                if (featureData.category.nama_category === 'AKI') {
                                    content = `
                                    <p>
                                        ${namaValue ?? ''} <br/>
                                        ${alamatValue ?? ''} <br/>
                                        ${tanggalKematianValue ?? ''} <br/>
                                        ${usiaValue ?? ''} <br/>
                                        ${penyebabValue ?? ''} <br/>
                                        ${estafetValue ?? ''} <br/>
                                        ${alurValue ?? ''} <br/>
                                        ${masaValue ?? ''} <br/>
                                        <p>Rumah Sakit terdekat: ${matchingFeatureData.nama_titik} (${roundedDistance} Meter)</p>
                                    </p>
                                    `;
                                }

                                const popupContent = `
                                    <h4>${featureData.nama_titik} - ${featureData.category.nama_category}</h4>
                                    ${content}
                                `;

                                const popup = L.popup({ closeButton: true })
                                    .setContent(popupContent)
                                    .setLatLng(e.latlng);

                                popup.openOn(map);
                            });
                        }
                    }).addTo(map);
                });
            })
            .catch(error => {
                console.error('Error fetching GeoJSON:', error);
            });
    }

    $(document).ready(function() {
        getGeojsonDaerah();
        getGeojsonPoi();
    });

    function addLegend() {
        var legend = L.control({ position: 'topright' });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'info legend bg-white p-4 rounded-lg border border-black');
            Object.keys(allLayers).forEach(function(key) {
                div.innerHTML += `<div>
                                    <input type="checkbox" id="toggle-${key}" checked onchange="toggleLayer('${key}')">
                                    <label for="toggle-${key}">${key}</label>
                                  </div>`;
            });

            return div;
        };

        legend.addTo(map);
    }

    function toggleLayer(key) {
        if (allLayers[key]) {
            if (map.hasLayer(allLayers[key])) {
                map.removeLayer(allLayers[key]);
            } else {
                map.addLayer(allLayers[key]);
            }
        }
    }

</script>

<script src="{{ asset('assets/js/Daerah.js') }}"></script>

@endSection()
