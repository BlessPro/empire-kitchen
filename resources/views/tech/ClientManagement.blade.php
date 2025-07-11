   <x-tech-layout>
   <x-slot name="header">
<!--written on 16.05.2025-->
        @include('admin.layouts.header')
         </x-slot>

            @php
        $statusClasses = [
            'in progress' => 'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
            'completed' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
            'pending' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
        ];


        $defaultClass = 'bg-gray-100 text-gray-800';
    @endphp
        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->


            <div class="]">
             <div class="mb-[20px]">


                <h2 class="font-semibold text-[30px] mb-6">My Client </h2>
        <div class="mb-20 bg-white shadow rounded-2xl">
            <div class="pt-6 pb-5 pl-6 ">
            <h2 class="text-sm text-gray-600 ">Manage all your Clients here</h2>
            </div>
            <div class="overflow-x-auto">
                 <table class="min-w-full text-left">
                    <thead class="items-center text-sm text-gray-600 bg-gray-100">
                      <tr >
                        <th class="p-4 font-mediumt text-[15px] items-center">
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600"></th>
                        <th class="p-4 font-medium text-[15px] items-center">Client Name</th>
                        <th class="p-4 font-medium text-[15px] items-center">Phone Number</th>
                        <th class="p-4 font-medium text-[15px] items-center">Location</th>
                        <th class="p-4 font-medium text-[15px] items-center">Measurement Date</th>
                        <th class="p-4 font-medium text-[15px] items-center">Project</th>
                        <th class="p-4 font-medium text-[15px] items-center">Status</th>
                        <th class="p-4 font-medium text-[15px] items-center">Action</th>


                      </tr>
                    </thead>
                 <tbody>
                @foreach ($clients as $client)
                    @foreach ($client->projects as $project)


                        <tr  class=" p-4 border-b hover:bg-gray-50">
                            <td class="p-4 font-normal text-[15px] items-center ">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" >
                            </td>
                            <td class="p-4 font-normal text-[15px] text-sm  items-center">{{ $client->firstname }} {{ $client->lastname }}</td>
                            <td class="p-4 font-normal text-[15px] text-sm  items-center">{{ $client->phone_number }}</td>
                            <td class="p-4 font-normal text-[15px] text-sm  items-center">{{ $client->location }}</td>
                            <td class="p-4 font-normal text-[15px] text-sm  items-center">
                                @if ($project->measurement->first())
                                    {{ \Carbon\Carbon::parse($project->measurement->first()->measured_at)->format('d M Y') }}
                                @else
                                    <span class="italic text-gray-400">Not measured</span>
                                @endif
                            </td>
                              <td class="p-4 font-normal text-[15px] text-sm  items-center">
                              <span class="text-sm ">{{ $project->name }}</span>
                            </td>
                            <td class="p-4 font-normal text-[15px] text-sm  items-center">
                              <span class="px-3 py-1 text-sm {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status }}</span>
                            </td>
                        <td  class="p-4 font-normal text-[15px] text-sm  items-center">
                              <a cursor:pointer; href="{{ route('tech.projects.info', $project->id) }}">

                            <i data-feather="eye" class="text-gray-600 w-5 h-5 "></i> </td>
                                </a>


                        </tr>
                    @endforeach
                @endforeach
            </tbody>
              </table>
  <div class="mt-4 mb-4 ml-4 mr-4">
    {!! $clients->links('pagination::tailwind') !!}
</div>


            </div>

            <!-- Pagination -->

            </div>

           </div>
    </div>
    </main>
    </x-tech-layout>

{{--
<x-tech-layout>
   <x-slot name="header">
<!--written on 16.05.2025-->
        @include('admin.layouts.header')
         </x-slot>
@section('content')
<div class="container px-4 py-6 mx-auto">
    <h1 class="mb-6 text-2xl font-bold">Clients in Measurement Stage</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-sm">
            <thead>
                <tr class="text-sm text-left text-gray-600 uppercase bg-gray-100">
                    <th class="px-4 py-2">Client Name</th>
                    <th class="px-4 py-2">Phone Number</th>
                    <th class="px-4 py-2">Location</th>
                    <th class="px-4 py-2">Measurement Date</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    @foreach ($client->projects as $project)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $client->firstname }} {{ $client->lastname }}</td>
                            <td class="px-4 py-2">{{ $client->phone_number }}</td>
                            <td class="px-4 py-2">{{ $client->location }}</td>
                            <td class="px-4 py-2">
                                @if ($project->measurement->first())
                                    {{ \Carbon\Carbon::parse($project->measurement->first()->measured_at)->format('d M Y') }}
                                @else
                                    <span class="italic text-gray-400">Not measured</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-sm text-blue-700 bg-blue-100 rounded">
                                    {{ $project->current_stage }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
 </x-tech-layout> --}}
