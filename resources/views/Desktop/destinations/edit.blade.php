<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->destination_name}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url($details->image)}}">
                </div>
                <div class="p-6 pt-1 bg-white border-b border-gray-200 ">
                    @can('update destination')
                        <form method="POST" action="{{ route('destinations.update',['destination'=>$details->id]) }}"  enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="float-right mr-5">
                                <x-savebutton type="button" onclick="showModal()" class="mt-5">
                                    update
                                </x-savebutton>
                            </div>
                            <div>
                                <div class="ml-60 mx-5">
                                    <div>
                                        <x-editinput name="destination_name" id="destination_name" class="font-bold text-2xl" type="text" value="{{ $details->destination_name }}"></x-editinput>
                                    </div>
                                    <div class="text-sm mt-1">
                                        <select class="rounded-lg" name="business" id="business">
                                            @foreach($businesses as $business)
                                                <option value={{$business->id}} {{ $business->id == $details->business_id ? 'selected' : '' }}> {{$business->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-sm mt-1">
                                        <x-editinput id="image" name="image" type="file"></x-editinput>
                                    </div>
                                </div>
                                <div class="mx-5 mt-5">
                                    <p class="font-bold text-xl">Detail</p>
                                    <hr class="border border-5 border-black border-solid">
                                    <table class="mt-3">
                                        <tr>
                                            <td>Address</td>
                                            <td>:</td>
                                            <td>
                                                <x-editinput name="address" id="address" type="text" value="{{ $details->address }}"></x-editinput>
                                                <x-button id="search" type="button" name="search" class="mt-2">search</x-button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>email</td>
                                            <td>:</td>
                                            <td>
                                                <x-editinput name="email" id="email" type="text" value="{{ $details->email }}"></x-editinput>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Coordinate</td>
                                            <td>:</td>
                                            <td>
                                                <x-editinput name="coordinate" id="coordinate" type="text" value="{{ $details->latitude }},{{ $details->longitude }}"></x-editinput>
                                            </td>
                                            <x-input class="hidden" id="latitude" value="{{$details->latitude}}"></x-input>
                                            <x-input class="hidden" id="longitude" value="{{$details->longitude}}"></x-input>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>:</td>
                                            <td>
                                                <x-editinput name="description" id="description" type="text" value="{{ $details->description }}"></x-editinput>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="flex justify-center mt-3">
                                    <div id="viewMap"></div>
                                </div>

                                <div class="fixed z-10 inset-0 overflow-y-auto invisible opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hiddenModal()"></div>

                                        <!-- This element is to trick the browser into centering the modal contents. -->
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                                <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                                                                    Do you want to update this destination detail ?
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-400 text-base font-medium text-black hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Yes
                                                        </button>
                                                        <button type="button" onclick="hiddenModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                            No
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endcan
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
                basemap: "osm-standard-relief" //Basemap layer service
            });

            const view = new MapView({
                map: map,
                center: [113.921326, -0.789275], //Longitude, latitude
                zoom: 5,
                container: "viewMap"
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

        function showModal() {
            document.getElementById('modal').classList.remove('invisible');
            document.getElementById('modal').classList.remove('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal').style.transitionTimingFunction = "ease-out";
            document.getElementById('modal').style.transitionDuration = "300ms";
            document.getElementById('modal').classList.add('opacity-100','translate-y-0','sm:scale-100');
        }
        function hiddenModal() {
            document.getElementById('modal').classList.remove('opacity-100','translate-y-0','sm:scale-100');
            document.getElementById('modal').style.transitionTimingFunction = "ease-in";
            document.getElementById('modal').style.transitionDuration = "200ms";
            document.getElementById('modal').classList.add('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal').classList.add('invisible');
        }
    </script>
</x-app-layout>
