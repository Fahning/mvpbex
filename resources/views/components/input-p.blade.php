@props(['disabled' => false])

<div class="relative h-10 input-component">
    <input
     {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'h-full w-full border-gray-300 px-2 transition-all border-blue']) !!}
    />
    <label for="{{ $attributes['id']}}" class="absolute left-2 transition-all bg-white px-1 text-blue-500">
        {{ $attributes['label']}}
    </label>
</div>
