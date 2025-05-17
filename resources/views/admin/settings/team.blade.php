

        <!-- User Permissions -->
        <h2 class="text-lg font-medium">User Permissions</h2>
        <p class="mb-4 text-sm text-gray-500">Manage users who have access to the system</p>

        <!-- Table Card -->
        <div class="p-6 bg-white shadow rounded-2xl">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-md">My Team</h3>

            <button id="openAddUserModal" class="px-6 py-2 text-semibold text-[15px] text-white rounded-full bg-fuchsia-900 hover:bg-[#F59E0B]">
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
                        </form>
                        <button data-id="{{ $user->id }}"  class="text-gray-500 hover:text-red-500 btn btn-primary editUserBtn">
                            <i data-feather="edit-3" class="mr-3"></i>
                        </button>


                    {{-- <button class="btn btn-primary editUserBtn" data-id="{{ $user->id }}">Edit</button> --}}
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


 {{-- add user pop up  begins--}}
  <div id="addUserModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">
        <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
        <h2 class="mb-4 text-xl font-semibold">Add New Project</h2>
        <button type="button" id="cancelAddUser" class="px-4 py-2 text-black "> <i data-feather="x"
    class="mr-3 feather-icon group"></i></button>
        </div>
        <form id="addUserForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">

            @csrf

            <!---group 1-->

            <div class="flex flex-col gap-4 sm:flex-row">

            <div>
                <label class="block mb-4 text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block mb-4 text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

        </div>
         <!---group 1 ends-->

         <!---group 2 begins-->
         <div class="flex flex-col gap-4 sm:flex-row">

            <div>
                <label class="block mb-4 text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone_number" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block mb-4 text-sm font-medium text-gray-700">Role</label>
                <select class="w-[270px] px-3 py-2 border
                border-gray-300 rounded-md focus:outline-none
                focus:ring-2 focus:ring-blue-500" required name="role">
                    <option value="admin">Admin</option>
                    <option value="tech_supervisor">Tech Supervisor</option>
                    <option value="designer">Designer</option>
                    <option value="accountant">Accountant</option>
                    <option value="sales_accountant">Sales Accountant</option>
                  </select>

            </div>
            </div>
         <!---group 2 ends-->

         <!---group 3 begins-->

         <div class="flex flex-col gap-4 sm:flex-row">

            <div>
                <label class="block mb-4 text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password"
                name="password"
                class="w-[270px] px-3  border border-gray-300 rounded-md focus:outline-none
                focus:ring-2 focus:ring-blue-500" required>
                <span id="passwordError" class="block mt-1 text-sm text-red-500"></span>

            </div>
            <div>


                <label class="block mb-4 text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="password_confirmation"
                name="password_confirmation"
                class="w-[270px] px-3 py-2 border border-gray-300 rounded-md
                 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
   
            </div>
                     <div class="">


                     <label class="block mb-4 text-sm font-medium text-gray-700">Profile Picture</label>

                <input type="file" name="profile_pic" accept="image/*" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                     </div>s
              <!---group 3 ends-->

          <!---group 4 begins-->

            {{-- <div>
                <label class="block mb-4 text-sm font-medium text-gray-700">Profile Picture</label>
                <input type="file" name="profile_pic" accept="image/*" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div> --}}
             <!---group 4 ends-->

             <button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">Save Client</button>
    </form>

</div>
</div>

{{-- <div id="successModal1" tabindex="-1" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="p-6 text-center bg-white rounded-md shadow-lg w-72">
        <p class="mb-4">User successfully added!</p>
        <button id="successOkBtn1" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">OK</button>
    </div>
</div> --}}



<div id="successModal1" tabindex="-1" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg">
        <div class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
            <i data-feather="edit" class="text-fuchsia-900 ml-[3px]"></i>
        </div>
        <h2 class="mb-4 text-lg font-semibold text-left">User successfully added</h2>

        <!-- Right-Aligned Button -->
        <div class="flex justify-end">
            <button id="successOkBtn1" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">
                OK
            </button>
        </div>
    </div>
</div>
 {{-- add user pop up  ends--}}



{{-- user edit pop up--}}



