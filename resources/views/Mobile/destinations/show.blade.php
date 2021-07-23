<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->destination_name}}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-40 w-full object-top bg-no-repeat flex md:h-60" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                    <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 mx-auto md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url($details->image)}}">
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    <div class="mx-2 md:mx-0">
                        <div class="mt-16 md:ml-60 md:mt-0">
                            @if($count == 0)

                            @elseif($count >= 1)
                                @can('mobile update goal')
                                    <form method="POST" id="formUpdate">
                                        @csrf
                                        <x-editinput type="hidden" name="id" id="id" value="{{$details->id}}"></x-editinput>
                                        <x-editinput type="hidden" name="name" id="name" value="{{$details->destination_name}}"></x-editinput>
                                        <x-editinput type="hidden" name="latitude" id="latitude" value=""></x-editinput>
                                        <x-editinput type="hidden" name="longitude" id="longitude" value=""></x-editinput>
                                        <div class="float-right mr-2 mt-2 md:mt-0 md:mr-5">
                                            <x-button id="checkin" type="button" onclick="checkIn()">
                                                Check-In
                                            </x-button>
                                        </div>
                                    </form>
                                @endcan
                            @endif
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->destination_name }}</h6>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->email }}</h2>
                            </div>

                        </div>
                        <div class="mt-3 md:mt-8">
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
                                    <td>{{ $details->businessCategories->name }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Description</td>
                                    <td>:</td>
                                    <td>{{ $details->description }}</td>
                                </tr>
                            </table>
                            <x-editinput type="hidden" name="lat" id="lat" value="{{$details->latitude}}"></x-editinput>
                            <x-editinput type="hidden" name="lng" id="lng" value="{{$details->longitude}}"></x-editinput>
                        </div>
                        <div class="flex justify-center mt-3">
                            <div id="mobileMap"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed z-10 inset-0 overflow-y-auto invisible opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hiddenModal()"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                            <div class="flex">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="text-lg leading-6 font-medium font-bold text-gray-900 mt-0.5 ml-3" id="modal-title">
                                    Error
                                </h3>
                            </div>
                            <p class="mt-3">
                                You're Outside From Area
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    var checked;

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

    $(document).ready(function() {
        checkLocation();
    })

    function checkIn() {
        if (checked == 'out') {
            showModal();
        }
        else if (checked == 'in') {
            let formData = $('#formUpdate').serialize()
            console.log(formData)
            $.ajax({
                 url: "{{ route('goals.update') }}",
                 method: "PATCH",
                 data: formData,
                 success: function (data) {
                     console.log(data);
                     location.href = "{{route('goals.index')}}"
                 },
                 error: function (error) {
                     console.log(error);
                 }
             })
        }
    }

    function checkLocation() {
        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic",
            "esri/layers/GraphicsLayer",
            "esri/geometry/Circle",
            "esri/geometry/Point",
            "esri/geometry/support/geodesicUtils",

        ], function(esriConfig, Map, MapView, Graphic, GraphicsLayer, Circle, Point, geodesicUtils) {

            // the API key
            esriConfig.apiKey = "AAPKd14f6a7025a441bca958cfe373e9a0708Me2zOHz9-4bPzujZd2ZZkQ6W4n-UL8AB29QcugYNzzOh82WKuWHo1_Znivm110D";

            // find the value of input through ID
            function findIDValue(point) {
                let find = document.getElementById(point)
                return find.attributes.getNamedItem('value').value;
            }

            // find long lat value
            let circle_lng = findIDValue('lng');
            let circle_lat = findIDValue('lat');

            // define the basemap used
            const map = new Map({
                basemap: "osm-standard-relief" //Basemap layer service
            });

            // display the map within the html
            const view = new MapView({
                map: map,
                center: [circle_lng,circle_lat], //Longitude, latitude
                zoom: 17,
                container: "mobileMap"
            });

            const graphicsLayer = new GraphicsLayer();
            map.add(graphicsLayer);

            // function to define the point in the map
            function makePoint(long,lat,url,size) {
                const pointGraphic = new Graphic({
                    geometry: {
                        type: "point",
                        longitude: long,
                        latitude: lat,
                    },
                    symbol: {
                        type: "picture-marker",
                        url: url,
                        height: "25px",
                        width: "25px"
                    }
                });

                graphicsLayer.add(pointGraphic);
            }

            // define the point of destination in the map
            makePoint(
                circle_lng,
                circle_lat,
                "https://cdn.iconscout.com/icon/premium/png-256-thumb/place-marker-3-599570.png"
            )

            // the radius of circle
            const THRESHOLD_DISTANCE = 30;

            // defining the circle in the map
            let circlePoint = new Graphic({
                geometry: new Circle({
                    center: [circle_lng,circle_lat],
                    radius: THRESHOLD_DISTANCE,
                    radiusUnit: "meters"
                }),
                symbol: {//circle design
                    type: "simple-fill"
                }
            })
            graphicsLayer.graphics.add(circlePoint);

            // get current coordinate based on employee's position
            function getCoordinate() {
                navigator.geolocation.getCurrentPosition(getCoordinateSuccess)
            }

            function getCoordinateSuccess(geoLocationPosition) {
                console.log(geoLocationPosition)
                setCoordinateToFormField(geoLocationPosition.coords)
            }

            // set the coordinate found into the inputs, makePoint and distance calculation
            function setCoordinateToFormField(coordinate) {
                let curr_long = coordinate.longitude;
                let curr_lat = coordinate.latitude;
                document.querySelector('#latitude').setAttribute('value',curr_lat)
                document.querySelector('#longitude').setAttribute('value',curr_long)
                calculateDistanceBetweenTwoPoints(circle_lng,circle_lat,curr_long,curr_lat)

                makePoint(
                    curr_long,
                    curr_lat,
                    "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpr6iZeWv6bhUuTJ5Iq7UYQ30WxkpHd_ucEjKutEUMpAQvHCaFqWG5dArKfqhIipkpk3k&usqp=CAU"
                )
            }

            // calculate distance between two points
            function calculateDistanceBetweenTwoPoints(circle_lng,circle_lat,curr_long,curr_lat) {
                const pt1 = new Point({ x: circle_lng, y: circle_lat });
                const pt2 = new Point({ x: curr_long, y: curr_lat});

                const result = geodesicUtils.geodesicDistance(
                    pt1,
                    pt2,
                    "meters"
                );

                console.log(result.distance);

                if (result.distance > THRESHOLD_DISTANCE) {
                    console.log("Outside the point");
                    checked = 'out';
                } else {
                    console.log("Inside the point");
                    checked = 'in';
                }
            }

            // get the coordinate
            function onload() {
                getCoordinate()
            }

            // automatically run the script to find employee's current position
            onload()
        });
    }
</script>
