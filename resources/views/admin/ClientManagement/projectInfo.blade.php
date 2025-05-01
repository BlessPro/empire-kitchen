<x-layouts.app>
    <x-slot name="header">
        @include('admin.layouts.header')

        <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
            <!--head begins-->

                <div class="p-6 bg-[#F9F7F7]">
                 <div class="mb-[20px]">

                       {{-- navigation bar --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center justify-between mb-1"><span><i data-feather="home" class="text-fuchsia-900 mr-[12px] ml-[3px]"></i></span><span class="font-normal text-black mr-[12px]">Clients Management</span><span class="mr-[12px] font-semibold text-fuchsia-900">{{ $client->title . ' '.$client->firstname . ' '.$client->lastname }}</span></div>


    {{-- <button class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">+ Add Project</button> --}}
     <!-- ADD CLIENT BUTTON -->
     <button id="openAddClientModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
         + Add Client
     </button>

     </div>
                    <div class="  grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Section: Project Info -->
                        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                          <!-- Breadcrumbs -->


                          <!-- Project Header -->
                          <div class="flex items-start justify-between">
                            <div>
                              <h2 class="text-2xl font-semibold text-gray-800">Wardrobe</h2>
                              <span class="inline-block mt-1 px-3 py-0.5 text-xs bg-green-100 text-green-600 rounded-full">Completed</span>
                            </div>
                            <div class="text-right text-sm text-gray-600">
                              <p class="font-medium">Mr Yaw Boateng</p>
                            </div>
                          </div>

                          <!-- Project Details -->
                          <div class="mt-6 space-y-4 text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                              <span class="font-medium">Due Date:</span>
                              <span>Dec 12, 2025</span>
                            </div>
                            <div class="flex items-center gap-2">
                              <span class="font-medium">Address:</span>
                              <span>Maple Street, West Legon</span>
                            </div>
                            <div class="flex items-center gap-2">
                              <span class="font-medium">Client:</span>
                              <span>Divine Okyere Mensah</span>
                            </div>
                          </div>

                          <!-- Additional Note -->
                          <div class="mt-6">
                            <h3 class="text-sm font-semibold text-gray-800">Additional Note</h3>
                            <p class="mt-1 text-sm text-gray-600">
                              Double-check all fittings, seals, and appliance functionality after installation. Cabinets, countertops, and appliances must be level for proper installation.
                            </p>
                          </div>

                          <!-- Measurement -->
                          <div class="mt-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-2">Measurement (in length, width, height)</h3>
                            <div class="flex gap-4">
                              <div class="flex items-center gap-1">
                                📐 <span>3.5mm</span>
                              </div>
                              <div class="flex items-center gap-1">
                                📐 <span>3.5mm</span>
                              </div>
                              <div class="flex items-center gap-1">
                                📐 <span>3.5mm</span>
                              </div>
                            </div>
                          </div>

                          <!-- Attachments -->
                          <div class="mt-6">
                            <h3 class="text-sm font-semibold text-gray-800 mb-2">Attachments after measurement</h3>
                            <ul class="space-y-2">
                              <li class="flex justify-between items-center bg-gray-100 rounded p-3">
                                <div>
                                  <p class="text-sm font-medium">Image9067.png</p>
                                  <p class="text-xs text-gray-500">Uploaded on 8/10/25 · 11MB</p>
                                </div>
                                <div class="flex gap-3 text-purple-600">
                                  👁️ 📥
                                </div>
                              </li>
                              <li class="flex justify-between items-center bg-gray-100 rounded p-3">
                                <div>
                                  <p class="text-sm font-medium">Image9068.png</p>
                                  <p class="text-xs text-gray-500">Uploaded on 8/10/25 · 11MB</p>
                                </div>
                                <div class="flex gap-3 text-purple-600">
                                  👁️ 📥
                                </div>
                              </li>
                              <li class="flex justify-between items-center bg-gray-100 rounded p-3">
                                <div>
                                  <p class="text-sm font-medium">Image9077.png</p>
                                  <p class="text-xs text-gray-500">Uploaded on 8/10/25 · 11MB</p>
                                </div>
                                <div class="flex gap-3 text-purple-600">
                                  👁️ 📥
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>

                        <!-- Right Section: Comments -->
                        <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                          <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Comments</h3>
                            <ul class="space-y-4">
                              <li class="flex items-start gap-3">
                                <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10" />
                                <div>
                                  <p class="text-sm font-semibold text-gray-800">Jackson Beverly <span class="text-gray-400 font-normal text-xs">· 18mins ago</span></p>
                                  <p class="text-sm text-gray-600">Great progress on the designs Patrick. Keep it up 🙌🚀</p>
                                </div>
                              </li>
                              <!-- Repeat for other users -->
                            </ul>
                          </div>

                          <div class="mt-6">
                            <input type="text" placeholder="Start typing" class="w-full border rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" />
                            <button class="mt-2 px-4 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700">Comment</button>
                          </div>
                        </div>
                      </div>


                 </div>
                </div>
        </main>

    </x-slot>
</x-layouts.app>
