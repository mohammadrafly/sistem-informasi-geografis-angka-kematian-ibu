<div class="bg-blue-400 w-[250px] shadow-lg" id="sidebar" data-toggle-sidebar>
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
        <div class="text-white">
            <ul>
                <li class="py-2">
                    <a href="{{ route('dashboard') }}">
                        Beranda
                    </a>
                </li>
                <li class="py-2">
                    <a href="#">
                        Data Master
                    </a>
                </li>
                <li class="py-2">
                    <a href="#" onclick="event.preventDefault(); Logout();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<a href="#" id="expandButton" class="hidden">
    <div class="p-5">
        <div class="flex justify-center items-center">
            <svg class="w-7 h-7 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
            </svg>
        </div>
    </div>
</a>