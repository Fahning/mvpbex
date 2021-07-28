@props(['disabled' => false])

<div class="relative h-10 input-component empty">
    <input
     {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'h-full w-full border-gray-300 px-2 transition-all border-blue rounded-full']) !!}
    />
    <label for="{{ $attributes['id']}}" class="absolute left-2 transition-all bg-white px-1">
        {{ $attributes['label']}}
    </label>
</div>
