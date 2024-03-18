<div class="bg-[#046db9] min-w-[250px] shadow-lg border-r border-r-black" id="sidebar" data-toggle-sidebar>
    <div class="p-5">
        <div class="mb-10 flex justify-between">
            <div class="flex justify-center items-center">
                <a href="{{ route('dashboard') }}">
                    <h1 class="text-white font-bold text-4xl">{{ config('app.name') }}</h1>
                </a>
            </div>
            <div class="flex justify-center items-center">
                <a href="#toggleSidebar" id="toggleButton">
                    <svg class="w-7 h-7 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="flex justify-start items-center text-white text-lg font-semibold">
            <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M12 20a8 8 0 0 1-5-1.8v-.6c0-1.8 1.5-3.3 3.3-3.3h3.4c1.8 0 3.3 1.5 3.3 3.3v.6a8 8 0 0 1-5 1.8ZM2 12a10 10 0 1 1 10 10A10 10 0 0 1 2 12Zm10-5a3.3 3.3 0 0 0-3.3 3.3c0 1.7 1.5 3.2 3.3 3.2 1.8 0 3.3-1.5 3.3-3.3C15.3 8.6 13.8 7 12 7Z" clip-rule="evenodd"/>
            </svg>      
            {{ Auth::user()->name }}      
        </div>
        <div class="w-full h-[1px] bg-white mb-5"></div>
        <div class="text-white text-sm font-thin">
            <ul>
                <li class="p-2 my-2 rounded-lg 
                    @if (Route::currentRouteName() == 'dashboard')
                        bg-white text-black border border-black
                    @else 
                        hover:bg-white hover:text-black
                    @endif">
                    <a class="flex" href="{{ route('dashboard') }}">
                        <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19c0 .6.4 1 1 1h3v-3c0-.6.4-1 1-1h2c.6 0 1 .4 1 1v3h3c.6 0 1-.4 1-1v-8.5"/>
                        </svg>
                        <div>
                            Beranda
                        </div>
                    </a>
                </li>
                @if (Auth::user()->role === 'admin')
                <li class="p-2 my-2 rounded-lg
                    @if (Route::currentRouteName() == 'artikel')
                        bg-white text-black border border-black
                    @else 
                        hover:bg-white hover:text-black 
                    @endif">
                    <a class="flex" href="{{ route('artikel') }}">
                        <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3c.6 0 1 .4 1 1v15c0 .6-.4 1-1 1H6a1 1 0 0 1-1-1V5c0-.6.4-1 1-1h3m0 3h6m-3 5h3m-6 0h0m3 4h3m-6 0h0m1-13v4h4V3h-4Z"/>
                        </svg>
                        <div>
                            Artikel
                        </div>
                    </a>
                </li>
                <li class="p-2 my-2 rounded-lg
                    @if (Route::currentRouteName() == 'kasus' || Route::currentRouteName() == 'daerah' || Route::currentRouteName() == 'poi' || Route::currentRouteName() == 'user' || Route::currentRouteName() == 'kasus.category' || Route::currentRouteName() == 'poi.category' || Route::currentRouteName() == 'artikel.category')
                        bg-white text-black border border-black
                    @else 
                        hover:bg-white hover:text-black 
                    @endif">
                    <button type="button" class="flex items-center w-full" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 6c0 1.7-3.1 3-7 3S5 7.7 5 6m14 0c0-1.7-3.1-3-7-3S5 4.3 5 6m14 0v6M5 6v6m0 0c0 1.7 3.1 3 7 3s7-1.3 7-3M5 12v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/>
                        </svg>
                        <span class="flex-1 text-left rtl:text-right whitespace-nowrap">Data Master</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <li class="rounded-lg 
                        @if (Route::currentRouteName() == 'kasus')
                            bg-[#046db9] text-white border border-black
                        @else 
                            hover:bg-[#046db9] hover:text-white
                        @endif">
                            <a href="{{ route('kasus') }}" class="flex items-center w-full p-2">Data Kasus</a>
                        </li>
                        <li class="rounded-lg
                        @if (Route::currentRouteName() == 'daerah')
                            bg-[#046db9] text-white border border-black
                        @else 
                            hover:bg-[#046db9] hover:text-white
                        @endif">
                            <a href="{{ route('daerah') }}" class="flex items-center w-full p-2">Data Daerah</a>
                        </li>
                        <li class="rounded-lg
                        @if (Route::currentRouteName() == 'poi')
                            bg-[#046db9] text-white border border-black
                        @else 
                            hover:bg-[#046db9] hover:text-white
                        @endif">
                            <a href="{{ route('poi') }}" class="flex items-center w-full p-2">Data Point Of Interest</a>
                        </li>
                        <li class="rounded-lg
                        @if (Route::currentRouteName() == 'user')
                            bg-[#046db9] text-white border border-black
                        @else 
                            hover:bg-[#046db9] hover:text-white
                        @endif">
                            <a href="{{ route('user') }}" class="flex items-center w-full p-2">Data Pengguna</a>
                        </li>
                        <li class="rounded-lg
                        @if (Route::currentRouteName() == 'poi.category')
                            bg-[#046db9] text-white border border-black
                        @else 
                            hover:bg-[#046db9] hover:text-white
                        @endif">
                            <a href="{{ route('poi.category') }}" class="flex items-center w-full p-2">Data Kategori Point Of Interest</a>
                        </li>
                        <li class="rounded-lg
                        @if (Route::currentRouteName() == 'kasus.category')
                            bg-[#046db9] text-white border border-black
                        @else 
                            hover:bg-[#046db9] hover:text-white
                        @endif">
                            <a href="{{ route('kasus.category') }}" class="flex items-center w-full p-2">Data Kategori Penyebab Kasus</a>
                        </li>
                    </ul>
                </li>
                @elseif (Auth::user()->role === 'dinkes' or 'bidan')
                <li class="p-2 my-2 rounded-lg
                    @if (Route::currentRouteName() == 'kasus')
                        bg-white text-black border border-black
                    @else 
                        hover:bg-white hover:text-black 
                    @endif">
                    <a class="flex" href="{{ route('kasus') }}">
                        <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3c.6 0 1 .4 1 1v15c0 .6-.4 1-1 1H6a1 1 0 0 1-1-1V5c0-.6.4-1 1-1h3m0 3h6m-3 5h3m-6 0h0m3 4h3m-6 0h0m1-13v4h4V3h-4Z"/>
                        </svg>
                        <div>
                            Kasus
                        </div>
                    </a>
                </li>
                <li class="p-2 my-2 rounded-lg
                    @if (Route::currentRouteName() == 'poi')
                        bg-white text-black border border-black
                    @else 
                        hover:bg-white hover:text-black 
                    @endif">
                    <a class="flex" href="{{ route('poi') }}">
                        <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z"/>
                        </svg>  
                        <div>
                            Point Of Interest
                        </div>
                    </a>
                </li>
                @endif
                <li class="p-2 my-2 rounded-lg
                    @if (Route::currentRouteName() == 'profile')
                        bg-white text-black border border-black
                    @else 
                        hover:bg-white hover:text-black 
                    @endif">
                    <a class="flex" href="{{ route('profile', Auth::user()->id) }}">
                        <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.3-.6-1-1-1.6-1H7.6c-.7 0-1.3.4-1.6 1M4 5h16c.6 0 1 .4 1 1v12c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1V6c0-.6.4-1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                        </svg>
                        <div>
                            Profile
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="sticky bottom-0">
                <li class="p-2 my-2 font-semibold text-red-500 rounded-lg">
                    <a class="flex" href="#" onclick="event.preventDefault(); Logout();">
                        <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                        </svg>
                        <div>
                            Logout
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<a href="#" id="expandButton" class="hidden">
    <div class="p-5">
        <div class="flex justify-center items-center">
            <svg class="w-7 h-7 text-blue-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
            </svg>
        </div>
    </div>
</a>