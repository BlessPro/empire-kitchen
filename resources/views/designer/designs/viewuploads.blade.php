<!-- Example for designer -->
   <x-Designer-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Designer Dashboard') }}
        </h2>

@include('designer.layouts.header')

    </x-slot>
        <main class="ml-64 mt-[50px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7]">
             <div class="mb-[20px]">

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
    @foreach ($designs as $design)
        <a href="{{ route('designer.designs.upload', $design->id) }}" class="relative group">
            <div class="relative w-full h-48">

                @foreach ($design->images as $index => $img)
                    @if ($index < 3)
                        <img src="{{ asset('storage/designs/' . $img) }}"
                             class="absolute top-0 left-0 w-full h-full object-cover rounded-lg shadow-md transform transition-all group-hover:scale-105
                                    {{ $index === 1 ? 'translate-x-1 translate-y-1' : '' }}
                                    {{ $index === 2 ? 'translate-x-2 translate-y-2' : '' }}"
                             alt="Design Image">
                    @endif
                @endforeach
            </div>
            <p class="mt-2 font-semibold text-center">{{ $design->project->name }}</p>
        </a>
    @endforeach
</div>


             </div>
            </div>
        </main>
   </x-Designer-layout>
