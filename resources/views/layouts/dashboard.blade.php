<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/trix@2.1.0/dist/trix.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
    @stack('styles')
    @stack('scripts')
</head>
<body class="min-h-screen bg-zinc-50 font-[Inter,ui-sans-serif,system-ui,sans-serif] text-zinc-900 antialiased" x-data="{ sidebarOpen: false }">
    {{-- Mobile sidebar overlay --}}
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-50 lg:hidden" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-zinc-900/50" @click="sidebarOpen = false"></div>
        <aside class="fixed inset-y-0 left-0 flex w-72 flex-col bg-white shadow-xl" x-transition:enter="transition duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
            <div class="flex h-16 items-center justify-between border-b border-zinc-200 px-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-bold tracking-tight text-zinc-900">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-900 text-xs font-bold text-white">D</div>
                    DevDocs
                </a>
                <button @click="sidebarOpen = false" class="rounded-lg p-1 text-zinc-400 hover:bg-zinc-100 hover:text-zinc-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @include('layouts.partials.sidebar-nav')
        </aside>
    </div>

    <div class="flex min-h-screen">
        {{-- Desktop sidebar --}}
        <aside class="hidden w-64 shrink-0 border-r border-zinc-200/80 bg-white lg:block">
            <div class="flex h-16 items-center border-b border-zinc-200 px-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-bold tracking-tight text-zinc-900">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-900 text-xs font-bold text-white">D</div>
                    DevDocs
                </a>
            </div>
            @include('layouts.partials.sidebar-nav')
        </aside>

        {{-- Main content --}}
        <div class="flex flex-1 flex-col">
            {{-- Top bar (mobile hamburger + profile) --}}
            <header class="sticky top-0 z-40 flex h-16 items-center gap-4 border-b border-zinc-200/80 bg-white/80 px-4 shadow-sm backdrop-blur-xl sm:px-6 lg:px-8">
                <button @click="sidebarOpen = true" class="rounded-lg p-2 text-zinc-400 hover:bg-zinc-100 hover:text-zinc-600 lg:hidden">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
                <div class="flex-1"></div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-zinc-200 text-xs font-semibold text-zinc-700">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                        <span class="hidden sm:inline">{{ auth()->user()->name ?? 'User' }}</span>
                        <svg class="h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 rounded-xl border border-zinc-200 bg-white py-1 shadow-lg">
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-50">Home</a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-zinc-700 hover:bg-zinc-50">Log out</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-6"><x-alert type="success">{{ session('success') }}</x-alert></div>
                @endif
                @if(session('error'))
                    <div class="mb-6"><x-alert type="error">{{ session('error') }}</x-alert></div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
