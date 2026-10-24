@props(['variant' => 'info'])

<div
    role="status"
    {{ $attributes->class([
        'rounded-xl border px-4 py-3 text-sm',
        'border-blue-200 bg-blue-50 text-blue-900' => $variant === 'info',
        'border-emerald-200 bg-emerald-50 text-emerald-900' => $variant === 'success',
        'border-red-200 bg-red-50 text-red-900' => $variant === 'error',
    ]) }}
>
    {{ $slot }}
</div>
