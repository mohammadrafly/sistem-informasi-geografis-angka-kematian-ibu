@extends('layout.home')

@section('content')

<div class="max-w-3xl px-4 pt-6 lg:pt-10 pb-12 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-2xl">
      <div class="flex justify-between items-center mb-6">
        <div class="flex w-full sm:items-center gap-x-5 sm:gap-x-3">
          <div class="flex-shrink-0">
            <svg class="size-12 text-gray-800 rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a9 9 0 0 0 5-1.5 4 4 0 0 0-4-3.5h-2a4 4 0 0 0-4 3.5 9 9 0 0 0 5 1.5Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
          </div>
  
          <div class="grow">
            <div class="flex justify-between items-center gap-x-2">
              <div>
                <div class="hs-tooltip inline-block [--trigger:hover] [--placement:bottom]">
                  <div class="hs-tooltip-toggle sm:mb-1 block text-start cursor-pointer">
                    <span class="font-semibold text-gray-800">
                      {{$data['artikel']->user->name}}
                    </span>
  
                    <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 max-w-xs cursor-default bg-gray-900 divide-y divide-gray-700 shadow-lg rounded-xl " role="tooltip">
                      <div class="p-4 sm:p-5">
                        <div class="mb-2 flex w-full sm:items-center gap-x-5 sm:gap-x-3">
                          <div class="flex-shrink-0">
                            <svg class="size-8 text-gray-800 rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a9 9 0 0 0 5-1.5 4 4 0 0 0-4-3.5h-2a4 4 0 0 0-4 3.5 9 9 0 0 0 5 1.5Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                          </div>
  
                          <div class="grow">
                            <p class="text-lg font-semibold text-gray-200">
                                {{$data['artikel']->user->name}}
                            </p>
                          </div>
                        </div>
                        <p class="text-sm text-gray-400">
                          Admin at {{ config('app.name') }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
  
                <ul class="text-xs text-gray-500">
                  <li class="inline-block relative pe-6 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-2 before:-translate-y-1/2 before:size-1 before:bg-gray-300 before:rounded-full">
                    {{$data['artikel']->created_at}}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="space-y-5 md:space-y-8">
        <div>
            <img class="rounded-xl w-[672px] h-[316px]" src="{{asset('imgs/'. $data['artikel']->img )}}" alt="">
        </div>
        {!! $data['artikel']->description !!}
      </div>
    </div>
  </div>

@endSection()

@section('script')


@endSection()