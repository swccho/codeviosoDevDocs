@extends('layouts.app')

@section('title', $doc->title)

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <article>
        <h1 class="text-3xl font-semibold mb-2">{{ $doc->title }}</h1>
        @if($doc->user)
            <p class="text-sm text-gray-600 mb-4">By {{ $doc->user->name }}</p>
        @endif
        @if($doc->excerpt)
            <p class="text-gray-700 mb-4">{{ $doc->excerpt }}</p>
        @endif
        <div class="prose max-w-none">
            {!! Str::markdown($doc->content) !!}
        </div>
    </article>
    <p class="mt-6"><a href="{{ route('home') }}" class="text-blue-600 hover:underline">← Back to docs</a></p>
</div>
@endsection
