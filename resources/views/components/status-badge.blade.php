@props(['status'])

@php
$styles = match($status) {
    'published' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
    'draft'     => 'bg-zinc-100 text-zinc-600 ring-zinc-500/20',
    default     => 'bg-zinc-100 text-zinc-600 ring-zinc-500/20',
};
$label = ucfirst($status);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset $styles"]) }}>
    {{ $label }}
</span>
