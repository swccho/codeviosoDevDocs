@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>
    <p class="text-gray-600">Welcome to your dashboard.</p>
    <a href="{{ route('dashboard.docs.index') }}" class="inline-block mt-4 px-4 py-2 bg-gray-800 text-white rounded">My docs</a>
</div>
@endsection
