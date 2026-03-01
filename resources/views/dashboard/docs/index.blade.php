@extends('layouts.dashboard')

@section('title', 'My docs')

@section('content')
<div class="mx-auto max-w-4xl" x-data="{ deleteDoc: null, filter: '{{ request('filter', 'all') }}' }">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">My Docs</h1>
            <p class="mt-1 text-sm text-zinc-500">Manage all your documentation in one place.</p>
        </div>
        <a
            href="{{ route('dashboard.docs.create') }}"
            class="inline-flex h-10 shrink-0 items-center gap-2 rounded-xl bg-zinc-900 px-4 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-zinc-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            New Doc
        </a>
    </div>

    {{-- Filter tabs --}}
    <div class="mt-6 flex gap-1 rounded-xl bg-zinc-100 p-1">
        @foreach(['all' => 'All', 'draft' => 'Drafts', 'published' => 'Published'] as $key => $label)
            <a
                href="{{ route('dashboard.docs.index', array_merge(request()->query(), ['filter' => $key])) }}"
                class="flex-1 rounded-lg px-4 py-2 text-center text-sm font-medium transition {{ request('filter', 'all') === $key ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-700' }}"
            >
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($docs->isEmpty())
        <div class="mt-8 rounded-2xl border border-dashed border-zinc-300 bg-white p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            <h3 class="mt-4 text-base font-semibold text-zinc-900">No docs yet</h3>
            <p class="mt-1 text-sm text-zinc-500">Get started by creating your first document.</p>
            <a href="{{ route('dashboard.docs.create') }}" class="mt-6 inline-flex h-10 items-center gap-2 rounded-xl bg-zinc-900 px-5 text-sm font-medium text-white shadow-sm transition hover:bg-zinc-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Create your first doc
            </a>
        </div>
    @else
        <div class="mt-6 space-y-3">
            @foreach($docs as $doc)
                <div class="group rounded-2xl border border-zinc-200/80 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md hover:shadow-zinc-200/50">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        {{-- Thumbnail --}}
                        <div class="hidden h-14 w-20 shrink-0 overflow-hidden rounded-xl bg-zinc-100 sm:block">
                            @if($doc->cover_path)
                                <img src="{{ asset('storage/'.$doc->cover_path) }}" alt="" class="h-full w-full object-cover" loading="lazy" />
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <svg class="h-6 w-6 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="truncate text-base font-semibold text-zinc-900">{{ $doc->title }}</h3>
                                <x-status-badge :status="$doc->status" />
                            </div>
                            @if($doc->excerpt)
                                <p class="mt-0.5 line-clamp-1 text-sm text-zinc-500">{{ Str::limit($doc->excerpt, 100) }}</p>
                            @endif
                            <p class="mt-1 text-xs text-zinc-400">Updated {{ $doc->updated_at->diffForHumans() }}</p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-wrap items-center gap-2">
                            @if($doc->status === 'published')
                                <a
                                    href="{{ route('docs.show', $doc->slug) }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-3 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                                >
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                    View
                                </a>
                            @endif
                            <a
                                href="{{ route('dashboard.docs.edit', $doc) }}"
                                class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-3 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                Edit
                            </a>
                            @if($doc->status === 'draft')
                                <form action="{{ route('dashboard.docs.publish', $doc) }}" method="post" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex h-9 items-center rounded-lg bg-emerald-600 px-3 text-sm font-medium text-white shadow-sm transition hover:bg-emerald-700">
                                        Publish
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('dashboard.docs.unpublish', $doc) }}" method="post" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex h-9 items-center rounded-lg border border-amber-200 bg-amber-50 px-3 text-sm font-medium text-amber-700 transition hover:bg-amber-100">
                                        Unpublish
                                    </button>
                                </form>
                            @endif
                            <button
                                type="button"
                                @click="deleteDoc = { title: {{ Js::from($doc->title) }}, url: {{ Js::from(route('dashboard.docs.destroy', $doc)) }} }"
                                class="inline-flex h-9 items-center rounded-lg border border-red-200 bg-white px-3 text-sm font-medium text-red-600 transition hover:bg-red-50"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($docs->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $docs->links() }}
            </div>
        @endif
    @endif

    {{-- Delete confirmation dialog (must be inside x-data so Alpine scope is preserved when teleported to body) --}}
    <template x-teleport="body">
        <div
            x-show="deleteDoc !== null"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="deleteDoc = null"
        >
            <div class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm" @click="deleteDoc = null" aria-hidden="true"></div>
            <div
                role="dialog"
                aria-modal="true"
                aria-labelledby="delete-dialog-title"
                class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
                x-show="deleteDoc !== null"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <h2 id="delete-dialog-title" class="mt-4 text-lg font-semibold text-zinc-900">Delete document</h2>
                <p class="mt-2 text-sm text-zinc-500" x-text="deleteDoc ? 'Are you sure you want to delete &quot;' + deleteDoc.title + '&quot;? This action cannot be undone.' : ''"></p>
                <div class="mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        @click="deleteDoc = null"
                        class="inline-flex h-10 items-center rounded-xl border border-zinc-200 bg-white px-4 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                    >
                        Cancel
                    </button>
                    <template x-if="deleteDoc">
                        <form :action="deleteDoc?.url" method="post" class="inline">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="inline-flex h-10 items-center rounded-xl bg-red-600 px-4 text-sm font-medium text-white shadow-sm transition hover:bg-red-700"
                            >
                                Delete
                            </button>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
