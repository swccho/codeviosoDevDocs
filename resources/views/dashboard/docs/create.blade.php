@extends('layouts.dashboard')

@section('title', 'Create doc')

@section('content')
<div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-6">Create doc</h1>
    @if($errors->any())
        <ul class="mb-4 text-red-600">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('dashboard.docs.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required minlength="5" maxlength="160" class="border rounded px-3 py-2 w-full">
            </div>
            <div>
                <label for="excerpt" class="block text-sm font-medium">Excerpt (optional)</label>
                <textarea name="excerpt" id="excerpt" rows="2" maxlength="300" class="border rounded px-3 py-2 w-full">{{ old('excerpt') }}</textarea>
            </div>
            <div>
                <label for="content" class="block text-sm font-medium">Content (markdown)</label>
                <textarea name="content" id="content" rows="10" required minlength="30" class="border rounded px-3 py-2 w-full">{{ old('content') }}</textarea>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium">Status</label>
                <select name="status" id="status" class="border rounded px-3 py-2">
                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div>
                <label for="cover_image" class="block text-sm font-medium">Cover image (optional, max 2MB)</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="border rounded px-3 py-2">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">Create</button>
            <a href="{{ route('dashboard.docs.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection
