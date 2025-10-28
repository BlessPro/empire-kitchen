<?php
// =============================================
// resources/views/admin/projects/partials/comments-drawer.blade.php
// =============================================
?>
<div x-data="projectCommentsDrawer({
        projectId: {{ $project->id }},
        routes: {
            index: '{{ route('admin.projects.comments.index', ['project' => $project->id]) }}',
            store: '{{ route('admin.projects.comments.store', ['project' => $project->id]) }}',
            unread: '{{ route('admin.projects.comments.unread', ['project' => $project->id]) }}',
            seen: '{{ route('admin.projects.comments.markSeen', ['project' => $project->id]) }}',
        },
    })" x-init="init()" class="">

    {{-- Trigger Button --}}
    <button @click="open()" type="button" class="inline-flex items-center gap-2 border text-sm shadow-sm hover:bg-white-50 bg-white px-5 py-3 rounded-xl text-fuchsia-900">
        <span>Comment</span>
        <template x-if="badge > 0">
            <span class="ml-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-emerald-600 px-1 text-xs font-semibold text-white" x-text="`(${badge})`"></span>
        </template>
    </button>

    {{-- Backdrop --}}
    <div x-show="openDrawer" x-transition.opacity class="fixed inset-0 z-40 bg-black/30" @click="close()"></div>

    {{-- Drawer --}}
    <section x-show="openDrawer" x-transition class="fixed  right-0 top-0 z-50 h-full w-full max-w-md bg-white shadow-xl border-l flex flex-col">
        <header class="flex items-center justify-between border-b px-4 py-3">
            <h3 class="font-semibold">Project Comments</h3>
            <button @click="close()" class="p-2">✕</button>
        </header>

        {{-- List --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3" id="commentsScroll">
            <template x-if="loading">
                <div class="space-y-2">
                    <div class="h-3 w-2/3 animate-pulse rounded bg-neutral-200"></div>
                    <div class="h-3 w-1/2 animate-pulse rounded bg-neutral-200"></div>
                    <div class="h-3 w-1/3 animate-pulse rounded bg-neutral-200"></div>
                </div>
            </template>

            <template x-if="!loading && items.length === 0">
                <p class="text-sm text-neutral-500">No comments yet. Be the first to leave a note.</p>
            </template>

            <template x-for="c in items" :key="c.id">
                <div class="flex items-start gap-2" :class="{ 'justify-end': c.author.id === meId }">
                    <template x-if="c.author.id !== meId">
                        <img :src="c.author.avatar_url || placeholder(c.author.name)" class="h-7 w-7 rounded-full object-cover" alt="avatar" />
                    </template>

                    <div class="max-w-[80%] rounded-2xl px-3 py-2" :class="c.author.id === meId ? 'bg-emerald-50 border border-emerald-100' : 'bg-neutral-50 border border-neutral-200'">
                        <div class="text-[11px] text-neutral-500"><span x-text="c.author.name"></span> · <span x-text="shortTime(c.created_at)"></span></div>
                        <div class="text-sm whitespace-pre-wrap break-words" x-text="c.body"></div>
                    </div>

                    <template x-if="c.author.id === meId">
                        <img :src="c.author.avatar_url || placeholder(c.author.name)" class="h-7 w-7 rounded-full object-cover" alt="avatar" />
                    </template>
                </div>
            </template>
        </div>

        {{-- Composer --}}
        <footer class="border-t p-3">
            <form @submit.prevent="send()" class="flex items-end gap-2">
                @csrf
                <textarea x-model="draft" @keydown.enter.prevent="enterToSend($event)" @keydown.shift.enter.stop class="flex-1 resize-none rounded-xl border p-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" rows="1" placeholder="Type a message…"></textarea>
                <button type="submit" :disabled="draft.trim().length === 0 || sending" class="rounded-xl bg-emerald-600 px-3 py-2 text-sm font-medium text-white disabled:opacity-50">Send</button>
            </form>
        </footer>
    </section>
</div>

