@extends('layout.dashboard')

@section('content')

<div class="mt-5">
    <h1 class="text-2xl my-5">Selamat Datang di Halaman Beranda Sistem Informasi Angka Kematian Ibu Kabupaten Bondowoso</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <a href="#" class="block max-w-lg p-6 bg-[#7BD3EA] text-gray-900 border border-black shadow-xl rounded-lg">
            <div class="flex justify-between">
                <h5 class="mb-2 text-2xl font-bold tracking-tight ">Artikel</h5>
                <svg class="w-12 h-12 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M7.1 20A3.1 3.1 0 0 1 4 16.9v-12c0-.5.4-.9.9-.9h4.4c.5 0 1 .4 1 .9v12c0 1.7-1.5 3.1-3.2 3.1Zm0 0h12c.5 0 .9-.4.9-.9v-4.4c0-.5-.4-1-.9-1h-4.4l-.6.3-3.8 3.7-.1.2c-.9 1.4-1.6 1.8-3 2.1Zm0-3.6h0m8-10.9 3.1 3.2c.3.3.3.9 0 1.2l-8 8V9l3.6-3.6c.3-.3 1-.3 1.3 0Z"/>
                </svg>
            </div>
            <p class="font-bold text-2xl ">{{ $data['artikel'] }}</p>
        </a>  
        <a href="#" class="block max-w-lg p-6 bg-[#A1EEBD] text-gray-900 border border-black shadow-xl rounded-lg">
            <div class="flex justify-between">
                <h5 class="mb-2 text-2xl font-bold tracking-tight ">Kasus</h5>
                <svg class="w-12 h-12 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                </svg>
            </div>
            <p class="font-bold text-2xl ">{{ $data['kasus'] }}</p>
        </a>  
        <a href="#" class="block max-w-lg p-6 bg-[#F6F7C4] text-gray-900 border border-black shadow-xl rounded-lg">
            <div class="flex justify-between">
                <h5 class="mb-2 text-2xl font-bold tracking-tight ">Pengguna</h5>
                <svg class="w-12 h-12 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </div>
            <p class="font-bold text-2xl ">{{ $data['pengguna'] }}</p>
        </a> 
    </div>
</div>

<div class="flex justify-between w-full">
    <div class="my-5 mr-5 max-w-sm w-full bg-white border border-black rounded-lg shadow p-4 md:p-6">
        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center me-3">
                    <svg class="w-6 h-6 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                        <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                        <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="leading-none text-2xl font-bold text-gray-900  pb-1">Kasus</h5>
                </div>
            </div>
        </div>
        <div id="column-chart"></div>
    </div>
    <div id="map" class="my-5 rounded-lg w-full h-[550px] border border-black"></div>
</div>


@endSection()

@section('script')

<script>
    const options = {
        colors: ["#1A56DB"],
        series: [
            {
                name: "Organic",
                color: "#1A56DB",
                data: [
                    { x: "Mon", y: 231 },
                    { x: "Tue", y: 122 },
                    { x: "Wed", y: 63 },
                    { x: "Thu", y: 421 },
                    { x: "Fri", y: 122 },
                    { x: "Sat", y: 323 },
                    { x: "Sun", y: 111 },
                ],
            },
        ],
        chart: {
            type: "bar",
            height: "320px",
            fontFamily: "Inter, sans-serif",
            toolbar: {
            show: false,
            },
        },
        plotOptions: {
            bar: {
            horizontal: false,
            columnWidth: "70%",
            borderRadiusApplication: "end",
            borderRadius: 8,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: {
            fontFamily: "Inter, sans-serif",
            },
        },
        states: {
            hover: {
            filter: {
                type: "darken",
                value: 1,
            },
            },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: false,
            strokeDashArray: 4,
            padding: {
            left: 2,
            right: 2,
            top: -14
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        xaxis: {
            floating: false,
            labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500'
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
        fill: {
            opacity: 1,
        },
    }

    if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("column-chart"), options);
        chart.render();
    }

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
    
    $(document).ready(function() {
        getGeojsonDaerah();
        getGeojsonPoi();
    });
</script>

@endSection()