<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task History') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="text-center pb-4 font-semibold text-lg">
                            <p> History of Tasks </p>
                        </div>
                        @foreach($histories as $history)
                            <div class="p-5 bg-green-300 border border-white-200 mb-5 sm:rounded-lg">
                                <ul>
                                    <li class="flex">
                                        <img class="inline-block h-20 w-20 rounded-full ring-2 ring white" src="http://localhost/Project/TrackMap/resources/views/components/img/jasa_pembuatan_desain_logo_perusahaan_murah_tidak_murahan_1157447_1429123045.jpg">
                                        <div class="w-full ml-5 mt-3">
                                            <div>
                                                <h6 class="font-bold text-2xl">{{ $history->company->company_name }}</h6>
                                            </div>
                                            <div class="text-sm">
                                                <h2>{{ $history->company->business->name }}</h2>
                                            </div>
                                            <div class="text-sm">
                                                <h2>{{ $history->company->address }}</h2>
                                            </div>
                                        </div>
                                        <div class="mt-6 ml-5">
                                            <p class="font-semibold text-lg">{{$history->updated_at}}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                        {{$histories->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

