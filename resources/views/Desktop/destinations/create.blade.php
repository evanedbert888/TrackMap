<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Destination
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-5 bg-white my-5 md:flex">
                    <div class="w-full flex items-center justify-center md:w-1/3">
                        @can('store destination')
                            <span class="w-full flex container justify-center">
                                <form action="{{route('destinations.store')}}" method="POST">
                                @csrf
                                <!-- destinations Name -->
                                    <div class="my-3 space-y-0">
                                        <x-label for="_name" :value="__('Destination Name')"></x-label>

                                        <x-input id="destination_name" class="block mt-1 w-96" type="text"
                                                name="destination_name" :value="old('destination_name')" placeholder="Enter the destination name" required
                                                autofocus></x-input>
                                    </div>

                                    <!-- BusinessCategory -->
                                    <div class="my-3 space-y-0">
                                        <x-label for="business" :value="__('Business')"></x-label>

                                        <select name="business" id="business" class="block mt-1 w-96 rounded-md">
                                            <option class="hidden"></option>
                                            @foreach($businesses as $business)
                                                <option class="bg-gray-200 hover:bg-gray-400" value="{{$business->id}}">{{$business->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Address -->
                                    <div class="my-3">
                                        <div class="space-y-0">
                                            <x-label for="address" :value="__('Address')"></x-label>

                                            <x-input class="block mt-1 w-96" type="text"
                                                    name="address" id="address" placeholder="min 100 characters" placeholder="Street name, City, Country" required
                                                    autofocus></x-input>
                                        </div>
                                        <x-button id="search" type="button" name="search" class="mt-2">search</x-button>
                                    </div>

                                    <!-- Email -->
                                    <div class="my-3 space-y-0">
                                        <x-label for="email" :value="__('Email')"></x-label>

                                        <x-input id="email" class="block mt-1 w-96" type="text" name="email" :value="old('email')" placeholder="Enter the email" required></x-input>
                                    </div>

                                    <!-- Coordinate -->
                                    <div class="my-3 space-y-0">
                                        <div>
                                            <x-label for="coordinate" :value="__('Coordinate')"></x-label>

                                            <x-input id="coordinate" class="block mt-1 w-96" type="text" name="coordinate" :value="old('coordinate')" required></x-input>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="my-3 space-y-0">
                                        <x-label for="description" :value="__('Description')"></x-label>

                                        <textarea class="block mt-1 rounded-md " name="description" id="description"
                                                cols="40" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3 mt-0 float-right">
                                    <x-button>
                                            {{ __('Submit') }}
                                        </x-button>
                                    </div>
                                </form>
                            </span>
                        @endcan
                    </div>
                    <div class="w-full flex items-center justify-center md:w-2/3">
                        <span class="flex container justify-center">
                            <div id="findMap"></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script !src="">
        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",

            "esri/Graphic",
            "esri/layers/GraphicsLayer",
            "esri/tasks/Locator"

        ], function(esriConfig,Map, MapView, Graphic, GraphicsLayer, Locator) {

            esriConfig.apiKey = "AAPKd14f6a7025a441bca958cfe373e9a0708Me2zOHz9-4bPzujZd2ZZkQ6W4n-UL8AB29QcugYNzzOh82WKuWHo1_Znivm110D";

            const map = new Map({
                basemap: "streets-navigation-vector" //Basemap layer service
            });

            const view = new MapView({
                map: map,
                center: [113.921326, -0.789275], //Longitude, latitude
                zoom: 5,
                container: "findMap"
            });

            const graphicsLayer = new GraphicsLayer();
            map.add(graphicsLayer);

            const locatorTask = new Locator ({
                url: "http://geocode-api.arcgis.com/arcgis/rest/services/World/GeocodeServer"
            })

            function coordinateFormat(input) {
                return input.toFixed(5);
            }

            function enterCoordinateValue(lng,lat) {
                document.querySelector("#coordinate").value = lng + ',' + lat
            }

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
                let lng = coordinateFormat(pt.longitude);
                let lat = coordinateFormat(pt.latitude);
                enterCoordinateValue(lng,lat);
                view.graphics.removeAll();

                view.graphics.add(new Graphic({
                    symbol: {
                        type: "picture-marker",
                        url: "https://cdn.iconscout.com/icon/premium/png-256-thumb/place-marker-3-599570.png",
                        height: "30px",
                        width: "30px"
                    },
                    geometry: pt,
                }));

                view.popup.open({
                    title:  lng + ", " + lat,
                    content: address,
                    location: pt
                });

                console.log(pt)
            }

            var btnSearch = document.querySelector("#search")
            btnSearch.addEventListener("click", () => {
                var address = document.querySelector("#address").value
                console.log(address)
                view.graphics.removeAll();

                const params = {
                    address: {
                        "address": address
                    }
                }

                locatorTask.addressToLocations(params).then((results) => {
                    showResult(results);
                });
            })

            function showResult(results) {
                if (results.length) {
                    const result = results[0];
                    let lng = coordinateFormat(result.location.longitude);
                    let lat = coordinateFormat(result.location.latitude);
                    enterCoordinateValue(lng,lat);

                    view.graphics.add(new Graphic({
                            symbol: {
                                type: "picture-marker",
                                url: "https://cdn.iconscout.com/icon/premium/png-256-thumb/place-marker-3-599570.png",
                                height: "30px",
                                width: "30px"
                            },
                            geometry: result.location,
                            attributes: {
                                title: "Address",
                                address: result.address,
                                score: result.score
                            },
                            popupTemplate: {
                                title: "{title}",
                                content: "{address}" + "<br><br>" + lng + "," + lat
                            }
                        }
                    ));

                    view.goTo({
                        target: result.location,
                        zoom: 16
                    });
                }
            }
        });
    </script>
</x-app-layout>
