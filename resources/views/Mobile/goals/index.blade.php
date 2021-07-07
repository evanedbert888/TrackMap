<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of Task') }}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <x-div-session class="bg-green-200">{{session('success')}}</x-div-session>
                    @endif

                    <div class="flex justify-center mb-5 md:hidden">
                        <p class="text-3xl font-bold">Tasks</p>
                    </div>
                    @if(count($goals) == 0)
                        <p class="text-center text-lg text-semibold">You don't have any available tasks</p>
                    @endif
                        <div class="mb-5">
                            @php
                                $i=1;
                            @endphp
                            @foreach($goals as $goal)
                                <div class="flex w-full items-center px-2">
                                    <img class="rounded-full w-16" src="{{url($goal->destination->image)}}" alt="image">
                                    <div class="ml-3 text-sm text-semibold text-gray-800 text-left">
                                        <p class="font-bold text-lg">{{$goal->destination->destination_name}}</p>
                                        <p>{{$goal->destination->businessCategories->name}}</p>
                                    </div>
                                    <div class="flex items-center ml-auto">
                                        @can('mobile show destination')
                                            <a href="{{route('mobile.destinations.show',['destination'=>$goal->destination->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                                @if ($i == count($goals))

                                @else
                                    <div class="border border-black mx-2"></div>
                                @endif
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                        {{$goals->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
