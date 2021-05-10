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
                <div class="p-6 pt-1 bg-white border-b border-gray-200 ">
                    <form method="Post" action="{{ route('company_patch',['id'=>$details[0]->id]) }}">
                        @method('PATCH')
                        @csrf
                        <div class="float-right mr-5">
                            <x-savebutton type="submit" class="mt-5">
                                update
                            </x-savebutton>
                        </div>
                        <div>
                            <div class="ml-60 mx-5">
                                <div>
                                    <x-editinput id="name" class="font-bold text-2xl" type="text" value="{{ $details[0]->company_name }}"/>
                                </div>
                                <div class="text-sm mt-1">
                                    <x-editinput id="business" type="text" value="{{ $details[0]->business }}"/>
                                </div>
                            </div>
                            <div class="mx-5 mt-3">
                                <p class="font-bold text-xl">Detail</p>
                                <hr class="border border-5 border-black border-solid">
                                <table class="mt-3">
                                    <tr>
                                        <td>Address</td>
                                        <td>:</td>
                                        <td><x-editinput id="address" type="text" value="{{ $details[0]->address }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>email</td>
                                        <td>:</td>
                                        <td><x-editinput id="email" type="text" value="{{ $details[0]->email }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Coordinate</td>
                                        <td>:</td>
                                        <td><x-editinput id="coordinate" type="text" value="{{ $details[0]->latitude }},{{ $details[0]->longitude }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>:</td>
                                        <td><x-editinput id="description" type="text" value="{{ $details[0]->description }}"/></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mx-5 mt-5 bg-blue-400 h-96 flex flex-wrap content-center">
                                <div class="w-full">
                                    <p class="text-center">SHOW MAP</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
