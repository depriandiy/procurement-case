@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'hint' => null,
    'required' => false,
])

@php($inputId = $attributes->get('id', $name))

<div>
    <label for="{{ $inputId }}" class="mb-2 block text-sm font-medium text-slate-800">
        {{ $label }}
        @if ($required)
            <span class="text-red-600" aria-hidden="true">*</span>
        @endif
    </label>

    <input
        id="{{ $inputId }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @required($required)
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $inputId }}-error" @elseif ($hint) aria-describedby="{{ $inputId }}-hint" @endif
        {{ $attributes->except('id')->class([
            'block min-h-11 w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-950 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-brand-600 focus:ring-2 focus:ring-brand-100',
            'border-red-400' => $errors->has($name),
            'border-slate-300' => ! $errors->has($name),
        ]) }}
    >

    @error($name)
        <p id="{{ $inputId }}-error" class="mt-1.5 text-sm text-red-700">{{ $message }}</p>
    @elseif ($hint)
        <p id="{{ $inputId }}-hint" class="mt-1.5 text-sm text-slate-500">{{ $hint }}</p>
    @enderror
</div>
