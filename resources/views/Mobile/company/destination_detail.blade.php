<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->company_name}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                    <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="http://localhost/Project/TrackMap/resources/views/components/img/jasa_pembuatan_desain_logo_perusahaan_murah_tidak_murahan_1157447_1429123045.jpg">
                </div>
                <div class="p-6 bg-white border-b border-gray-200 ">
                    @if($count == 0)

                    @elseif($count == 1)
                        <form action="{{route('task_patch')}}" method="POST">
                            @method('PATCH')
                            @csrf
                            <x-editinput type="hidden" name="id" id="id" value="{{$details->id}}"/>
                            <x-editinput type="hidden" name="latitude" id="latitude" value=""/>
                            <x-editinput type="hidden" name="longitude" id="longitude" value=""/>
                            <div class="float-right mr-5">
                                <x-button type="submit">
                                    Check-In
                                </x-button>
                            </div>
                        </form>
                    @endif
                    <div>
                        <div class="ml-60 mx-5 mt-6">
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->company_name }}</h6>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->email }}</h2>
                            </div>
                            <div class="text-sm">
{{--                                <h2>Last Check-In : {{ $details->goals->employee->goals->created_at }}</h2>--}}
                            </div>
                        </div>
                        <div class="mx-5 mt-3">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
                                <tr>
                                    <td>Address</td>
                                    <td>{{ __(": ").$details->address }}</td>
                                </tr>
                                <tr>
                                    <td>Business</td>
                                    <td>{{ __(": ").$details->business->name }}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{{ __(": ").$details->description }}</td>
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

<script>
    function getCoordinate() {
        navigator.geolocation.getCurrentPosition(getCoordinateSuccess)
    }

    function getCoordinateSuccess(geoLocationPosition) {
        console.log(geoLocationPosition)
        setCoordinateToFormField(geoLocationPosition.coords)
    }

    function setCoordinateToFormField(coordinate) {
        document.querySelector('#latitude').setAttribute('value',coordinate.latitude)
        document.querySelector('#longitude').setAttribute('value',coordinate.longitude)
    }

    function onload() {
        getCoordinate()
    }

    onload()

</script>
