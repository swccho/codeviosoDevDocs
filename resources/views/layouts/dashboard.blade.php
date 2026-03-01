<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">
    <header class="border-b border-gray-200 dark:border-gray-700">
        <nav class="max-w-4xl mx-auto p-4 flex items-center gap-4">
            <a href="{{ route('home') }}" class="font-medium">{{ config('app.name') }}</a>
            <a href="{{ route('dashboard.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Dashboard</a>
            <a href="{{ route('dashboard.docs.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">My docs</a>
            <form action="{{ route('logout') }}" method="post" class="ml-auto">
                @csrf
                <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Log out</button>
            </form>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
