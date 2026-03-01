@php
    $currentRoute = Route::currentRouteName();
    $links = [
        ['route' => 'dashboard.index', 'label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>'],
        ['route' => 'dashboard.docs.index', 'label' => 'My Docs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>'],
        ['route' => 'dashboard.docs.create', 'label' => 'New Doc', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>'],
    ];
@endphp

<nav class="flex flex-1 flex-col gap-1 p-4">
    @foreach($links as $link)
        @php
            $active = str_starts_with($currentRoute, $link['route']);
        @endphp
        <a
            href="{{ route($link['route']) }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ $active ? 'bg-zinc-900 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}"
        >
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">{!! $link['icon'] !!}</svg>
            {{ $link['label'] }}
        </a>
    @endforeach
</nav>
