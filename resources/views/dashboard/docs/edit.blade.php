@extends('layouts.dashboard')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@2.1.0/dist/trix.umd.min.js"></script>
@endpush

@section('title', 'Edit: ' . $doc->title)

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('dashboard.docs.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-zinc-500 transition hover:text-zinc-900">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to docs
        </a>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Edit Doc</h1>
        <x-status-badge :status="$doc->status" />
    </div>

    @if($errors->any())
        <div class="mt-4">
            <x-alert type="error" :dismissible="false">
                <ul class="list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        </div>
    @endif

    <div class="mt-6 overflow-hidden rounded-2xl border border-zinc-200/80 bg-white shadow-sm">
        <form action="{{ route('dashboard.docs.update', $doc) }}" method="post" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-zinc-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $doc->title) }}" minlength="5" maxlength="160" {{ $doc->status === 'published' ? 'readonly' : '' }} class="mt-2 block h-11 w-full rounded-xl border border-zinc-200 bg-white px-4 text-zinc-900 shadow-sm transition placeholder:text-zinc-400 focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100 {{ $doc->status === 'published' ? 'bg-zinc-50 text-zinc-500' : '' }}" placeholder="Enter document title…" />
                    @if($doc->status === 'published')
                        <p class="mt-1.5 text-xs text-zinc-400">Title is locked after publishing (slug stability).</p>
                    @endif
                </div>
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-zinc-700">Excerpt <span class="text-zinc-400">(optional)</span></label>
                    <textarea name="excerpt" id="excerpt" rows="2" maxlength="300" class="mt-2 block w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-zinc-900 shadow-sm transition placeholder:text-zinc-400 focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100" placeholder="A short summary of your doc…">{{ old('excerpt', $doc->excerpt) }}</textarea>
                </div>
                <div>
                    <label for="content" class="block text-sm font-medium text-zinc-700">Content</label>
                    <input id="content" type="hidden" name="content" value="{!! str_replace('"', '&quot;', old('content', $contentForEditor ?? $doc->content)) !!}" minlength="30">
                    <trix-editor input="content" class="trix-content mt-2 min-h-[300px] rounded-xl border border-zinc-200 bg-white shadow-sm [&_.trix-button-group]:rounded-lg [&_.trix-button-group]:border-zinc-200 [&_.trix-editor]:min-h-[260px] [&_.trix-editor]:p-4 [&_.trix-editor]:outline-none" placeholder="Write your content…"></trix-editor>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="status" class="block text-sm font-medium text-zinc-700">Status</label>
                        <select name="status" id="status" class="mt-2 block h-11 w-full rounded-xl border border-zinc-200 bg-white px-4 text-zinc-900 shadow-sm transition focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100">
                            <option value="draft" {{ old('status', $doc->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $doc->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-zinc-700">Cover image <span class="text-zinc-400">(max 20MB)</span></label>
                        @if($doc->cover_path)
                            <div class="mt-2 flex items-center gap-3">
                                <img src="{{ asset('storage/'.$doc->cover_path) }}" alt="" class="h-11 w-auto rounded-lg border border-zinc-200 object-cover" />
                                <span class="text-xs text-zinc-400">Upload new to replace.</span>
                            </div>
                        @endif
                        <div class="mt-2 flex h-11 w-full items-center rounded-xl border border-zinc-200 bg-white shadow-sm transition hover:border-zinc-300">
                            <input type="file" name="cover_image" id="cover_image" accept="image/*" class="block w-full text-sm text-zinc-500 file:mr-3 file:border-0 file:bg-transparent file:px-4 file:py-2 file:text-sm file:font-medium file:text-zinc-700" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex items-center gap-3 border-t border-zinc-100 pt-6">
                <button type="submit" class="inline-flex h-11 items-center rounded-xl bg-zinc-900 px-6 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-zinc-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2">
                    Update Doc
                </button>
                <a href="{{ route('dashboard.docs.index') }}" class="inline-flex h-11 items-center rounded-xl border border-zinc-200 bg-white px-6 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
