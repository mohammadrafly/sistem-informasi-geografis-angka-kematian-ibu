@extends('layout.home')

@section('content')

<div class="my-10 rounded-lg">
    <div id="map" class="w-full min-h-screen rounded-lg"></div>
</div>

@endSection()

@section('script')

<script>
    var map = L.map('map').setView([-8.1805, 113.6856], 13);
    
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
                    var Daerah = createGeoJSONFeature(JSON.parse(featureData.geojson.replace(/"/g, '')),);

                    var LayerDaerah = L.geoJSON(Daerah, {
                        style: {
                            fillColor: featureData.warna,
                            color: featureData.warna,
                            weight: 2
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
                    var Poi = createGeoJSONFeature(JSON.parse(featureData.geojson.replace(/"/g, '')),);

                    var LayerPoi = L.geoJSON(Poi, {
                        style: {
                            fillColor: featureData.warna,
                            color: featureData.warna,
                            weight: 2
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