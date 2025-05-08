
  
        <!-- User Permissions -->
        <h2 class="text-lg font-medium">User Permissions</h2>
        <p class="mb-4 text-sm text-gray-500">Manage users who have access to the system</p>
  
        <!-- Table Card -->
        <div class="p-6 bg-white shadow rounded-2xl">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-md">My Team</h3>
          
            <button id="openAddClientModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
                Create
            </button>
          </div>
          <p class="mb-4 text-sm text-gray-500">You can manage your team here</p>
  
          <div class="overflow-x-auto">
            <table class="w-full text-left border-t">
              <thead>
                <tr class="text-sm text-gray-500">
                  <th class="py-2">Staff</th>
                  <th class="py-2">Status</th>
                  <th class="py-2">Last Active</th>
                  <th class="py-2">User Role</th>
                  <th class="py-2">Actions</th>
                </tr>
              </thead>


              
              <tbody class="text-gray-700">
                @foreach($users as $user)

                <tr class="border-t">
                  <td class="flex items-center py-3 space-x-2">
                    {{-- <img src="https://i.pravatar.cc/30?img=1" class="w-8 h-8 rounded-full"> --}}
                    <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://i.pravatar.cc/30' }}" class="object-cover w-8 h-8 rounded-full">


                    
                    <span>{{ $user->name }}</span>
                  </td>
                  <td><span class="px-2 py-1 text-xs text-green-600 bg-green-100 rounded-full">Online</span></td>
                  <td>June 25, 2026, 10:45PM</td>
                  <td>{{$user->role}}</td>
                  <td class="flex space-x-2">
                    <form action="{{ route('settings.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-gray-500 hover:text-red-500">
                            <i data-feather="trash" class="mr-3"></i>
                        </button>
                        </form>                    <button><svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
                  </td>
                </tr>
                <!-- Repeat for others -->
                
                @endforeach

                <!-- Add more rows similarly -->
              </tbody>
            </table>
          </div>
          <div class="mt-4 mb-5 ml-5 mr-5">
            {{ $users->links('pagination::tailwind') }}
        </div>
          <!-- Pagination -->
         
        
        </div>
      </div>
      <div id="addProjectModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">
            <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
            <h2 class="mb-4 text-xl font-semibold">Add User</h2>
            <button type="button" id="cancelAddClient" class="px-4 py-2 text-black "> <i data-feather="x"
        class="mr-3 feather-icon group"></i></button>
            </div>
      <form id="addProjectForm" method="POST">
        @csrf
      
        <!--group row 1-->
        <div class="flex flex-col gap-4 sm:flex-row">
    
        <!-- Project Name -->
        <div class="mb-4">
          <label for="name" class="block mb-3 text-sm font-medium text-gray-700">Project Name</label>
          <input type="text" name="name" id="name" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
      
        <!-- Due Date -->
        <div class="mb-4">
          <label for="due_date" class="block mb-3 text-sm font-medium text-gray-700">Due Date</label>
          <input type="date" name="due_date" id="due_date" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        </div>
            <!--group row 1-->
    
            <!--group row -->
    
        <!-- Cost -->
        <div class="mb-4">
          <label for="cost" class="block text-sm font-medium text-gray-700">Project Cost</label>
          <input type="number" name="cost" id="cost" class="w-full px-3 py-2 border border-gray-300 rounded" required>
        </div>
      
        <!-- Location -->
        <div class="mb-4">
          <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
          <input type="text" name="location" id="location" class="w-full px-3 py-2 border border-gray-300 rounded" required>
        </div>
          <!--group row2 -->
    
        <!--group row 3 -->
    
        <!-- Description -->
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded" required></textarea>
        </div>
          <!--group row 3-->
    
    
          
        <!--group row 4-->
    
        <!-- Admin Name -->
        {{-- <div class="mb-4">
          <label for="admin_name" class="block text-sm font-medium text-gray-700">Admin</label>
          <input type="text" name="name" id="admin_name" class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded" readonly value="{{ auth()->user()->name }}">
        </div> --}}
      
        <!-- Select Client -->
        <div class="mb-4">
          <label for="client_id" class="block text-sm font-medium text-gray-700">Client Name</label>
          <select name="client_id" id="client_id" class="w-full px-3 py-2 border border-gray-300 rounded" required>
            <option disabled selected>Select a client</option>
            @foreach ($clients as $client)
              <option value="{{ $client->id }}">{{ $client->firstname }} {{ $client->lastname }}</option>
            @endforeach
          </select>
        </div>
      
        <!-- Select Tech Supervisor -->
        <div class="mb-4">
          <label for="tech_supervisor_id" class="block text-sm font-medium text-gray-700">Tech Supervisor</label>
          <select name="tech_supervisor_id" id="tech_supervisor_id" class="w-full px-3 py-2 border border-gray-300 rounded" required>
            <option disabled selected>Select a supervisor</option>
            @foreach ($techSupervisors as $supervisor)
              <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
            @endforeach
          </select>
        </div>
          <!--group row 4 ends-->
    
        <!-- Submit -->
        <div class="flex justify-end">
          <button type="submit" class="px-4 py-2 text-white rounded bg-fuchsia-900">Save Project</button>
        </div>
      </form>
    </div>
    </div>
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="w-full max-w-sm p-6 bg-white rounded-lg">
            <div class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
                <i data-feather="user-plus" class="text-fuchsia-900 ml-[3px]"></i>
            </div>
            <h2 class="mb-4 text-lg font-semibold text-left">Project successfully created</h2>
    
            <!-- Right-Aligned Button -->
            <div class="flex justify-end">
                <button id="closeSuccessModal" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">
                    OK
                </button>
            </div>
        </div>
    </div>