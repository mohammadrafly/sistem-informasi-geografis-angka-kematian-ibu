<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | {{ $data['title'] }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tiny.cloud/1/a2k2kudtwwpqcx67oeeolwlri3t7q1ywzs753smm3u0wn2og/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
</head>
<body>
    <div class="bg-[#d8fbf7] flex min-h-screen">
        @include('layout.partials.sidebar')
        <div class="m-10 w-full">
            @include('layout.partials.navbar_dashboard')
            <div class="my-5">
                @include('layout.partials.flash_message')
            </div>
            @yield('content')
            <footer class="sticky mt-10 bottom-0">
                <div class="w-full max-w-screen-xl">
                    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y')}} {{ config('app.name') }}. All Rights Reserved.
                    </span>
                </div>
            </footer>            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.10.3/src/leaflet.geometryutil.min.js"></script>
    <script src="{{ asset('assets/js/App.js') }}"></script>
    @vite('resources/js/app.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @include('layout.partials.notification')
    @yield('script')
</body>
</html>