<div id="editUserModal" tabindex="-1"class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-[600px] items-center justify-center relative">
        <div class="flex flex-col justify-between gap-4 mb-4 sm:flex-row">
        <h2 class="mb-4 text-xl font-semibold">Add New Project</h2>
        <button type="button" id="closeModalBtn" class="px-4 py-2 text-black "> <i data-feather="x"
    class="mr-3 feather-icon group"></i></button>
        </div>
        <form  id="editUserForm" enctype="multipart/form-data">

            @csrf
            <input type="hidden" id="edit_user_id">

            <!---group 1-->
            <img id="edit_profile_preview" src="" alt="Profile Preview" class="object-cover w-20 h-20 mx-auto mb-6 rounded-full" />

            <div class="flex flex-col gap-4 mb-4 sm:flex-row">

            <div>
                <label class="block mb-2.5 text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="edit_name" placeholder="Name" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block mb-2.5 text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="edit_email" placeholder="Email" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

        </div>
         <!---group 1 ends-->

         <!---group 2 begins-->
         <div class="flex flex-col gap-4 sm:flex-row">

            <div>
                <label class="block mb-2.5 text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone_number" id="edit_phone_number" placeholder="Phone Number" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block mb-2.5 text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="edit_role"  class="w-[270px] px-3 py-2 border
                border-gray-300 rounded-md focus:outline-none
                focus:ring-2 focus:ring-blue-500" required name="role">
                    <option value="admin">Admin</option>
                    <option value="tech_supervisor">Tech Supervisor</option>
                    <option value="designer">Designer</option>
                    <option value="sales_accountant">Sales Accountant</option>
                    <option value="accountant">Accountant</option>
                </select>

            </div>
            </div>
         <!---group 2 ends-->

         <!---group 3 begins-->

         <div class="flex flex-col gap-4 mb-6 sm:flex-row">

            <div>
                <label class="block mb-2.5 text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="edit_password" placeholder="New Password (Optional)"
                class="w-[270px] px-3  border border-gray-300 rounded-md focus:outline-none
                focus:ring-2 focus:ring-blue-500" required>
                <span id="passwordError" class="block mt-1 text-sm text-red-500"></span>

            </div>


            <div>
                <label class="block mb-2.5 text-sm font-medium text-gray-700">Profile Picture</label>
                <input type="file" id="edit_profile_pic" name="profile_pic" accept="image/*" class="w-[270px] px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            </div>
              <!---group 3 ends-->

          <!---group 4 begins-->


             <!---group 4 ends-->

             <button type="submit" class="bg-fuchsia-900 w-full text-[20px] text-white px-4 py-2 rounded">Save Client</button>


            </form>

</div>
</div>
<!-- Success Modal -->

<div id="successModal" tabindex="-1" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg">
        <div class="flex items-center justify-center w-10 h-10 mb-[10px] bg-fuchsia-100 rounded-full">
            <i data-feather="edit" class="text-fuchsia-900 ml-[3px]"></i>
        </div>
        <h2 class="mb-4 text-lg font-semibold text-left">User successfully updated</h2>

        <!-- Right-Aligned Button -->
        <div class="flex justify-end">
            <button id="successOkBtn" class="px-4 py-2 text-white rounded-full bg-fuchsia-900">
                OK
            </button>
        </div>
    </div>
</div>



{{-- another modal for user edit --}}

<!-- Edit User Modal -->
{{-- <div id="editUserModal" tabindex="-1" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-6 bg-white rounded-md shadow-lg">
        <form id="editUserForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit_user_id">

            <!---group 1b begins-->

            <div class="flex flex-col gap-4 sm:flex-row">

            <div class="text-center">
                <img id="edit_profile_preview" src="" alt="Profile Preview" class="object-cover w-20 h-20 mx-auto rounded-full" />
                <input type="file" name="profile_pic" id="edit_profile_pic" class="w-full px-3 py-2 mt-2 border rounded">
            </div>
            <div class="mt-4">
                <input type="text" name="name" id="edit_name" placeholder="Name" class="w-full px-3 py-2 border rounded">
            </div>
            </div>
            <!---group 1b ends-->

            <!---group 2b begins-->
            <div class="mt-4">
                <input type="email" name="email" id="edit_email" placeholder="Email" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mt-4">
                <input type="text" name="phone_number" id="edit_phone_number" placeholder="Phone Number" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mt-4">
                <select name="role" id="edit_role" class="w-full px-3 py-2 border rounded">
                    <option value="admin">Admin</option>
                    <option value="tech_supervisor">Tech Supervisor</option>
                    <option value="designer">Designer</option>
                    <option value="sales_accountant">Sales Accountant</option>
                    <option value="accountant">Accountant</option>
                </select>

            </div>
             <!---group 2b ends-->

             <!---group 3b begins-->
            <div class="mt-4">
                <input type="password" name="password" id="edit_password" placeholder="New Password (Optional)" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="flex justify-between mt-6">
                <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Update User</button>
                <button type="button" id="closeModalBtn" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Cancel</button>
            </div>
          <!---group 3b ends-->

        </form>
    </div>
</div> --}}

<!-- Success Modal -->
{{-- <div id="successModal" tabindex="-1" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="p-6 text-center bg-white rounded-md shadow-lg w-72">
        <p class="mb-4">User updated successfully!</p>
        <button id="successOkBtn" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">OK</button>
    </div>
</div> --}}



{{-- another modal for user edit --}}

<script>
    // Edit User Modal
    // Show the modal
