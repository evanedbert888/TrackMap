<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company List') }}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-center mb-5">
                        <p class="text-3xl font-bold">History</p>
                    </div>
                    @if(count($histories) == 0)
                        <p class="text-center text-lg text-semibold">You don't have any tasks done</p>
                    @elseif(count($histories)>=1)
                        <div class="mb-5">
                            @php
                                $i=1;
                            @endphp
                            @foreach($histories as $history)
                                <div class="flex w-full items-center px-2">
                                    <img class="rounded-full w-16" src="https://cdn.iconscout.com/icon/free/png-256/people-1659484-1410006.png" alt="image">
                                    <div class="ml-3 text-sm text-semibold text-gray-800 text-left">
                                        <p class="font-bold text-base">{{$history->company->company_name}}</p>
                                        <p>{{$history->company->business->name}}</p>
                                    </div>
                                    <div class="flex items-center ml-auto">
                                        <p class="text-sm text-semibold text-gray-800 text-left w-20 mr-2">{{$history->updated_at}}</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                        </svg>
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
