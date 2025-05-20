<x-layouts.app>
    <x-slot name="header">
<!--written on 26.04.2025-->
        @include('admin.layouts.header')
    </x-slot>
        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

            <div class="p-6 bg-[#F9F7F7] items-center">
             <div class="mb-[20px] items-center">
    <div class=" flex p-6 text-gray-900 items-center"><h3 class=" flex items-center text-fuchsia-900 font-bold text-[300px]"> 404 </h3></div>
 <p class=" flex items-center text-gray-500 font-semi-bold text-[20px]">Your session has expired. </p>
 <p class=" flex items-center text-gray-500 font-semi-bold text-[20px]"> Too many entries. </p>

     <p class=" flex items-center text-gray-500 font-semi-bold text-[20px]">Kindly login again</p>
             </div>
    </div>
</main>
</x-layouts.app>
