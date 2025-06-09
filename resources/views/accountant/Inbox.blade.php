<x-accountant-layout>
    <x-slot name="header">
<!--written on 26.04.2025-->
        @include('admin.layouts.header')
            </x-slot>

        <main class="ml-64 mt-[70px]   flex-1 bg-gray-100   items-center">
        <!--head begins-->

<div class="flex h-screen">

    <!-- User List -->
    <div class="w-1/3 pt-4 overflow-y-auto bg-[#FCFDFF]">
        <div class="flex items-center justify-between p-4 border-b top">
          <h2 class="text-lg font-semibold">Inbox</h2>
          <button class="font-medium text-purple-700">+ Create</button>
        </div>
        <div class="pt-2 pl-4 pr-4 mt-4 mb-6 ml-7 mr-7">

          <input type="text" placeholder="Search messages" class="items-center w-full px-3 py-2 border-b border-gray-200 rounded-[10px]" />
        </div>
               @foreach($users as $user)
            <a href="{{ route('accountant.inbox', $user->id) }}"
               class="block   rounded {{ $userId == $user->id ? 'bg-yellow-50' : 'bg-white' }}">
          <ul>
               <li class="flex items-center px-4 py-3 space-x-3 border-b cursor-pointer hover:bg-yellow-50 ">
            <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        class="flex items-center justify-center w-[48px] h-[47px] font-bold text-white rounded-full mt-[-13px]"
                        alt="{{ $user->name }}'s profile picture">                  <div>
              <div class="pb-[3.5px] font-bold"> {{ $user->name }}</div>
              <div class="text-sm text-fuchsia-900 pb-[3px]"> {{ $user->role }}</div>
              <div class="text-xs text-gray-400">Can you check the server status?</div>
            </div>
          </li>
        </ul>
            </a>


        @endforeach
    </div>

    <!-- Chat Box -->
    <div class="flex  flex-col justify-between w-3/4 bg-[#F9F7F7]">
  <div id="chat" class="sticky top-[100px] left-0 z-30 flex items-center justify-between px-6 py-4 bg-white border-b">
    <div>
      <div class="font-bold">Kwesi Boadu</div>
      <div class="text-sm text-green-600">Online</div>
    </div>
    <div class="flex space-x-3">
      <button>⋮</button>
    </div>
  </div>
  <!-- other content -->


        <div id="chat-box" class="flex-1  overflow-y-auto bg-[#F9F7F7]">
            @if($messages)
                @foreach($messages as $message)

                <div class="mb-2 ml-4 mt-4 text-sm rounded-[9px]  {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                        <div class="inline-block p-2 rounded-lg
                            {{ $message->sender_id == auth()->id() ? 'bg-fuchsia-900 text-white ml-50' : 'bg-[#fff] text-black' }}">
                            {{ $message->message }}
                            <span class="text-[11px] ml-[5px] text-gray-500">  {{ $message->created_at->format('H:i') }} </span>

                        </div>
                        {{-- <div class="text-xs text-gray-500">
                            {{ $message->created_at->format('H:i') }}
                        </div> --}}
                    </div>
                @endforeach
            @endif
        </div>

        @if($userId)
        <form id="message-form" class="sticky bottom-0 left-0 z-30 flex p-4 border-t ">
            @csrf
            <input type="hidden" id="receiver_id" value="{{ $userId }}">
            <input type="text" id="message" class="flex-1 p-2 border-b border-gray-200 rounded-[10px]" placeholder="Write your message here...">
            <button type="submit" class="px-4 py-2 ml-2 text-white  bg-fuchsia-900 hover:bg-yellow-600 rounded-[10px]">Send</button>
        </form>
        @endif
    </div>
{{-- </div>
   </div>
        </div> --}}
        </main>


                 @vite(['resources/js/app.js'])

<script>
    const chatBox = document.getElementById('chat-box');
    const receiverId = document.getElementById('receiver_id')?.value;

    if (receiverId) {
        // Polling every 3 seconds
        setInterval(() => {
            fetch(`/accountant/inbox/fetch/${receiverId}`)
                .then(res => res.json())
                .then(data => {
                    chatBox.innerHTML = '';
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.classList.add('mb-2', 'flex', 'text-sm', 'ml-4', 'mt-4' , msg.sender_id == {{ auth()->id() }} ? 'justify-end' : 'justify-start');

                        div.innerHTML = `
                            <div class="inline-block p-2 shadow rounded-lg ${msg.sender_id == {{ auth()->id() }} ? 'bg-[#5A0562] text-white ml-50' : 'bg-[#fff] text-black'}">
                                ${msg.message}
                            <span class="text-[11px] ml-[5px] text-gray-300"> ${new Date(msg.created_at).toLocaleTimeString()}</span>

                            </div>
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

</x-accountant-layout>
