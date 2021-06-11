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
                    @if($details->image == '/img/marker_pin.png')
                        <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{URL::to($details->image)}}">
                    @else
                        <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url('storage/'.$details->image)}}">
                    @endif
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    @if($count == 0)

                    @elseif($count == 1)
                        <form action="{{route('task_patch')}}" method="POST">
                            @method('PATCH')
                            @csrf
                            <x-editinput type="hidden" name="id" id="id" value="{{$details->id}}"/>
                            <x-editinput type="hidden" name="latitude" id="latitude" value="{{$details->latitude}}"/>
                            <x-editinput type="hidden" name="longitude" id="longitude" value="{{$details->longitude}}"/>
                            <div class="float-right mr-2 mt-2 md:mt-0 md:mr-5">
                                <x-button type="submit">
                                    Check-In
                                </x-button>
                            </div>
                        </form>
                    @endif
                    <div>
                        <div class="mx-2 mt-16 md:ml-60 md:mx-5 md:mt-0">
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
                        <div class="mx-2 mt-3 md:mt-8 md:mx-5">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
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
                        <div class="mx-2 mt-5 bg-blue-400 h-96 flex flex-wrap content-center md:mx-5">
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
