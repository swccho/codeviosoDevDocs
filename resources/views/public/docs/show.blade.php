@extends('layouts.app')

@section('title', $doc->title)

@section('content')
<article class="mx-auto max-w-4xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
    <a href="{{ route('home') }}" class="mb-6 inline-flex items-center gap-1.5 text-sm font-medium text-zinc-500 transition hover:text-zinc-900">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to docs
    </a>

    <div class="overflow-hidden rounded-2xl border border-zinc-200/80 bg-white shadow-sm">
        @if($doc->cover_path)
            <div class="aspect-[21/9] w-full overflow-hidden bg-zinc-100">
                <img src="{{ asset('storage/'.$doc->cover_path) }}" alt="" class="h-full w-full object-cover" />
            </div>
        @endif
        <div class="p-6 sm:p-10">
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">{{ $doc->title }}</h1>
            <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-zinc-500">
                @if($doc->user)
                    <div class="flex items-center gap-2">
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-zinc-200 text-xs font-semibold text-zinc-700">{{ strtoupper(substr($doc->user->name, 0, 1)) }}</div>
                        <span>{{ $doc->user->name }}</span>
                    </div>
                @endif
                @if($doc->published_at)
                    <time datetime="{{ $doc->published_at->toIso8601String() }}">{{ $doc->published_at->format('F j, Y') }}</time>
                @endif
            </div>
            @if($doc->excerpt)
                <p class="mt-6 rounded-xl bg-zinc-50 px-5 py-4 text-base leading-relaxed text-zinc-600">{{ $doc->excerpt }}</p>
            @endif
            <div class="prose prose-zinc mt-8 max-w-none prose-headings:font-semibold prose-a:text-zinc-700 prose-a:underline prose-a:underline-offset-2 hover:prose-a:text-zinc-900 prose-img:rounded-xl">
                @if(str_contains($doc->content, '</') || preg_match('/^\s*</', $doc->content))
                    {!! sanitize_doc_html($doc->content) !!}
                @else
                    {!! Str::markdown($doc->content) !!}
                @endif
            </div>
        </div>
    </div>
</article>
@endsection
