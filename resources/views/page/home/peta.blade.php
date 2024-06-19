@extends('layout.home')

@section('content')

<div class="text-center">
    <h1 class="font-bold text-2xl">PETA SEBARAN ANGKA KEMATIAN IBU BONDOWOSO</h1>
    <p class="font-bold">(Data dapat berubah sewaktu-waktu)</p>
</div>

<div>
    <label for="yearSelect">Pilih Tahun: </label>
    <select id="yearSelect" class="text-white mt-10 mb-2 bg-blue-500 rounded-lg p-2 border border-black">
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
    </select>
</div>
<div class="flex justify-between gap-5">
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

<div class="text-center mt-10">
    <h1 class="font-bold text-2xl">GRAFIK SEBARAN ANGKA KEMATIAN IBU BONDOWOSO</h1>
    <p class="font-bold">(Data dapat berubah sewaktu-waktu)</p>
</div>

<div class="grid grid-cols-3 gap-5 h-[500px]">
    <div class="my-5 mr-5 w-full bg-white border border-black rounded-lg shadow p-4 md:p-6">
        <div class="font-semibold">Data Kasus/Tahun</div>
        <div id="line-chart"></div>
    </div>
    <div class="my-5 mr-5 w-full bg-white border border-black rounded-lg shadow p-4 md:p-6">
        <div class="font-semibold">Data Kasus/Penyebab</div>
        <div id="line-chart-penyebab"></div>
    </div>
    <div class="my-5 mr-5 w-full bg-white border border-black rounded-lg shadow p-4 md:p-6">
        <div class="font-semibold">Data Penolong Pertama</div>
        <div id="line-chart-penolong"></div>
    </div>
</div>

@endSection()

@section('script')

