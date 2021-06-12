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
                    @if($details->image == '/img/company.png')
                        <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{URL::to($details->image)}}">
                    @else
                        <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url('storage/'.$details->image)}}">
                    @endif
                </div>
                <div class="p-6 pt-1 bg-white border-b border-gray-200 ">
                    <form method="POST" action="{{ route('company_patch',['id'=>$details->id]) }}"  enctype="multipart/form-data">
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
                                    <x-editinput name="company_name" id="company_name" class="font-bold text-2xl" type="text" value="{{ $details->company_name }}"/>
                                </div>
                                <div class="text-sm mt-1">
                                    <select class="rounded-lg" name="business" id="business">
                                        @foreach($businesses as $business)
                                            <option value={{$business->id}} {{ $business->id == $details->business_id ? 'selected' : '' }}> {{$business->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-sm mt-1">
                                    <x-editinput id="image" name="image" type="file"/>
                                </div>
                            </div>
                            <div class="mx-5 mt-3">
                                <p class="font-bold text-xl">Detail</p>
                                <hr class="border border-5 border-black border-solid">
                                <table class="mt-3">
                                    <tr>
                                        <td>Address</td>
                                        <td>:</td>
                                        <td><x-editinput name="address" id="address" type="text" value="{{ $details->address }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>email</td>
                                        <td>:</td>
                                        <td><x-editinput name="email" id="email" type="text" value="{{ $details->email }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Coordinate</td>
                                        <td>:</td>
                                        <td><x-editinput name="coordinate" id="coordinate" type="text" value="{{ $details->latitude }},{{ $details->longitude }}"/></td>
                                        <span class="hidden" id="latitude" value="{{$details->latitude}}"></span>
                                        <span class="hidden" id="longitude" value="{{$details->longitude}}"></span>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>:</td>
                                        <td><x-editinput name="description" id="description" type="text" value="{{ $details->description }}"/></td>
                                    </tr>
                                </table>
                            </div>
                            <span class="flex justify-center mt-3">
                                <div id="viewMap"></div>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic",
            "esri/layers/GraphicsLayer",
            "esri/tasks/Locator"

        ], function(esriConfig, Map, MapView, Graphic, GraphicsLayer, Locator) {

            esriConfig.apiKey = "AAPKd14f6a7025a441bca958cfe373e9a0708Me2zOHz9-4bPzujZd2ZZkQ6W4n-UL8AB29QcugYNzzOh82WKuWHo1_Znivm110D";

            const map = new Map({
                basemap: "osm-standard-relief" //Basemap layer service
            });

            const view = new MapView({
                map: map,
                center: [109.342506,-0.026330], //Longitude, latitude
                zoom: 12,
                container: "viewMap"
            });

            const graphicsLayer = new GraphicsLayer();
            map.add(graphicsLayer);

            function findIDValue(point) {
                let find = document.getElementById(point)
                let value = find.attributes.getNamedItem('value').value;
                return value;
            }

            const point = {
                type: "point",
                longitude: findIDValue('longitude'),
                latitude: findIDValue('latitude'),
            };

            const pictureMarkerSymbol = {
                type: "picture-marker",
                url: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgAqzIE8fVWHiYVlAaMleG3Qw3OtuAP0IeTA&usqp=CAU",
                height: "25px",
                width: "25px"
            };

            const pointGraphic = new Graphic({
                geometry: point,
                symbol: pictureMarkerSymbol
            });
            graphicsLayer.add(pointGraphic);

            const locatorTask = new Locator ({
                url: "http://geocode-api.arcgis.com/arcgis/rest/services/World/GeocodeServer"
            })

            view.on("click", function(evt){
                const params = {
                    location: evt.mapPoint
                };

                locatorTask.locationToAddress(params)
                    .then(function(response) { // Show the address found
                        const address = response.address;
                        showAddress(address, evt.mapPoint);
                    }, function(err) { // Show no address found
                        showAddress("No address found.", evt.mapPoint);
                    });
            });

            function showAddress(address, pt) {
                view.popup.open({
                    title:  + Math.round(pt.longitude * 100000)/100000 + ", " + Math.round(pt.latitude * 100000)/100000,
                    content: address,
                    location: pt
                });
            }
        });
    </script>
</x-app-layout>
