<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History of Tasks') }}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-center mb-5 md:hidden">
                        <p class="text-3xl font-bold">History</p>
                    </div>
                    @if(count($histories) == 0)
                        <p class="text-center text-lg text-semibold">You don't have any tasks yet</p>
                    @elseif(count($histories)>=1)
                        <div class="mb-5">
                            @php
                                $i=1;
                            @endphp
                            @foreach($histories as $history)
                                <div class="flex w-full items-center px-2">
                                    <img class="rounded-full w-16" src="{{url($history->destination->image)}}" alt="image">
                                    <div class="ml-3 text-sm text-semibold text-gray-800 text-left">
                                        <p class="font-bold text-base">{{$history->destination->destination_name}}</p>
                                        <p>{{$history->destination->businessCategories->name}}</p>
                                    </div>
                                    <div class="flex items-center ml-auto">
                                        <p class="text-sm text-semibold text-gray-800 text-left w-20 mr-2">{{$history->updated_at}}</p>
                                    </div>
                                </div>
                                @if ($i == count($histories))

                                @else
                                    <div class="border border-black mx-2"></div>
                                @endif
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                        {{$histories->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