<script>
    function fetchDataYear() {
        fetch('{{route('kasus.year.home')}}')
            .then(response => response.json())
            .then(data => {
                renderChart(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function renderChart(chartData) {
        const years = Object.keys(chartData);
            const latestYearIndex = years.length - 1;
            const maxYearsToShow = 5;

            let startYearIndex = Math.max(latestYearIndex - maxYearsToShow + 1, 0);
            if (years.length < maxYearsToShow) {
                startYearIndex = 0;
            }

            const slicedYears = years.slice(startYearIndex);

            const formattedData = slicedYears.map(year => ({ x: year, y: chartData[year] }));
            const options = {
                chart: {
                    height: "100%",
                    maxWidth: "100%",
                    type: "bar",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                    enabled: false,
                    },
                    toolbar: {
                    show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    x: {
                    show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: {
                    left: 2,
                    right: 2,
                    top: -26
                    },
                },
                series: [
                    {
                    name: "Kasus",
                    data: formattedData,
                    color: "#1A56DB",
                    },
                ],
                legend: {
                    show: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: slicedYears,
                    labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                    },
                    axisBorder: {
                    show: false,
                    },
                    axisTicks: {
                    show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
            }

        if (document.getElementById("line-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("line-chart"), options);
            chart.render();
        }
    }

    function fetchDataPenyebab() {
        fetch('{{route('kasus.kategori.home')}}')
            .then(response => response.json())
            .then(data => {
                renderChartPenyebab(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function renderChartPenyebab(chartData) {
        const categories = Object.keys(chartData);
        const formattedData = categories.map(category => ({ x: category, y: chartData[category] }));

        const options = {
            chart: {
                height: "100%",
                maxWidth: "100%",
                type: "bar",
                fontFamily: "Inter, sans-serif",
                dropShadow: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 6,
            },
            grid: {
                show: true,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -26
                },
            },
            series: [
                {
                    name: "Kasus",
                    data: formattedData,
                    color: "#1A56DB",
                },
            ],
            legend: {
                show: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: categories,
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
            },
        }

        if (document.getElementById("line-chart-penyebab") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("line-chart-penyebab"), options);
            chart.render();
        }
    }

    function fetchDataPenolong() {
        fetch('{{route('kasus.penolong.home')}}')
            .then(response => response.json())
            .then(data => {
                renderChartPenolong(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function renderChartPenolong(chartData) {
        const penolong = Object.keys(chartData);
        const formattedData = penolong.map(penolong => ({ x: penolong === 'non_medis' ? 'Non Medis' : penolong === 'medis' ? 'Medis' : penolong, y: chartData[penolong] }));

        const options = {
            chart: {
                height: "100%",
                maxWidth: "100%",
                type: "bar",
                fontFamily: "Inter, sans-serif",
                dropShadow: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 6,
            },
            grid: {
                show: true,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -26
                },
            },
            series: [
                {
                    name: "Kasus",
                    data: formattedData,
                    color: "#1A56DB",
                },
            ],
            legend: {
                show: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: penolong.map(penolong => penolong === 'non_medis' ? 'Non Medis' : penolong === 'medis' ? 'Medis' : penolong), // Changing categories
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
            },
        }

        if (document.getElementById("line-chart-penolong") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("line-chart-penolong"), options);
            chart.render();
        }
    }

    window.addEventListener('load', () => {
        fetchDataYear();
        fetchDataPenyebab();
        fetchDataPenolong();
    });

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

    function getGeojsonDaerah(selectedYear) {
        $.ajax({
            url: BASEURL + 'peta/resiko/get-daerah',
            success: function(data) {
                var dataArray = data;

                console.log(dataArray)
                $.ajax({
                    url: BASEURL + 'peta/resiko/get-poi',
                    success: function(poiData) {
                        var kelahiranMati = 1;

                        var poiCounts = poiData.reduce(function(acc, poi) {
                            if (poi.category.nama_category === 'AKI' && poi.kasus && poi.kasus.tanggal) {
                                var poiYear = new Date(poi.kasus.tanggal).getFullYear();
                                if (poiYear === selectedYear) {
                                    var existingEntry = acc.find(entry => entry.daerah_id === poi.id_daerah);
                                    if (existingEntry) {
                                        var existingKasus = existingEntry.kasus || [];
                                        var existingKasusCount = existingKasus.find(kasus => kasus.jenis === poi.kasus.jenis);
                                        if (existingKasusCount) {
                                            existingKasusCount.total++;
                                            kelahiranMati++;
                                        } else {
                                            existingKasus.push({ jenis: poi.kasus.jenis, total: 1 }); // Default value of 1 for new kasus
                                            kelahiranMati++;
                                        }
                                    } else {
                                        acc.push({ id_daerah: poi.daerah_id, kasus: [{ jenis: poi.kasus.jenis, total: 1 }] }); // Default value of 1 for new entry
                                        kelahiranMati++;
                                    }
                                }
                            }
                            return acc;
                        }, []);

                        function getColor(count) {
                            if (count <= 126) return 'green';
                            if (count >= 127 && count <= 189) return 'yellow';
                            if (count >= 190) return 'red';
                        }

                        dataArray.forEach(function(featureData) {
                            var kelahiranHidup = featureData.kelahiran_hidup;
                            console.log(featureData)
                            var Daerah = createGeoJSONFeature(JSON.parse(featureData.geojson.replace(/"/g, '')));
                            var poiDataForDaerah = poiCounts.find(poi => poi.id_daerah === featureData.id) || { kasus: [] };
                            var finalColor = getColor(kelahiranMati ?? 1 / kelahiranHidup ?? 1);
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
                                            layer.setStyle({ fillOpacity: 0.5 });
                                        },
                                        mouseout: function(e) {
                                            layer.setStyle({ fillOpacity: 0.4 });
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
    let allLayers = [];

    function getGeojsonPoi(selectedYear) {
            const url = BASEURL + 'peta/resiko/get-poi';
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const filteredData = data.filter(featureData => {
                        if (featureData.category.nama_category === 'Rumah Sakit') {
                            return true;
                        }
                        if (featureData.kasus && featureData.kasus.tanggal) {
                            const poiYear = new Date(featureData.kasus.tanggal).getFullYear();
                            return poiYear === selectedYear;
                        }
                        return false;
                    });

                    geojsonLayerGroup.clearLayers();
                    allPois = [];

                    filteredData.forEach(featureData => {
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
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="${featureData.warna}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5  bg-white rounded-full">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
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
                                    const deskripsiValue = formatValue(featureData.penyebab?.deskripsi);
                                    const estafetValue = formatValue(featureData.kasus?.estafet_rujukan);
                                    const alurValue = `${alurNames.join(' -> ')}`;
                                    const masaValue = formatValue(featureData.kasus?.masa_kematian);

                                    let content = '';
                                    let roundedDistance = '';

                                    const matchingFeatureData = filteredData.find(featureDataItem => {
                                        const coordinatesString = featureDataItem.geojson;
                                        const coordinatesArray = JSON.parse(coordinatesString);
                                        const formattedCoordinates = {
                                            lat: coordinatesArray[1],
                                            lng: coordinatesArray[0]
                                        };
                                        const featureDataLatLng = L.latLng(formattedCoordinates);
                                        return featureDataLatLng.equals(nearestRumahSakitPoiLatLng);
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
                                            Alamat   : ${alamatValue ?? ''}<br/>
                                            Tanggal  : ${tanggalKematianValue ?? ''}<br/>
                                            Usia     : ${usiaValue ?? ''}<br/>
                                            Penyebab : ${penyebabValue ?? ''}<br/>
                                            Pencegahan : ${deskripsiValue} <br/>
                                            </p>
                                            <p>Rumah Sakit Rujukan: ${matchingFeatureData.nama_titik} (${roundedDistance} Meter)</p>
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
                        }).addTo(geojsonLayerGroup);
                    });
                })
                .catch(error => {
                    console.error('Error fetching GeoJSON:', error);
                });
        }

    document.getElementById('yearSelect').addEventListener('change', function() {
        var selectedYear = parseInt(this.value);
        geojsonLayerGroup.clearLayers();
        geojsonLayers = [];
        getGeojsonPoi(selectedYear);
        getGeojsonDaerah(selectedYear);
        populateTablePenyebab(selectedYear);
        populateTableTempat(selectedYear);
        fetchData(selectedYear);
    });

    document.getElementById('yearSelect').dispatchEvent(new Event('change'));

    $(document).ready(function() {
        var selectedYear = new Date().getFullYear();
        getGeojsonDaerah(selectedYear);

        var legend = L.control({ position: 'bottomleft' });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'info legend bg-white p-4 rounded-lg border border-black');
            div.innerHTML += '<h4 class="text-lg font-semibold mb-2">Status Risiko</h4>';
            div.innerHTML += `<div class="flex">
                                <div class="bg-red-500 px-5 m-1"></div>
                                <h1>Risiko Tinggi (>35/100.000 kelahiran hidup)</h1>
                            </div>`;
            div.innerHTML += `<div class="flex">
                                <div class="bg-yellow-400 px-5 m-1"></div>
                                <h1>Risiko Sedang (36-69 kelahiran hidup)</h1>
                            </div>`;
            div.innerHTML += `<div class="flex">
                                <div class="bg-green-500 px-5 m-1"></div>
                                <h1>Risiko Rendah (<70/100 kelahiran hidup)</h1>
                            </div>`;
            return div;
        };

        legend.addTo(map);
    });

    document.getElementById('yearSelect').addEventListener('change', function() {
        var selectedYear = parseInt(this.value);
        geojsonLayerGroup.clearLayers();
        geojsonLayers = [];
        getGeojsonPoi(selectedYear);
        getGeojsonDaerah(selectedYear);
        fetchData(selectedYear);
    });

    $(document).ready(function() {
        var year = parseInt(document.getElementById('yearSelect').value) || 2024;
        fetchData(year);
    });

    function fetchData(year) {
        $.ajax({
            url: `http://127.0.0.1:8000/get/jumlah/data`,
            data: { year: year },
            success: function(data) {
                populateTablePenyebab(year, data);
                populateTableTempat(year, data);
            },
            error: function(xhr) {
                console.error('Error:', xhr.statusText);
            }
        });
    }

    function populateTableTempat(selectedYear, data) {
        var tableBody = document.getElementById('tableTempat').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
        var groupCounts = {};

        if (data && data.message) {
            var groupTempat = data.message.groupTempat;
            if (groupTempat) {
                Object.keys(groupTempat).forEach(function(group) {
                    var count = groupTempat[group];
                    groupCounts[group] = count;
                    var row = '<tr><td class="px-4 py-2">' + group + '</td><td class="px-4 py-2 text-right">' + count + '</td></tr>';
                    tableBody.innerHTML += row;
                });
            }
        } else {
            console.error("Data or data.message is undefined or not in the expected format.");
        }
    }

    function populateTablePenyebab(selectedYear, data) {
        var tableBody = document.getElementById('tablePenyebab').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';
        var groupCounts = {};

        if (data && data.message) {
            var groupPenyebab = data.message.groupPenyebab;
            if (groupPenyebab) {
                Object.keys(groupPenyebab).forEach(function(group) {
                    var count = groupPenyebab[group];
                    var row = '<tr><td class="px-4 py-2">' + group + '</td><td class="px-4 py-2 text-right">' + count + '</td></tr>';
                    tableBody.innerHTML += row;
                });
            }
        } else {
            console.error("Data or data.message is undefined or not in the expected format.");
        }
    }
</script>

@endSection()