document.querySelectorAll('.editUserBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        const userId = this.dataset.id;
        fetch(`/admin/users/${userId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_user_id').value = userId;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_phone_number').value = data.phone_number;
                document.getElementById('edit_role').value = data.role;
                document.getElementById('edit_profile_preview').src = `/storage/${data.profile_pic}`;

                // Use Tailwind class toggling
                document.getElementById('editUserModal').classList.remove('hidden');
                document.getElementById('editUserModal').classList.add('flex');
            });
    });
});

// Close modal
document.getElementById('closeModalBtn').addEventListener('click', function () {
    document.getElementById('editUserModal').classList.remove('flex');
    document.getElementById('editUserModal').classList.add('hidden');
});

// Submit form
document.getElementById('editUserForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const userId = document.getElementById('edit_user_id').value;
    const formData = new FormData(this);

    fetch(`/admin/users/${userId}`, {
        method: 'POST',
        body: formData,
    })
    .then(res => res.json())
    .then(res => {
        if (res.message) {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');

            document.getElementById('successModal').classList.remove('hidden');
        }
    });
});

// Success Modal OK
document.getElementById('successOkBtn').addEventListener('click', function () {
    location.reload();
});

    //user edit ends here

    // Add User Modal

    // document.getElementById('openAddUserModal').addEventListener('click', function () {
    //     document.getElementById('addUserModal').classList.remove('hidden');
    // });

          // for the close (X) button
        //   document.getElementById('cancelAddUser').addEventListener('click', function () {
        //     document.getElementById('addUserModal').classList.add('hidden');
        // });





    // const password = document.getElementById('password').value;
    // const confirmPassword = document.getElementById('password_confirmation').value;
    // const passwordError = document.getElementById('passwordError');

    // Clear previous error
    // passwordError.textContent = '';

    // if (password !== confirmPassword) {
    //     passwordError.textContent = 'Passwords do not match.';
    //     return;
    // }

//      document.getElementById('addUserForm').addEventListener('submit', function (e) {
//         e.preventDefault();
//         const form = e.target;
//         const formData = new FormData(form);

//         fetch("{{ route('users.store') }}", {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
//                 'Accept': 'application/json'  // Tell Laravel you want JSON
//             },
//             body: formData,
//         })
//         .then(async response => {
//             if (!response.ok) {
//                 const errorData = await response.json();
//                 throw new Error(errorData.message || 'Validation failed');
//             }
//             return response.json();
//         })
//         .then(data => {
//             document.getElementById('addUserModal').classList.add('hidden');
//             // alert('Project created successfully!');

//             document.getElementById('AddsuccessModal').classList.remove('hidden');
//             // Optionally refresh data here
//         })
//         .catch(error => {
//             // alert('Error: ' + error.message);
//         });
//     });


//     //reloading the page
//     document.getElementById('closeSuccessModal').addEventListener('click', function () {
//             document.getElementById('successModal').classList.add('hidden');
//             location.reload(); // refresh to update the table
//         });


//         //editing logged user's details
//         document.getElementById('account_profile_pic').addEventListener('change', function (e) {
//     const file = e.target.files[0];
//     if (file) {
//         document.getElementById('account_profile_preview').src = URL.createObjectURL(file);
//     }
// });



    // document.getElementById('openAddProjectModal').addEventListener('click', function () {
    //     document.getElementById('addProjectModal').classList.remove('hidden');
    // });
    document.getElementById('openAddUserModal').addEventListener('click', function () {
            document.getElementById('addUserModal').classList.remove('hidden');
        });
          // for the close (X) button
          document.getElementById('cancelAddUser').addEventListener('click', function () {
            document.getElementById('addUserModal').classList.add('hidden');
        });


    //      const password = document.getElementById('password').value;
    // const confirmPassword = document.getElementById('password_confirmation').value;
    // const passwordError = document.getElementById('passwordError');

    // Clear previous error
    // passwordError.textContent = '';

    // if (password !== confirmPassword) {
    //     passwordError.textContent = 'Passwords do not match.';
    //     return;
    // }
    document.getElementById('addUserForm').addEventListener('submit', function (e) {
        e.preventDefault();





        const form = e.target;
        const formData = new FormData(form);

        fetch("{{ route('users.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'  // Tell Laravel you want JSON
            },
            body: formData,
        })
        .then(async response => {
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Validation failed');
            }
            return response.json();
        })
        .then(data => {
            // document.getElementById('addProjectModal').classList.add('hidden');
            // // alert('Project created successfully!');
            // document.getElementById('successModal').classList.remove('hidden');
            // // Optionally refresh data here
            if (data)
            console.log(data);{

            document.getElementById('addUserModal').classList.add('hidden');
            document.getElementById('successModal1').classList.remove('hidden');

            //  alert('Project created successfully!');

        }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });


    //reloading the page
    document.getElementById('successOkBtn1').addEventListener('click', function () {
            document.getElementById('successModal1').classList.add('hidden');
            location.reload(); // refresh to update the table
        });


</script>

