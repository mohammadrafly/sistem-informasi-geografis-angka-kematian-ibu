@extends('layout.home')

@section('content')

<div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "isAutoPlay": true
  }' class="relative">
  <div class="hs-carousel relative overflow-hidden w-full min-h-[350px] bg-white rounded-lg">
    <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
      @foreach ($data['category'] as $item)
      <div class="hs-carousel-slide">
        <div class="flex justify-center h-full bg-gray-100 p-6">
            <a href="{{ route('artikel.category.home', $item->id)}}">
                <span class="self-center text-4xl transition duration-700">{{$item->nama_category}}</span>
            </a>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <button type="button" class="hs-carousel-prev hs-carousel:disabled:opacity-50 disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/[.1]">
    <span class="text-2xl" aria-hidden="true">
      <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
      </svg>
    </span>
    <span class="sr-only">Previous</span>
  </button>
  <button type="button" class="hs-carousel-next hs-carousel:disabled:opacity-50 disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/[.1]">
    <span class="sr-only">Next</span>
    <span class="text-2xl" aria-hidden="true">
      <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
      </svg>
    </span>
  </button>

  <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 space-x-2">
    <span class="hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer"></span>
    <span class="hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer"></span>
    <span class="hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer"></span>
  </div>
</div>

<div class="grid gap-4 grid-cols-2 mt-10">
    @foreach ($data['artikel'] as $item)
    <a href="{{ route('artikel.single.home', $item->id)}}">
        <div class="bg-white border rounded-xl shadow-sm sm:flex">
            <div class="flex-shrink-0 relative w-full rounded-t-xl overflow-hidden pt-[40%] sm:rounded-s-xl sm:max-w-60 md:rounded-se-none md:max-w-xs">
              <img class="size-full absolute top-0 start-0 object-cover" src="{{ asset('imgs/'.$item->img) }}" alt="Image Description">
            </div>
            <div class="flex flex-wrap">
              <div class="p-4 flex flex-col h-full sm:p-7">
                <h3 class="text-lg font-bold text-gray-800">
                  {{$item->title}}
                </h3>
                <p class="mt-1 text-gray-500">
                  {{ Str::limit(strip_tags($item->description), 50) }}
                </p>
                <div class="mt-5 sm:mt-auto">
                  <p class="text-xs text-gray-500">
                    Posted at {{$item->created_at}}
                  </p>
                </div>
              </div>
            </div>
        </div>
    </a>
    @endforeach
</div>

@endSection()

@section('script')


@endSection()