@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="mx-auto max-w-4xl">
    <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Dashboard</h1>
    <p class="mt-1 text-zinc-500">Welcome back. Here's a quick overview.</p>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('dashboard.docs.index') }}" class="group rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-zinc-200/50">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-100 text-zinc-600 transition group-hover:bg-zinc-900 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <h3 class="mt-4 text-base font-semibold text-zinc-900">My Docs</h3>
            <p class="mt-1 text-sm text-zinc-500">View and manage your documentation.</p>
        </a>

        <a href="{{ route('dashboard.docs.create') }}" class="group rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-zinc-200/50">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-100 text-zinc-600 transition group-hover:bg-zinc-900 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            </div>
            <h3 class="mt-4 text-base font-semibold text-zinc-900">New Doc</h3>
            <p class="mt-1 text-sm text-zinc-500">Create a new documentation page.</p>
        </a>

        <a href="{{ route('home') }}" class="group rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-zinc-200/50">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-100 text-zinc-600 transition group-hover:bg-zinc-900 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
            </div>
            <h3 class="mt-4 text-base font-semibold text-zinc-900">Browse Public</h3>
            <p class="mt-1 text-sm text-zinc-500">See published community docs.</p>
        </a>
    </div>
</div>
@endsection
