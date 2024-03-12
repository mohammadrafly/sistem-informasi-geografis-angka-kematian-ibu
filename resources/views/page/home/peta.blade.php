@extends('layout.home')

@section('content')

<div class="my-10 rounded-lg">
    <div id="map" class="w-full min-h-screen rounded-lg"></div>
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

@endSection()