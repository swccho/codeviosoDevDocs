@extends('layouts.dashboard')

@section('title', 'My docs')

@section('content')
<div class="p-6">
    @if(session('success'))
        <p class="mb-4 text-green-600">{{ session('success') }}</p>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">My docs</h1>
        <a href="{{ route('dashboard.docs.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded">New doc</a>
    </div>
    @if($docs->isEmpty())
        <p>No docs yet. <a href="{{ route('dashboard.docs.create') }}" class="text-blue-600 hover:underline">Create one</a>.</p>
    @else
        <ul class="space-y-3">
            @foreach($docs as $doc)
                <li class="flex items-center gap-4 border rounded p-3">
                    <span class="font-medium">{{ $doc->title }}</span>
                    <span class="text-sm text-gray-500">{{ $doc->status }}</span>
                    <a href="{{ route('docs.show', $doc->slug) }}" class="text-sm text-blue-600 hover:underline" target="_blank">View</a>
                    <a href="{{ route('dashboard.docs.edit', $doc) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                    @if($doc->status === 'draft')
                        <form action="{{ route('dashboard.docs.publish', $doc) }}" method="post" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-green-600 hover:underline">Publish</button>
                        </form>
                    @else
                        <form action="{{ route('dashboard.docs.unpublish', $doc) }}" method="post" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-amber-600 hover:underline">Unpublish</button>
                        </form>
                    @endif
                    <form action="{{ route('dashboard.docs.destroy', $doc) }}" method="post" class="inline" onsubmit="return confirm('Delete this doc?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <div class="mt-6">{{ $docs->links() }}</div>
    @endif
</div>
@endsection
