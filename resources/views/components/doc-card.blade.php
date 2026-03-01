@props(['doc'])

<a
    href="{{ route('docs.show', $doc->slug) }}"
    class="group flex flex-col overflow-hidden rounded-2xl border border-zinc-200/80 bg-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-zinc-200/50"
>
    <div class="aspect-[16/9] w-full overflow-hidden bg-zinc-100">
        @if($doc->cover_path)
            <img
                src="{{ asset('storage/'.$doc->cover_path) }}"
                alt=""
                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                loading="lazy"
            />
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-100 to-zinc-200">
                <svg class="h-10 w-10 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-base font-semibold leading-snug text-zinc-900 transition group-hover:text-zinc-600">{{ $doc->title }}</h3>
        @if($doc->excerpt)
            <p class="mt-1.5 line-clamp-2 flex-1 text-sm leading-relaxed text-zinc-500">{{ Str::limit($doc->excerpt, 120) }}</p>
        @endif
        <div class="mt-4 flex items-center gap-2 text-xs text-zinc-400">
            @if($doc->user)
                <span class="font-medium text-zinc-500">{{ $doc->user->name }}</span>
                <span>·</span>
            @endif
            @if($doc->published_at)
                <time datetime="{{ $doc->published_at->toIso8601String() }}">{{ $doc->published_at->format('M j, Y') }}</time>
            @endif
        </div>
    </div>
</a>
