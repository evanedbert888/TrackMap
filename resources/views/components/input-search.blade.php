@props(['disabled' => false])

<div>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
            <span class="text-black sm:text-sm">
                <img width="20px" height="20px" src="{{ URL::to('/img/search.png') }}">
            </span>
        </div>
        <input type="text" placeholder="Search" autocomplete="off" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>'focus:border-b-4 focus:border-indigo-300 focus:ring-0 w-full pl-7 sm:text-sm border-black border-b-2 border-r-0 border-l-0 border-t-0']) !!}>
    </div>
</div>