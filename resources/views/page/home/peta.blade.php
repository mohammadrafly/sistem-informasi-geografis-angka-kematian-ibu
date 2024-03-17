@extends('layout.home')

@section('content')

<div class="text-center">
    <h1 class="font-bold text-2xl">PETA SEBARAN ANGKA KEMATIAN IBU BONDOWOSO</h1>
    <p class="font-bold">(Data dapat berubah sewaktu-waktu)</p>
</div>

<button onclick="refreshData()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Refresh Data</button>
<div class="my-10 flex justify-between gap-5">
    <div class="grid grid-cols-1 gap-5">
        <div class="bg-white w-96 border border-black rounded-lg">
            <table id="tablePenyebab" class="w-full mt-4">
                <thead>
                  <tr>
                    <th class="text-left px-4 py-2">Penyebab Kematian</th>
                    <th class="text-right px-4 py-2">Jumlah Kasus</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="bg-white w-96 border border-black rounded-lg">
            <table id="tableTempat" class="w-full mt-4">
                <thead>
                  <tr>
                    <th class="text-left px-4 py-2">Tempat Kematian</th>
                    <th class="text-right px-4 py-2">Jumlah Kasus</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex-grow">
        <div class="w-full min-h-screen rounded-lg border border-black">
            <div id="map" class="w-full min-h-screen rounded-lg">
                <div id="legend" class="leaflet-bottom leaflet-left"></div>
            </div>
            
        </div>
    </div>
</div>

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
            url: BASEURL + 'peta/resiko/get-daerah',
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
            url: BASEURL + 'peta/resiko/get-poi',
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
                        pointToLayer: function(feature, latlng) {
                            var iconUrl;
                            if (featureData.category.nama_category === 'AKI') {
                                iconUrl = `
                                    <svg class="w-5 h-5 bg-white rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="${featureData.warna}" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                    </svg>
                                `;
                            } else {
                                iconUrl = `
                                    <svg class="w-5 h-5 bg-white rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="${featureData.warna}" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                                    </svg>
                                `;
                            }

                            return L.marker(latlng, {
                                icon: L.divIcon({
                                    html: iconUrl,
                                    iconSize: [1, 1],
                                    iconAnchor: [5, 5]
                                })
                            });
                        },
                        onEachFeature: function(feature, layer) {
                            layer.on('click', function(e) {
                                //var clickedPoint = e.latlng;
                                //var distance = clickedPoint.distanceTo(map.getCenter());

                                const namaValue = 'Nama: ' + featureData.kasus?.nama ?? '';
                                const alamatValue = 'Alamat: ' + featureData.kasus?.alamat ?? '';
                                const tanggalKematianValue = 'Tanggal Kematian: ' + featureData.kasus?.tanggal ?? '';
                                const usiaValue = 'Usia Ibu: ' + featureData.kasus?.usia_ibu ?? '';
                                const penyebabValue = 'Penyebab Kematian: ' + featureData.penyebab?.nama_category ?? '';
                                const estafetValue = 'Estafet Rujukan: ' + featureData.kasus?.estafet_rujukan ?? '';
                                const alurValue = 'Alur: ' + featureData.kasus?.alur ?? '';
                                const masaValue = 'Masa Kematian: ' + featureData.kasus?.masa_kematian ?? '';
                                let content = '';

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
                                    </p>
                                    `;
                                }

                                var popupContent = `
                                    <h4>${featureData.nama_titik} - ${featureData.category.nama_category}</h4>   
                                    ${content}
                                    
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

    function refreshData() {
        $.ajax({
            url: '{{ route('peta') }}',
            success: function(data) {
                populateTablePenyebab(data);
                populateTableTempat(data);
            },
            error: function(xhr) {
                console.error('Error:', xhr.statusText);
            }
        });
    }

    $(document).ready(function() {
        getGeojsonDaerah();
        getGeojsonPoi();

        
        var legend = L.control({ position: 'bottomleft' });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'info legend bg-white p-4 rounded-lg border border-black');
            div.innerHTML += '<h4 class="text-lg font-semibold mb-2">Status Resiko</h4>';
            div.innerHTML += `<div class="flex"> 
                                <div class="bg-red-500 px-5 m-1"></div>
                                <h1>Resiko Tinggi</h1>
                              </div>`;
            div.innerHTML += `<div class="flex"> 
                                <div class="bg-yellow-500 px-5 m-1"></div>
                                <h1>Resiko Sedang</h1>
                              </div>`;
            div.innerHTML += `<div class="flex"> 
                                <div class="bg-green-500 px-5 m-1"></div>
                                <h1>Resiko Rendah</h1>
                              </div>`;
            return div;
        };

        legend.addTo(map);
    });

    $(document).ready(function() {
        $.ajax({
            url: '{{ route('peta') }}',
            success: populateTablePenyebab,
            error: function(xhr) { console.error('Error:', xhr.statusText); }
        });

        $.ajax({
            url: '{{ route('peta') }}',
            success: populateTableTempat,
            error: function(xhr) { console.error('Error:', xhr.statusText); }
        });
    });

    function populateTableTempat(data) {
        var tableBody = document.getElementById('tableTempat').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
        var groupCounts = {};

        if (data && data.success && data.message && data.message.groupTempat) {
            Object.keys(data.message.groupTempat).forEach(function(group) {
                var count = data.message.groupTempat[group];
                groupCounts[group] = count;
                var row = '<tr><td class="px-4 py-2">' + group + '</td><td class="px-4 py-2 text-right">' + count + '</td></tr>';
                tableBody.innerHTML += row;
            });
            console.log(groupCounts);
        } else {
            console.error("Data or data.message.groupTempat is undefined or not in the expected format.");
        }
    }

    function populateTablePenyebab(data) {
        var tableBody = document.getElementById('tablePenyebab').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
        var groupCounts = {};

        if (data && data.success && data.message && data.message.groupPenyebab) {
            Object.keys(data.message.groupPenyebab).forEach(function(group) {
                var count = data.message.groupPenyebab[group];
                groupCounts[group] = count;
                var row = '<tr><td class="px-4 py-2">' + group + '</td><td class="px-4 py-2 text-right">' + count + '</td></tr>';
                tableBody.innerHTML += row;
            });
            console.log(groupCounts);
        } else {
            console.error("Data or data.message.groupPenyebab is undefined or not in the expected format.");
        }
    }

</script>

@endSection()