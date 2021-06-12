<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Destination
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-5 bg-white border-b border-gray-200">
                    <table class="w-full">
                        <tr>
                            <td>
                                <span class="flex container justify-end">
                                    <form action="{{route('add_company')}}" method="POST">
                                    @csrf
                                    <!-- Company Name -->
                                        <div class="my-3 space-y-0">
                                            <x-label for="company_name" :value="__('Company Name')"></x-label>

                                            <x-input id="company_name" class="block mt-1 w-96" type="text"
                                                     name="company_name" :value="old('company_name')" required
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
                                                         name="address" id="address" placeholder="min 100 characters" required
                                                         autofocus></x-input>
                                            </div>
                                            <x-button id="search" type="button" name="search" class="mt-2">search</x-button>
                                        </div>

                                        <!-- Email -->
                                        <div class="my-3 space-y-0">
                                            <x-label for="email" :value="__('Email')"></x-label>

                                            <x-input id="email" class="block mt-1 w-96" type="text" name="email" :value="old('email')" required></x-input>
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
                            </td>
                            <td>
                                <span class="flex container justify-center">
                                    <div id="findMap">
                                    </div>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Library
        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",

            "esri/Graphic",
            "esri/layers/GraphicsLayer",
            "esri/tasks/Locator",
            "esri/symbols/PictureMarkerSymbol"

        ], function(esriConfig, Map, MapView, Graphic, GraphicsLayer, LocatorTask) {

            // API Key
            esriConfig.apiKey = "AAPK3b583452b37548898ee56ef34a6ac70c8D9oQpRakOG5ZEnv5UySaM8NXnJNjuC5TScW4rTgoe-Lxp7ANLXwa0btm44QL0oa";

            // Basemap
            const map = new Map({
                basemap: "osm-standard-relief"
            });

            // Url
            let geocode = "http://geocode-api.arcgis.com/arcgis/rest/services/World/GeocodeServer";

            // Define the map
            const view = new MapView({
                map: map,
                center: [109.342506,-0.026330], //Longitude, latitude
                zoom: 14,
                container: "findMap"
            });

            // Add graphics layer to the map
            const graphicsLayer = new GraphicsLayer();
            map.add(graphicsLayer);

            view.popup.actions = [];

            const locatorTask = new LocatorTask ({
                url: geocode
            })

            view.when(()=>{
                // Search address event
                var btnSearch = document.querySelector("#search")
                btnSearch.addEventListener("click", () => {
                    const params = {
                        address: {
                            "address": document.querySelector("#address").value
                        }
                    }
                    console.log(params.address)
                    locatorTask.addressToLocations(params).then((results) => {
                        showResult(results);
                    });
                })

                // The symbol of marker
                let symbol = {
                    type: "picture-marker",
                    url: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrW1r1C8ccnzU0P5cbXV2JKHu-cqkDK-V_jA&usqp=CAU",
                    height: "25px",
                    width: "25px"
                }

                function showResult(results) {
                    if (results.length) {
                        const result = results[0];
                        console.log(results)
                        let coordinate = Math.round(result.location.longitude * 100000)/100000 + "," + Math.round(result.location.latitude * 100000)/100000
                        document.querySelector("#coordinate").value = coordinate;

                        const pointGraphic = new Graphic({
                            geometry: result.location,
                            symbol: symbol,
                            attributes: {
                                title: "Address",
                                address: result.address,
                                score: result.score
                            },
                            popupTemplate: {
                                title: "{title}",
                                content: "{address}" + "<br><br>" + coordinate
                            }
                        })
                        graphicsLayer.add(pointGraphic);
                    }
                }
            });

            view.on("click", function(evt){
                const params = {
                    location: evt.mapPoint
                };

                locatorTask.locationToAddress(params)
                    .then(function(response) { // Show the address found
                        const address = response.address;
                        console.log("response : " + response);
                        console.log("address : " +address);
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
