   <x-tech-layout>
       <x-slot name="header"></x-slot>

           @php
               $statusClasses = [
                   'ON_GOING' =>
                       'bg-yellow-100 text-yellow-700 px-2 py-1 border border-yellow-500 rounded-full text-xs',
                   'COMPLETED' => 'bg-green-100 text-green-700 px-2 py-1 border border-green-500 rounded-full text-xs',
                   'IN_REVIEW' => 'bg-blue-100 text-blue-700 px-2 py-1 border border-blue-500 rounded-full text-xs',
               ];
               $defaultClass = 'bg-gray-100 text-gray-800';
           @endphp

           <main>
               <!--head begins-->
               <div class="p-3 sm:p-4">
                   <div class="mb-[20px]">
                       <h2 class="mb-6 text-2xl font-bold">Assign Designers </h2>
                       <div class="mb-20 bg-white shadow rounded-2xl">
                           <div class="pt-6 pb-5 pl-6 ">
                               <h2 class="text-sm text-gray-600 ">Assign Projects to a Designer</h2>
                           </div>
                           <div class="overflow-x-auto">
                               <table class="min-w-full text-left">
                                   <thead class="items-center text-sm text-gray-600 bg-gray-100">
                                       <tr>
                                           <th class="p-4 font-medium text-[15px] items-center">Client Name</th>
                                           <th class="p-4 font-medium text-[15px] items-center">Project Name</th>
                                           <th class="p-4 font-medium text-[15px] items-center">Location</th>
                                           <th class="p-4 font-medium text-[15px] items-center">Measurement Date</th>
                                           <th class="p-4 font-medium text-[15px] items-center">Status</th>
                                           <th class="p-4 font-medium text-[15px] items-center">Designer</th>
                                       </tr>
                                   </thead>

                                   <tbody class="text-gray-700 divide-y divide-gray-100">

                                       @foreach ($projects as $project)
                                           <tr class="cursor-pointer hover:bg-gray-100">
                                               <td class="p-4 font-normal text-[15px] items-center">
                                                   {{ $project->client->title . ' ' . $project->client->firstname . ' ' . $project->client->lastname }}
                                               </td>

                                               <td class="p-4 font-normal text-[15px] items-center">{{ $project->name }}
                                               </td>
                                               <td class="p-4 font-normal text-[15px] items-center">
                                                   {{ $project->location }}</td>
                                               <td class="p-4 font-normal text-[15px] items-center ">
                                                   {{ $project->created_at }}
                                               </td>
                                               <td class="p-4 font-normal text-[15px] items-center">

                                                   <span
                                                       class="px-3 py-1 text-sm {{ $statusClasses[$project->status] ?? $defaultClass }}">{{ $project->status }}</span>
                                               </td>
                                               <td class="p-4 font-normal text-[15px] items-center">
                                                   @if ($project->designer)
                                                       @php
                                                           $emp = $project->designer->employee;
                                                           $name = $emp->name ?? ($project->designer->name ?? '—');

                                                           $path = $emp->avatar_path ?? null; // column in employees
                                                           $avatarUrl = $path
                                                               ? (\Illuminate\Support\Str::startsWith($path, [
                                                                   'http://',
                                                                   'https://',
                                                               ])
                                                                   ? $path
                                                                   : \Illuminate\Support\Facades\Storage::url($path))
                                                               : asset('images/avatar-placeholder.png'); // put a placeholder in /public/images/
                                                       @endphp

                                                       <div class="flex items-center gap-2">
                                                           <img src="{{ $avatarUrl }}" alt="designer" width="40"
                                                               height="40" class="object-cover w-8 h-8 rounded-full">
                                                           <span>{{ $name }}</span>
                                                       </div>
                                                   @else


                                                       <button
                                                           class="flex px-3 py-1 text-sm font-medium text-purple-800 bg-purple-100 border border-purple-800 rounded-full btn-assign-designer hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                                                           data-project-id="{{ $project->id }}"
                                                           data-project-name="{{ $project->name }}">

                                                               <iconify-icon icon="cuida:plus-outline"
                                                                   class="w-4 h-5 pt-[2px] pr-[8px]"></iconify-icon>

                                                           Assign
                                                       </button>

                                                                                                          @endif
                                               </td>

                                           </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                               <div class="mt-4 mb-4 ml-4 mr-4">
                                   {{ $projects->links('pagination::tailwind') }}
                               </div>
                           </div>

                           <!-- Pagination -->

                       </div>

                       {{-- Button on each project card (use your styles) --}}


                       <div id="designer-modal" class="fixed inset-0 z-50 hidden">
                           <div class="absolute inset-0 bg-black/40"></div>

                           <div
                               class="absolute left-1/2 top-1/2 w-[520px] -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white shadow-xl">
                               <div class="flex items-center justify-between px-5 py-3 border-b">
                                   <div class="text-base font-semibold">Assign Designer</div>
                                   <button id="designer-close" class="p-2 rounded-lg hover:bg-gray-100">&times;</button>
                               </div>
                               <form id="designer-form" method="POST" action="{{ route('assign.designer') }}"
                                   class="p-5 space-y-4">
                                   @csrf

                                   <input type="hidden" name="project_id" id="designer-project-id">

                                   <div>
                                       <label class="block text-sm text-gray-500">Project</label>
                                       <div id="designer-project-name" class="font-medium text-gray-900"></div>
                                   </div>

                                   <div>
                                       <label class="block text-sm font-medium text-gray-700">Design Date</label>
                                       <input type="date" name="design_date"
                                           class="w-full mt-1 border-gray-300 rounded-lg focus:ring-fuchsia-600 focus:border-fuchsia-600"
                                           required>
                                   </div>

                                   <div>
                                       <div class="mb-2 text-sm font-medium">Select Designer</div>
                                       <div id="designer-list" class="max-h-[320px] overflow-y-auto space-y-3">
                                           {{-- populated by JS --}}
                                       </div>
                                       <p id="designer-error" class="hidden mt-2 text-sm text-red-600"></p>
                                   </div>

                                   <div class="flex items-center justify-end gap-2 pt-2">
                                       <button type="button" id="designer-cancel"
                                           class="px-3 py-1.5 rounded-lg border text-sm">Cancel</button>
                                       <button type="submit"
                                           class="px-3 py-1.5 rounded-lg bg-fuchsia-900 text-white text-sm">Proceed</button>
                                   </div>
                               </form>
                           </div>
                       </div>

                       <script>
                           (function() {
                               const modal = document.getElementById('designer-modal');
                               const btns = document.querySelectorAll('.btn-assign-designer');
                               const closeEl = document.getElementById('designer-close');
                               const cancel = document.getElementById('designer-cancel');

                               const fldProjId = document.getElementById('designer-project-id');
                               const lblProjName = document.getElementById('designer-project-name');
                               const listEl = document.getElementById('designer-list');
                               const errEl = document.getElementById('designer-error');

                               function openModal(projectId, projectName) {
                                   fldProjId.value = projectId;
                                   lblProjName.textContent = projectName;
                                   errEl.classList.add('hidden');
                                   listEl.innerHTML = '<div class="text-sm text-gray-500">Loading designers…</div>';

                                   const url = `{{ route('admin.designers.list') }}?project_id=${encodeURIComponent(projectId)}`;
                                   fetch(url, {
                                           headers: {
                                               'Accept': 'application/json'
                                           },
                                           credentials: 'same-origin'
                                       })
                                       .then(r => r.json())
                                       .then(rows => {
                                           listEl.innerHTML = rows.map(d => {
                                               const right = d.assigned_project ?
                                                   `<span class="text-xs font-semibold text-purple-800">Already Assigned${d.assigned_project.name ? ` (${d.assigned_project.name})` : ''}</span>` :
                                                   `<input type="radio" name="designer_id" value="${d.id}" class="form-radio text-fuchsia-800 focus:ring-fuchsia-900">`;
                                               return `
            <label class="flex items-center justify-between p-2 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
              <div class="flex items-center gap-3">
                <img src="${d.avatar_url}" alt="" class="object-cover w-10 h-10 rounded-full">
                <span class="font-medium text-gray-800">${d.name}</span>
              </div>
              ${right}
            </label>
          `;
                                           }).join('') || '<div class="text-sm text-gray-500">No designers found.</div>';
                                       })
                                       .catch(() => {
                                           listEl.innerHTML = '<div class="text-sm text-red-600">Failed to load designers.</div>';
                                       });

                                   modal.classList.remove('hidden');
                               }

                               function closeModal() {
                                   modal.classList.add('hidden');
                               }

                               btns.forEach(b => {
                                   b.addEventListener('click', () => openModal(b.dataset.projectId, b.dataset.projectName));
                               });
                               closeEl.addEventListener('click', closeModal);
                               cancel.addEventListener('click', closeModal);
                               modal.addEventListener('click', (e) => {
                                   if (e.target === modal) closeModal();
                               });

                               // guard: if radios exist, require one checked
                               document.getElementById('designer-form').addEventListener('submit', (e) => {
                                   const radios = listEl.querySelectorAll('input[type="radio"]');
                                   if (radios.length && !listEl.querySelector('input[type="radio"]:checked')) {
                                       e.preventDefault();
                                       errEl.textContent = 'Please select a designer.';
                                       errEl.classList.remove('hidden');
                                   }
                               });
                           })();
                       </script>
   </x-tech-layout>
