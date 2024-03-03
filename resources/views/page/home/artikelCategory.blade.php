@extends('layout.home')

@section('content')

<h1 class="py-10 text-3xl font-semibold">
    {{$data['title']}}
</h1>

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