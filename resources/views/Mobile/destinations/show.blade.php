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

                            @elseif($count == 1)
                                @can('mobile update goal')
                                    <form action="{{route('goals.update')}}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <x-editinput type="hidden" name="id" id="id" value="{{$details->id}}"></x-editinput>
                                        <x-editinput type="hidden" name="name" id="name" value="{{$details->destination_name}}"></x-editinput>
                                        <x-editinput type="hidden" name="latitude" id="latitude" value=""></x-editinput>
                                        <x-editinput type="hidden" name="longitude" id="longitude" value=""></x-editinput>
                                        <div class="float-right mr-2 mt-2 md:mt-0 md:mr-5">
                                            <x-button id="checkin" type="submit" disabled>
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

                            @if(session('fail'))
                                <x-div-session class="bg-red-400">{{session('fail')}}</x-div-session>
                            @endif

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
</x-app-layout>

<script>
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
                "https://image.flaticon.com/icons/png/128/484/484150.png"
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
                document.getElementById('checkin').disabled = true;
            } else {
                console.log("Inside the point");
                document.getElementById('checkin').disabled = false;
            }
        }

        // get the coordinate
        function onload() {
            getCoordinate()
        }

        // automatically run the script to find employee's current position
        onload()
    });
</script>
