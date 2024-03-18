<div class="bg-[#046db9]">
    <div class="mx-24 h-20 flex items-center">
        <div class="flex justify-between w-full text-white">
            <div class="text-3xl font-bold">
                <a href="{{ route('home') }}">
                    {{ config('app.name') }}
                </a>
            </div>
            <div class="flex items-center">
                <ul class="flex">
                    <li class="px-3">
                        <a href="{{ route('home')}}">
                            Tentang
                        </a>
                    </li>
                    <li class="px-3">
                        <a href="{{ route('peta') }}">
                            Persebaran
                        </a>
                    </li>
                    <li class="px-3">
                        <a href="{{ route('artikel.home') }}">
                            Artikel
                        </a>
                    </li>
                    <li class="pl-3">
                        <a href="{{ route('login')}}">
                            Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>