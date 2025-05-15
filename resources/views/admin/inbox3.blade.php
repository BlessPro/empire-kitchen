<x-layouts.app>
    <x-slot name="header">
<!--written on 26.04.2025-->
        @include('admin.layouts.header')
        <main class="ml-64 mt-[100px] flex-1 bg-gray-100 min-h-screen  items-center">
        <!--head begins-->
<div class="flex">
    {{-- Sidebar --}}
    <div class="w-1/4 h-screen p-4 overflow-y-auto bg-gray-200">
        <h2 class="mb-4 text-xl font-bold">Users</h2>
        @foreach(App\Models\User::where('id', '!=', auth()->id())->get() as $chatUser)
            <a href="{{ route('inbox.index', $chatUser->id) }}" class="block px-3 py-2 rounded hover:bg-gray-300">
                {{ $chatUser->name }}
            </a>
        @endforeach
    </div>

    {{-- Chat Area --}}
    <div class="flex flex-col w-3/4 h-screen">
        <div id="chatBox" class="flex-1 p-4 space-y-2 overflow-y-auto">
            @foreach($messages as $msg)
                <div class="{{ $msg->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                    <p class="inline-block px-4 py-2 rounded-lg {{ $msg->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black' }}">
                        {{ $msg->message }}
                        <small class="block mt-1 text-xs text-gray-600">
                            {{ $msg->created_at->diffForHumans() }}
                        </small>
                    </p>
                </div>
            @endforeach
        </div>

        {{-- Input --}}
        <div class="p-4 bg-white border-t">
            <form id="chatForm">
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                <div class="flex">
                    <input type="text" name="message" class="w-full px-4 py-2 border rounded-l" placeholder="Type your message...">
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-r">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    const form = document.getElementById('chatForm');
    const chatBox = document.getElementById('chatBox');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const message = formData.get('message');
        const receiverId = formData.get('receiver_id');

        if (!message.trim()) return;

        const res = await axios.post('admin/inbox', {
            message: message,
            receiver_id: receiverId
        });

        appendMessage(res.data, true);
        form.reset();
    });

    function appendMessage(data, isSender = false) {
        const wrapper = document.createElement('div');
        wrapper.className = isSender ? 'text-right' : 'text-left';
        wrapper.innerHTML = `
            <p class="inline-block px-4 py-2 rounded-lg ${isSender ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black'}">
                ${data.message}
                <small class="block mt-1 text-xs text-gray-600">${new Date(data.created_at).toLocaleTimeString()}</small>
            </p>
        `;
        chatBox.appendChild(wrapper);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Echo listener
    Echo.private('chat.{{ auth()->id() }}')
        .listen('NewMessageEvent', (e) => {
            appendMessage(e.message, false);
        });
    </script>

         </div>
        </div>
        </main>
    </x-slot>
</x-layouts.app>
