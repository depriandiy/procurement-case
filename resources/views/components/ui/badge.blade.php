@props(['variant' => 'neutral'])

<span {{ $attributes->class([
    'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold',
    'bg-slate-100 text-slate-700' => $variant === 'neutral',
    'bg-emerald-100 text-emerald-800' => $variant === 'success',
    'bg-amber-100 text-amber-900' => $variant === 'warning',
    'bg-red-100 text-red-800' => $variant === 'danger',
]) }}>{{ $slot }}</span>
