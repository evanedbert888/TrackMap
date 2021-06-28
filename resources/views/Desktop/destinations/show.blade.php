<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->destination_name}}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-40 w-full object-top bg-no-repeat md:h-60" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                    @if($details->image == null)
                        <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{URL::to('/img/company.png')}}">
                    @else
                        <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url('storage/'.$details->image)}}">
                    @endif
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    <a class="float-right mr-2 mt-2 md:mt-0 md:mr-5" href="{{ route('destinations.edit',['destination'=>$details->id]) }}">
                        <x-button type="submit">
                            edit
                        </x-button>
                    </a>
                    <div>
                        <div class="mx-2 mt-16 md:ml-60 md:mx-5 md:mt-0">
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->destination_name }}</h6>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->email }}</h2>
                            </div>
                        </div>
                        <div class="mx-2 mt-16 md:ml-60 md:mx-5 md:mt-0">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
                                <input type="hidden" id="latitude" value="{{$details->latitude}}"/>
                                <input type="hidden" id="longitude" value="{{$details->longitude}}"/>
                                <tr class="align-top">
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ $details->address }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Business</td>
                                    <td>:</td>
                                    <td>{{ $details->businessCategories->name }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Description</td>
                                    <td>:</td>
                                    <td>{{ $details->description }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="flex justify-center mt-3">
                            <div id="viewMap"></div>
                        </div>
                    </div>
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
            "esri/tasks/Locator",
            // "esri/geometry/Circle"

        ], function(esriConfig, Map, MapView, Graphic, GraphicsLayer, Locator) {

            esriConfig.apiKey = "AAPKd14f6a7025a441bca958cfe373e9a0708Me2zOHz9-4bPzujZd2ZZkQ6W4n-UL8AB29QcugYNzzOh82WKuWHo1_Znivm110D";

            function findIDValue(point) {
                let find = document.getElementById(point)
                let value = find.attributes.getNamedItem('value').value;
                return value;
            }

            let lng = findIDValue('longitude');
            let lat = findIDValue('latitude');

            const map = new Map({
                basemap: "osm-standard-relief" //Basemap layer service
            });

            const view = new MapView({
                map: map,
                center: [lng,lat], //Longitude, latitude
                zoom: 18,
                container: "viewMap"
            });

            const graphicsLayer = new GraphicsLayer();
            map.add(graphicsLayer);

            const point = {
                type: "point",
                longitude: lng,
                latitude: lat,
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

            // const circle = new Graphic({
            //     geometry: new Circle({
            //         center: [lng,lat],
            //         radius: 60
            //     }),
            //     symbol: {//circle design
            //         type: "simple-fill"
            //     }
            // })
            // graphicsLayer.add(circle);

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
