@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Documentation</h1>

    <form action="{{ url('/') }}" method="get" class="mb-6">
        <input type="search" name="search" value="{{ old('search', $search) }}" placeholder="Search docs…" class="border rounded px-3 py-2 w-full max-w-md">
        <button type="submit" class="mt-2 px-4 py-2 bg-gray-800 text-white rounded">Search</button>
    </form>

    @if($docs->isEmpty())
        <p>No published docs yet.</p>
    @else
        <ul class="space-y-4">
            @foreach($docs as $doc)
                <li>
                    <a href="{{ route('docs.show', $doc->slug) }}" class="text-blue-600 hover:underline">{{ $doc->title }}</a>
                    @if($doc->excerpt)
                        <p class="text-sm text-gray-600">{{ Str::limit($doc->excerpt, 120) }}</p>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="mt-6">
            {{ $docs->links() }}
        </div>
    @endif
</div>
@endsection
