@extends('layouts.dashboard')

@section('title', 'Edit: ' . $doc->title)

@section('content')
<div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-6">Edit doc</h1>
    @if($errors->any())
        <ul class="mb-4 text-red-600">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('dashboard.docs.update', $doc) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $doc->title) }}" minlength="5" maxlength="160" class="border rounded px-3 py-2 w-full" {{ $doc->status === 'published' ? 'readonly' : '' }}>
                @if($doc->status === 'published')
                    <p class="text-sm text-gray-500 mt-1">Slug cannot be changed after publish.</p>
                @endif
            </div>
            <div>
                <label for="excerpt" class="block text-sm font-medium">Excerpt (optional)</label>
                <textarea name="excerpt" id="excerpt" rows="2" maxlength="300" class="border rounded px-3 py-2 w-full">{{ old('excerpt', $doc->excerpt) }}</textarea>
            </div>
            <div>
                <label for="content" class="block text-sm font-medium">Content (markdown)</label>
                <textarea name="content" id="content" rows="10" minlength="30" class="border rounded px-3 py-2 w-full">{{ old('content', $doc->content) }}</textarea>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium">Status</label>
                <select name="status" id="status" class="border rounded px-3 py-2">
                    <option value="draft" {{ old('status', $doc->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $doc->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div>
                <label for="cover_image" class="block text-sm font-medium">Cover image (optional, max 2MB)</label>
                @if($doc->cover_path)
                    <p class="text-sm text-gray-500 mb-1">Current: <img src="{{ asset('storage/'.$doc->cover_path) }}" alt="" class="inline-block h-12 w-auto rounded"></p>
                @endif
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="border rounded px-3 py-2">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Update</button>
            <a href="{{ route('dashboard.docs.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection
