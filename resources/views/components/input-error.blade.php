@props(['name'])

@error($name)
    <span {{ $attributes->merge(['class' => 'text-sm text-red-500 mt-1']) }}>{{ $message }}</span>
@enderror
