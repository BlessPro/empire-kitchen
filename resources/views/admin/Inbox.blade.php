<x-layouts.app>
    <x-slot name="header">
  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7]  items-center">

    <!--head begins-->
            <div class=" bg-[#F9F7F7]">
             <div class="">

<main class="flex flex-col flex-1">
    <!-- Topbar -->


    <!-- Messaging Interface -->
    <div class="flex flex-1 overflow-hidden">
      <!-- Chat List -->
      <aside class="w-1/3 p-4 overflow-y-auto bg-white border-r">
        <div class="flex items-center justify-between p-4 border-b">
          <h2 class="text-lg font-semibold">Inbox</h2>
          <button class="font-medium text-purple-700">+ Create</button>
        </div>
        <div class="px-4 py-2">
          <input type="text" placeholder="Search messages" class="w-full px-3 py-2 border rounded" />
        </div>
        <!-- Contact List -->
        @foreach($users as $user)
        <a href="{{ route('inbox', $user->id) }}"
           class="block p-2 mb-2 rounded {{ $userId == $user->id ? 'bg-blue-200' : 'bg-white' }}">
            <ul>
          <li class="flex items-center px-4 py-3 space-x-3 border-b cursor-pointer hover:bg-gray-100">
 <img
                        src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        class="flex items-center justify-center w-[48px] h-[47px] font-bold text-white rounded-full mt-[-13px]"
                        alt="{{ $user->name }}'s profile picture">              <div>
              <div class="font-bold">{{ $user->name }}</div>
              <div class="text-sm text-gray-500">{{ $user->role }}</div>
              <div class="text-xs text-gray-400">Can you check the server status?</div>
            </div>
               </li>
            </ul>
        </a>
            @endforeach




                              <!-- Repeat for other users -->
                            </ul>
      </aside>

      <!-- Chat Window -->
      <section class="flex flex-col flex-1 bg-gray-100">
        <div class="flex items-center justify-between px-6 py-4 bg-white border-b">
          <div>
            <div class="font-bold">Kwesi Boadu</div>
            <div class="text-sm text-green-600">Online</div>
          </div>
          <div class="flex space-x-3">
            <button>⋮</button>
          </div>
        </div>

        <!-- Chat Messages -->
        <div class="flex-1 p-6 space-y-4 overflow-y-auto">

            {{-- message received begins--}}
          <div class="flex justify-start ">
            <img src="admin-profile.jpg" class="flex items-center justify-center w-[42px] h-[42px] font-bold text-white rounded-full mr-3" alt="">

            <div class="px-4 py-2 text-sm bg-white rounded-[9px] shadow">Yes Sir <span class="ml-2 text-xs text-gray-400">11:25</span></div>
          </div>

           {{-- message received ends--}}

            {{-- message send begins--}}

           {{-- message sent begins--}}
          <div class="flex justify-end">

            <div class="px-4 py-2 text-sm text-white bg-purple-700 rounded-[9px] shadow">Thanks! Let me know ASAP... <span class="ml-2 text-xs text-white">11:25</span></div>
          </div>
           {{-- message received ends--}}
          {{-- <div class="flex justify-start">
                        <img src="admin-profile.jpg" class="flex items-center justify-center w-[42px] h-[42px] font-bold text-white rounded-full mr-3" alt="">

            <div class="px-4 py-2 text-sm bg-white rounded-[9px] shadow">Will update you in 30 mins. <span class="ml-2 text-xs text-gray-400">11:25</span></div>
          </div> --}}
          {{-- <div class="flex justify-start">
                        <img src="admin-profile.jpg" class="flex items-center justify-center w-[42px] h-[42px] font-bold text-white rounded-full mr-3" alt="">

            <div class="px-4 py-2 text-sm bg-white rounded-[9px] shadow">Do you want it to trigger... <span class="ml-2 text-xs text-gray-400">11:25</span></div>
          </div> --}}
          {{-- <div class="flex justify-end">
            <div class="px-4 py-2 text-sm text-white bg-purple-700 rounded-[9px] shadow">Just a report for now... <span class="ml-2 text-xs text-white">11:25</span></div>
          </div> --}}
          {{-- <div class="text-xs text-center text-gray-500">12 January</div> --}}
          {{-- <div class="flex justify-start">
                <img src="admin-profile.jpg" class="flex items-center justify-center w-[42px] h-[42px] font-bold text-white rounded-full mr-3" alt="">

            <div class="px-4 py-2 text-sm bg-white rounded-[9px] shadow">One of the measurements... <span class="ml-2 text-xs text-gray-400">11:25</span></div>
          </div> --}}
          {{-- <div class="flex justify-end">
            <div class="px-4 py-2 text-sm text-white bg-purple-700 rounded-[9px] shadow">Great. Keep me posted. <span class="ml-2 text-xs text-white">11:25</span></div>
          </div> --}}
        </div>

        <!-- Message Input -->
        <div class="flex items-center p-4 space-x-4 bg-white border-t">
          <input type="text" placeholder="Write your message here..." class="flex-1 px-4 py-2 border rounded" />
          <button class="px-4 py-2 text-white bg-purple-700 rounded hover:bg-purple-800">Send</button>
        </div>
      </section>
         <ul class="space-y-4" id="commentsList">

    </div>
  </main>











</div>
</div>
</main>


         @vite(['resources/js/app.js'])
<script>
    const chatBox = document.getElementById('chat-box');
    const receiverId = document.getElementById('receiver_id')?.value;

    if (receiverId) {
        // Polling every 3 seconds
        setInterval(() => {
            fetch(`/inbox/fetch/${receiverId}`)
                .then(res => res.json())
                .then(data => {
                    chatBox.innerHTML = '';
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.classList.add('mb-2', 'text-sm', msg.sender_id == {{ auth()->id() }} ? 'text-right' : 'text-left');

                        div.innerHTML = `
                            <div class="inline-block p-2 rounded-lg ${msg.sender_id == {{ auth()->id() }} ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black'}">
                                ${msg.message}
                            </div>
                            <div class="text-xs text-gray-500">${new Date(msg.created_at).toLocaleTimeString()}</div>
                        `;
                        chatBox.appendChild(div);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }, 3000);

        // Send message
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('message');
            const message = messageInput.value;

            fetch("{{ route('inbox.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    receiver_id: receiverId,
                    message: message
                })
            }).then(res => res.json()).then(data => {
                messageInput.value = '';
            });
        });
    }
</script>
</x-slot>
</x-layouts.app>

