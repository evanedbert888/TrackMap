@props(['value'])

<div {{ $attributes->merge(['class' => 'text-lg font-semibold rounded-md p-2 mb-3 border-2 border-solid border-green-400']) }}>
    {{ $value ?? $slot}}
</div>
