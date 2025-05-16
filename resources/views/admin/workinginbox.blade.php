<x-layouts.app>
    <x-slot name="header">
  <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7]  items-center">

    <!--head begins-->
            <div class=" bg-[#F9F7F7]">
             <div class="">
<div class="flex h-[100%]">
    <!-- User List -->
  <div class="w-1/4 p-4 overflow-y-auto bg-gray-100">
    <h2 class="mb-4 text-lg font-bold">Users</h2>

    @foreach($users as $user)
        <a href="{{ route('inbox', $user->id) }}"
           class="block p-2 mb-2 rounded {{ $userId == $user->id ? 'bg-blue-200' : 'bg-white' }}">
            <ul>
                <li class="flex items-center px-4 py-3 space-x-3 border-b cursor-pointer hover:bg-gray-100">
                    <img
                        src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        class="flex items-center justify-center w-[48px] h-[47px] font-bold text-white rounded-full mt-[-13px]"
                        alt="{{ $user->name }}'s profile picture">

                    <div>
                        <div class="font-bold">{{ $user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $user->role }}</div>
                        <div class="text-xs text-gray-400">Can you check the server status?</div>
                    </div>
                </li>
            </ul>
        </a>
    @endforeach
</div>


    <!-- Chat Box -->
    <div class="flex flex-col justify-between w-3/4">
        <div id="chat-box" class="flex-1 p-4 overflow-y-auto bg-white">
            @if($messages)
                @foreach($messages as $message)
                    <div class="mb-2 text-sm {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                        <div class="inline-block p-2 rounded-lg
                            {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black' }}">
                            {{ $message->message }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $message->created_at->format('H:i') }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if($userId)
        <form id="message-form" class="flex p-4 border-t">
            @csrf
            <input type="hidden" id="receiver_id" value="{{ $userId }}">
            <input type="text" id="message" class="flex-1 p-2 border rounded" placeholder="Type your message...">
            <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-500 rounded">Send</button>
        </form>
        @endif
    </div>
</div>



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
