@extends('layout.home')

@section('content')

<div class="text-center mt-10">
  <h1 class="font-bold text-2xl">INFORMASI ANGKA KEMATIAN IBU</h1>
</div>
@if (!empty($data['informasi']))
<div class="grid gap-4 grid-cols-2 mt-10">
    @foreach ($data['informasi'] as $item)
    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
      <a href="{{ route('artikel.single.home', $item->id)}}">
          <img class="rounded-t-lg" src="{{ asset('imgs/'.$item->img) }}" alt="" />
      </a>
      <div class="p-5">
          <a href="#">
              <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$item->title}}</h5>
          </a>
      </div>
    </div>

    @endforeach
</div>
@else
<div class="flex justify-center items-center">
  <h1 class="font-semibold text-2xl">Tidak ada Informasi</h1>
</div>
@endif

<div class="text-center mt-10">
  <h1 class="font-bold text-2xl">ARTIKEL ANGKA KEMATIAN IBU</h1>
</div>
@if (!empty($data['artikel']))
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
@else
<div class="flex justify-center items-center">
  <h1 class="font-semibold text-2xl">Tidak ada Artikel</h1>
</div>
@endif

@endSection()

@section('script')


@endSection()