<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
    @stack('styles')
    @stack('scripts')
</head>
<body class="min-h-screen bg-zinc-50 font-[Inter,ui-sans-serif,system-ui,sans-serif] text-zinc-900 antialiased">
    {{-- Navbar --}}
    <header class="sticky top-0 z-50 border-b border-zinc-200/80 bg-white/80 shadow-sm backdrop-blur-xl">
        <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-bold tracking-tight text-zinc-900 transition hover:opacity-80">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-900 text-xs font-bold text-white">D</div>
                <span class="hidden sm:inline">DevDocs</span>
            </a>
            <div class="flex items-center gap-1">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900">Home</a>
                @auth
                    <a href="{{ route('dashboard.docs.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900">My Docs</a>
                    <a href="{{ route('dashboard.index') }}" class="ml-1 inline-flex h-9 items-center rounded-lg bg-zinc-900 px-3.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:bg-zinc-800 hover:shadow-md">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900">Log in</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-1 inline-flex h-9 items-center rounded-lg bg-zinc-900 px-3.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:bg-zinc-800 hover:shadow-md">Register</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @if(session('success'))
            <div class="mx-auto max-w-6xl px-4 pt-4 sm:px-6 lg:px-8">
                <x-alert type="success">{{ session('success') }}</x-alert>
            </div>
        @endif
        @if(session('error'))
            <div class="mx-auto max-w-6xl px-4 pt-4 sm:px-6 lg:px-8">
                <x-alert type="error">{{ session('error') }}</x-alert>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-auto border-t border-zinc-200/80 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-zinc-400">&copy; {{ date('Y') }} DevDocs. Built with Laravel.</p>
        </div>
    </footer>
</body>
</html>
