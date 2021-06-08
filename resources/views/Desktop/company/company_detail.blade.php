<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->company_name}}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-40 w-full object-top bg-no-repeat md:h-60" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                    <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{ URL::to('/img/jasa_pembuatan_desain_logo_perusahaan_murah_tidak_murahan_1157447_1429123045.jpg') }}">
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    <a class="float-right mr-2 mt-2 md:mt-0 md:mr-5" href="{{ route('edit_company',['id'=>$details->id]) }}">
                        <x-button type="submit">
                            edit
                        </x-button>
                    </a>
                    <div>
                        <div class="mx-2 mt-16 md:ml-60 md:mx-5 md:mt-0">
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->company_name }}</h6>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->email }}</h2>
                            </div>
                        </div>
                        <div class="mx-2 mt-16 md:ml-60 md:mx-5 md:mt-0">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
                                <span class="hidden" id="latitude" value="{{$details->latitude}}"></span>
                                <span class="hidden" id="longitude" value="{{$details->longitude}}"></span>
                                <tr class="align-top">
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ $details->address }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Business</td>
                                    <td>:</td>
                                    <td>{{ $details->business->name }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Description</td>
                                    <td>:</td>
                                    <td>{{ $details->description }}</td>
                                </tr>
                            </table>
                        </div>
                        <span class="flex container justify-center mt-3">
                            <div>
                                <iframe id="map"></iframe>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAe7I-2_FRkLUXrR8rCOqVdVRWQ5B9mMMk&callback=initMap">
    </script>
    <script src="{{asset("js/showMap.js")}}">

    </script>
</x-app-layout>
