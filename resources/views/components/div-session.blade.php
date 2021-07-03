@props(['value'])

<div {{ $attributes->merge(['class' => 'text-lg font-semibold rounded-md p-2 mb-3']) }}>
    {{ $value ?? $slot}}
</div>
