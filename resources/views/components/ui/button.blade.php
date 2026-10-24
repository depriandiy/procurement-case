@props([
    'type' => 'button',
    'variant' => 'primary',
    'href' => null,
])

@php
    $classes = [
        'inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
        'bg-brand-700 text-white shadow-sm hover:bg-brand-800' => $variant === 'primary',
        'border border-slate-300 bg-white text-slate-700 hover:border-slate-400 hover:bg-slate-50' => $variant === 'secondary',
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
