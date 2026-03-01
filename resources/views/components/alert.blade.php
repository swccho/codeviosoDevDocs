@props(['type' => 'success', 'dismissible' => true])

@php
$styles = match($type) {
    'success' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
    'error'   => 'border-red-200 bg-red-50 text-red-800',
    'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
    'info'    => 'border-blue-200 bg-blue-50 text-blue-800',
    default   => 'border-zinc-200 bg-zinc-50 text-zinc-800',
};
$icon = match($type) {
    'success' => '<svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    'error'   => '<svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>',
    default   => '',
};
@endphp

<div
    {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-2xl border px-4 py-3 text-sm shadow-sm $styles", 'role' => 'alert']) }}
    @if($dismissible) x-data="{ show: true }" x-show="show" x-transition @endif
>
    {!! $icon !!}
    <span class="flex-1">{{ $slot }}</span>
    @if($dismissible)
        <button @click="show = false" class="ml-auto shrink-0 opacity-60 transition hover:opacity-100" aria-label="Dismiss">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    @endif
</div>
