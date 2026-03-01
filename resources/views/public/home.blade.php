@extends('layouts.app')

@section('title', 'Home')

@section('content')
{{-- Hero --}}
<section class="relative overflow-hidden border-b border-zinc-200/80 bg-white">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_50%_at_50%_-20%,rgba(120,119,198,0.12),transparent)]"></div>
    <div class="relative mx-auto max-w-3xl px-4 py-20 sm:px-6 sm:py-28 lg:py-32">
        <h1 class="text-center text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl lg:text-6xl">
            Discover Community<br class="hidden sm:inline"> Documentation
        </h1>
        <p class="mx-auto mt-4 max-w-xl text-center text-lg text-zinc-500 sm:mt-6">
            Browse, search, and share knowledge. Quality docs built by the community.
        </p>
        <form action="{{ url('/') }}" method="get" class="mt-8 sm:mt-10">
            <div class="relative mx-auto max-w-xl">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </div>
                <input
                    type="search"
                    name="search"
                    value="{{ old('search', $search) }}"
                    placeholder="Search by title or excerpt…"
                    class="block h-14 w-full rounded-2xl border border-zinc-200 bg-white pl-12 pr-32 text-base text-zinc-900 shadow-lg shadow-zinc-200/50 transition placeholder:text-zinc-400 focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100"
                />
                <div class="absolute inset-y-0 right-2 flex items-center">
                    <button
                        type="submit"
                        class="inline-flex h-10 items-center rounded-xl bg-zinc-900 px-5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-zinc-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2"
                    >
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- Doc listing --}}
<section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
    @if($search)
        <div class="mb-6 flex items-center gap-3">
            <p class="text-sm text-zinc-500">Showing results for <strong class="text-zinc-900">"{{ $search }}"</strong></p>
            <a href="{{ url('/') }}" class="text-sm font-medium text-zinc-600 underline underline-offset-2 hover:text-zinc-900">Clear</a>
        </div>
    @endif

    @if($docs->isEmpty())
        <div class="rounded-2xl border border-dashed border-zinc-300 bg-white p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            <h3 class="mt-4 text-base font-semibold text-zinc-900">No docs found</h3>
            <p class="mt-1 text-sm text-zinc-500">Be the first to share something with the community.</p>
            @auth
                <a href="{{ route('dashboard.docs.create') }}" class="mt-6 inline-flex h-10 items-center rounded-xl bg-zinc-900 px-5 text-sm font-medium text-white shadow-sm transition hover:bg-zinc-800">Create a doc</a>
            @endauth
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($docs as $doc)
                <x-doc-card :doc="$doc" />
            @endforeach
        </div>
        @if($docs->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $docs->links() }}
            </div>
        @endif
    @endif
</section>
@endsection
