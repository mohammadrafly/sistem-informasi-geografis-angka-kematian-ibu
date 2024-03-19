@extends('layout.home')

@section('content')

<div class="flex item-center">
    <div class="flex justify-between w-full">
        <div class="font-semibold">
            <div class="w-[500px]">
                <p class="text-2xl">Selamat Datang di Sistem Informasi Geografis Angka Kematian Ibu Dinas Kabupaten Bondowoso</p>
            </div>
        </div>
        <div class="w-full h-[500px] ml-5">
            <div id="map" class="w-full h-[500px] rounded-lg border border-black">
                <div id="legend" class="leaflet-bottom leaflet-left"></div>
            </div>
            <div id="colorToggleButtonContainer" class="my-5 p-2 w-fit rounded-lg bg-blue-500 text-white"></div>
        </div>
    </div>
</div>

@endSection()

@section('script')
<script>
    var map = L.map('map').setView([-7.923474796128599, 113.81854654735284], 13);

    var toggleState = false;
    var geojsonLayerGroup = L.layerGroup().addTo(map);
    var geojsonLayers = [];

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

    function toggleColor() {
        toggleState = !toggleState; 

        geojsonLayerGroup.clearLayers();
        geojsonLayers = [];

        getGeojsonDaerah();
    }

    var colorToggleButton = document.createElement('button');
    colorToggleButton.textContent = 'Mode';
    colorToggleButton.onclick = toggleColor;
    document.getElementById('colorToggleButtonContainer').appendChild(colorToggleButton);

    function getGeojsonDaerah() {
        $.ajax({
            url: BASEURL + 'peta/resiko/get-daerah',
            success: function(data) {
                var dataArray = data.message;

                $.ajax({
                    url: BASEURL + 'peta/resiko/get-poi',
                    success: function(poiData) {
                        var poiCounts = poiData.reduce(function(acc, poi) {
                            if (poi.category.nama_category === 'AKI') {
                                var existingEntry = acc.find(entry => entry.id_daerah === poi.id_daerah);
                                if (existingEntry) {
                                    existingEntry.total++;
                                } else {
                                    acc.push({id_daerah: poi.id_daerah, total: 1});
                                }
                            }
                            return acc;
                        }, []);

                        function getColor(count) {
                            if (count < 3) return 'green';
                            if (count >= 3 && count <= 6) return 'yellow';
                            if (count > 6) return 'red';
                        }

                        dataArray.forEach(function(featureData) {
                            var Daerah = createGeoJSONFeature(JSON.parse(featureData.geojson.replace(/"/g, '')));
                            var poiDataForDaerah = poiCounts.find(poi => poi.id_daerah === featureData.id) || {total: 0};
                            var color = getColor(poiDataForDaerah.total);
                            var finalColor = toggleState ? color : featureData.warna;

                            var LayerDaerah = L.geoJSON(Daerah, {
                                style: {
                                    fillColor: finalColor,
                                    color: finalColor,
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
                            }).addTo(geojsonLayerGroup);

                            geojsonLayers.push(LayerDaerah);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching POI data:', error);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching GeoJSON:', error);
            }
        });
    }

    let drawnLines = [];
    var allPois = [];
    let daerahPoiCounts = {};

    function getGeojsonPoi() {
        const url = BASEURL + 'peta/resiko/get-poi';
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
                                    iconSize: [0, 0],
                                    iconAnchor: [10, 10]
                                })
                            });
                        },
                        onEachFeature: function(feature, layer) {
                            layer.category = featureData.category.nama_category;
                            layer.name = featureData.nama_titik;
                            layer.id = featureData.id;
                            layer.alur = featureData.kasus === null ? '' : featureData.kasus.alur;
                            allPois.push(layer);
                            layer.on('click', function(e) {
                                drawnLines.forEach(line => map.removeLayer(line));
                                drawnLines = [];

                                const alurIds = layer.alur.split(',');

                                const alurLayers = allPois.filter(poi => alurIds.includes(poi.id.toString()));

                                alurLayers.sort((a, b) => alurIds.indexOf(a.id.toString()) - alurIds.indexOf(b.id.toString()));

                                alurLayers.forEach((alurLayer, index) => {
                                    const startPoint = index === 0 ? e.latlng : alurLayers[index - 1].getLatLng();
                                    const endPoint = alurLayer.getLatLng();

                                    const polyline = L.polyline([startPoint, endPoint], {
                                        color: 'green',
                                        dashArray: '5, 5'
                                    }).addTo(map);
                                    drawnLines.push(polyline);
                                });

                                const alurNames = alurIds.map(id => {
                                    const poi = allPois.find(poi => poi.id.toString() === id);
                                    return poi ? poi.name : '';
                                }).filter(name => name !== '');

                                const rumahSakitPois = allPois.filter(poi => poi.category === 'Rumah Sakit');
                                const nearestRumahSakitPoi = L.GeometryUtil.closestLayer(map, rumahSakitPois, e.latlng);
                                const nearestRumahSakitPoiLatLng = nearestRumahSakitPoi.latlng;

                                function formatValue(value) {
                                    return `${value ?? ''}`;
                                }

                                const namaValue = formatValue(featureData.kasus?.nama);
                                const alamatValue = formatValue(featureData.kasus?.alamat);
                                const tanggalKematianValue = formatValue(featureData.kasus?.tanggal);
                                const usiaValue = formatValue(featureData.kasus?.usia_ibu);
                                const penyebabValue = formatValue(featureData.penyebab?.nama_category);
                                const estafetValue = formatValue(featureData.kasus?.estafet_rujukan);
                                const alurValue = `${alurNames.join(' -> ')}`;
                                const masaValue = formatValue(featureData.kasus?.masa_kematian);

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
                                    <div class="font-sm">
                                        <p>
                                        Nama     : ${namaValue ?? ''}<br/>
                                        Alamat   : ${alamatValue ?? ''}<br/>
                                        Tanggal  : ${tanggalKematianValue ?? ''}<br/>
                                        Usia     : ${usiaValue ?? ''}<br/>
                                        Penyebab : ${penyebabValue ?? ''}<br/>
                                        Estafet  : ${estafetValue ?? ''} <br/>
                                        Alur     : ${alurValue ?? ''} <br/>
                                        Masa Kematian: ${masaValue ?? ''} <br/>
                                        </p>
                                        <p>Rumah Sakit terdekat: ${matchingFeatureData.nama_titik} (${roundedDistance} Meter)</p>
                                    </div>
                                    `;
                                }

                                const popupContent = `
                                    <h4 class="font-semibold">${featureData.nama_titik} - ${featureData.category.nama_category}</h4>   
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

        var legend = L.control({ position: 'bottomleft' });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'info legend bg-white p-4 rounded-lg border border-black');
            div.innerHTML += '<h4 class="text-lg font-semibold mb-2">Status Resiko</h4>';
            div.innerHTML += `<div class="flex"> 
                                <div class="bg-red-500 px-5 m-1"></div>
                                <h1>Resiko Tinggi</h1>
                            </div>`;
            div.innerHTML += `<div class="flex"> 
                                <div class="bg-yellow-400 px-5 m-1"></div>
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
</script>

@endSection()