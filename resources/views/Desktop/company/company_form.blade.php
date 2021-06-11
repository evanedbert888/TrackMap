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
                                            <x-label for="company_name" :value="__('Company Name')"/>

                                            <x-input id="company_name" class="block mt-1 w-96" type="text"
                                                     name="company_name" :value="old('company_name')" required
                                                     autofocus/>
                                        </div>

                                        <!-- BusinessCategory -->
                                        <div class="my-3 space-y-0">
                                            <x-label for="business" :value="__('Business')"/>

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
                                                <x-label for="address" :value="__('Address')"/>

                                                <x-input class="block mt-1 w-96" type="text"
                                                         name="address" id="address" required
                                                         autofocus/>
                                            </div>
                                            <x-button id="search" type="button" name="search" class="mt-2">search</x-button>
                                        </div>

                                        <!-- Email -->
                                        <div class="my-3 space-y-0">
                                            <x-label for="email" :value="__('Email')" />

                                            <x-input id="email" class="block mt-1 w-96" type="text" name="email" :value="old('email')" required />
                                        </div>

                                        <!-- Coordinate -->
                                        <div class="my-3 space-y-0">
                                            <div>
                                                <x-label for="coordinate" :value="__('Coordinate')"/>

                                                <x-input id="coordinate" class="block mt-1 w-96" type="text" name="coordinate" :value="old('coordinate')" required />
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="my-3 space-y-0">
                                            <x-label for="description" :value="__('Description')"/>

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
        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic",
            "esri/layers/GraphicsLayer"

        ], function(esriConfig, Map, MapView, Graphic, GraphicsLayer) {

            esriConfig.apiKey = "AAPK3b583452b37548898ee56ef34a6ac70c8D9oQpRakOG5ZEnv5UySaM8NXnJNjuC5TScW4rTgoe-Lxp7ANLXwa0btm44QL0oa";

            const map = new Map({
                basemap: "arcgis-topographic" //Basemap layer service
            });

            const view = new MapView({
                map: map,
                center: [109.342506,-0.026330], //Longitude, latitude
                zoom: 14,
                container: "findMap"
            });

            const graphicsLayer = new GraphicsLayer();
            map.add(graphicsLayer);

            var btnSearch = document.querySelector("#search")
            btnSearch.addEventListener("click", () => {
                var address = document.querySelector("#address").value
                console.log(address)
                getCoordinateOfAddress(address)
            })

            function getCoordinateOfAddress(address) {
                fetch('http://127.0.0.1:8000/api/GeoSearch?address=' + address, {
                    method: "get"
                })
                    .then(response => response.json())
                    .then(responseJson => {
                        console.log(responseJson)
                        setCoordinate(responseJson,address)
                    })
                    .catch(error =>{
                        console.log(error)
                    })
            }

            function setCoordinate(coordinate,address) {
                let title=  Math.round(coordinate.x * 100000)/100000 + ", " + Math.round(coordinate.y * 100000)/100000
                document.querySelector("#coordinate").value = title
                const point = {
                    type: "point",
                    longitude: coordinate.x,
                    latitude: coordinate.y
                }
                placeMarker(point,address,title)
            }

            let symbol = {
                type: "picture-marker",
                url: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrW1r1C8ccnzU0P5cbXV2JKHu-cqkDK-V_jA&usqp=CAU",
                height: "20px",
                width: "20px"
            }

            function placeMarker(point,address,title) {
                console.log(point)
                const popupTemplate = {
                    title: "{Name}",
                    content: "{Description}"
                }
                const attributes = {
                    Name: title,
                    Description: address
                }

                const pointGraphic = new Graphic({
                    geometry: point,
                    symbol: symbol,
                    attributes: attributes,
                    popupTemplate: popupTemplate
                });
                graphicsLayer.add(pointGraphic);

                view.popup.open({
                    title:  title,
                    content: address,
                    location: point
                });
            }
        });
    </script>
</x-app-layout>
