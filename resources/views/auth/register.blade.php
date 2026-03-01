@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex min-h-[calc(100vh-12rem)] items-center justify-center px-4 py-12 sm:px-6">
    <div class="w-full max-w-sm">
        <div class="mb-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-900 text-lg font-bold text-white">D</div>
            <h1 class="mt-4 text-2xl font-bold tracking-tight text-zinc-900">Create an account</h1>
            <p class="mt-1 text-sm text-zinc-500">Join the community and start sharing docs</p>
        </div>

        <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm sm:p-8">
            @if($errors->any())
                <div class="mb-6">
                    <x-alert type="error" :dismissible="false">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </x-alert>
                </div>
            @endif
            <form method="post" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus class="mt-2 block h-11 w-full rounded-xl border border-zinc-200 bg-white px-4 text-zinc-900 shadow-sm transition placeholder:text-zinc-400 focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100" placeholder="Your name" />
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-2 block h-11 w-full rounded-xl border border-zinc-200 bg-white px-4 text-zinc-900 shadow-sm transition placeholder:text-zinc-400 focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100" placeholder="you@example.com" />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700">Password</label>
                    <input type="password" name="password" id="password" required class="mt-2 block h-11 w-full rounded-xl border border-zinc-200 bg-white px-4 text-zinc-900 shadow-sm transition placeholder:text-zinc-400 focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100" />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-zinc-700">Confirm password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-2 block h-11 w-full rounded-xl border border-zinc-200 bg-white px-4 text-zinc-900 shadow-sm transition placeholder:text-zinc-400 focus:border-zinc-300 focus:outline-none focus:ring-4 focus:ring-zinc-100" />
                </div>
                <button type="submit" class="h-11 w-full rounded-xl bg-zinc-900 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-zinc-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2">
                    Create account
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-zinc-500">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-zinc-900 underline-offset-2 hover:underline">Sign in</a>
        </p>
    </div>
</div>
@endsection
