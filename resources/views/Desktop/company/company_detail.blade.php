<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details[0]->company_name}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                    <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="http://localhost/Project/TrackMap/resources/views/components/img/jasa_pembuatan_desain_logo_perusahaan_murah_tidak_murahan_1157447_1429123045.jpg">
                </div>
                <div class="p-6 bg-white border-b border-gray-200 ">
                    <a class="float-right mr-5" href="{{ route('edit_company',['id'=>$details[0]->id]) }}">
                        <x-button type="submit">
                            edit
                        </x-button>
                    </a>
                    <div>
                        <div class="ml-60 mx-5 mt-6">
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details[0]->company_name }}</h6>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details[0]->email }}</h2>
                            </div>
                        </div>
                        <div class="mx-5 mt-3">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
                                <tr>
                                    <td>Address</td>
                                    <td>{{ __(": ").$details[0]->address }}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{{ __(": ").$details[0]->description }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="mx-5 mt-5 bg-blue-400 h-96 flex flex-wrap content-center">
                            <div class="w-full">
                                <p class="text-center">SHOW MAP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
