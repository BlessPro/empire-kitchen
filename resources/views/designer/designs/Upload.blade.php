<div class="flex flex-col gap-8 md:flex-row">
    <!-- Image Section -->
    <div class="flex-1">
        <img id="mainImage" src="{{ asset('storage/designs/' . $design->images[0]) }}"
             class="object-contain w-full mb-4 rounded-lg" />

        <div class="flex gap-2 overflow-x-auto">
            @foreach ($design->images as $img)
                <img src="{{ asset('storage/designs/' . $img) }}"
                     onclick="document.getElementById('mainImage').src=this.src"
                     class="object-cover w-20 h-20 border rounded cursor-pointer hover:border-indigo-500"
                     alt="Thumbnail">
            @endforeach
        </div>
    </div>

    <!-- Notes Section -->
    <div class="flex-1">
        <h2 class="mb-2 text-xl font-semibold">Notes</h2>
        <div class="p-4 bg-gray-100 rounded-lg">
            <p class="text-gray-800">{{ $design->notes }}</p>
        </div>
    </div>
</div>
