@props(['value'])

<div {{ $attributes->merge(['class' => 'flex text-lg font-semibold rounded-md p-2 mb-3 border-2 border-solid border-green-400 justify-between items-center']) }}>
    {{ $value ?? $slot}}
</div>
