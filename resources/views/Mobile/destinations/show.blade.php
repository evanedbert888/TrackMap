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
                    <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 ml-6 md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url($details->image)}}">
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
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
                                <x-editinput type="hidden" name="check" id="check" value=""></x-editinput>
                                <div class="float-right mr-2 mt-2 md:mt-0 md:mr-5">
                                    <x-button id="checkin" type="submit" disabled>
                                        Check-In
                                    </x-button>
                                </div>
                            </form>
                        @endcan
                    @endif
                    <div>
                        <div class="mx-2 mt-16 md:ml-60 md:mx-5 md:mt-0">
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
        "esri/tasks/Locator",
        "esri/geometry/Circle"

    ], function(esriConfig, Map, MapView, Graphic, GraphicsLayer, Locator, Circle) {

        esriConfig.apiKey = "AAPKd14f6a7025a441bca958cfe373e9a0708Me2zOHz9-4bPzujZd2ZZkQ6W4n-UL8AB29QcugYNzzOh82WKuWHo1_Znivm110D";

        function findIDValue(point) {
            let find = document.getElementById(point)
            let value = find.attributes.getNamedItem('value').value;
            return value;
        }

        let lng = findIDValue('lng');
        let lat = findIDValue('lat');

        const map = new Map({
            basemap: "osm-standard-relief" //Basemap layer service
        });

        const view = new MapView({
            map: map,
            center: [lng,lat], //Longitude, latitude
            zoom: 17,
            container: "mobileMap"
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

        const THRESHOLD_DISTANCE = 300;

        let circlePoint = new Graphic({
            geometry: new Circle({
                center: [lng,lat],
                radius: THRESHOLD_DISTANCE,
                radiusUnit: "meters"
            }),
            symbol: {//circle design
                type: "simple-fill"
            }
        })
        graphicsLayer.graphics.add(circlePoint);

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
                title: address,
                content: Math.round(pt.longitude * 100000)/100000 + ", " + Math.round(pt.latitude * 100000)/100000,
                location: pt
            });
        }
    });
</script>

<script>
    require([
        "esri/config",
        "esri/geometry/Point",
        "esri/geometry/support/geodesicUtils",
    ],function (esriConfig,Point,geodesicUtils) {

        esriConfig.apiKey = "AAPKd14f6a7025a441bca958cfe373e9a0708Me2zOHz9-4bPzujZd2ZZkQ6W4n-UL8AB29QcugYNzzOh82WKuWHo1_Znivm110D";

        function findIDValue(point) {
            let find = document.getElementById(point)
            return find.attributes.getNamedItem('value').value;
        }

        let circle_lng = findIDValue('lng');
        let circle_lat = findIDValue('lat');

        function getCoordinate() {
            navigator.geolocation.getCurrentPosition(getCoordinateSuccess)
        }

        function getCoordinateSuccess(geoLocationPosition) {
            console.log(geoLocationPosition)
            setCoordinateToFormField(geoLocationPosition.coords)
        }

        function setCoordinateToFormField(coordinate) {
            let long = coordinate.longitude;
            let lat = coordinate.latitude;
            document.querySelector('#latitude').setAttribute('value',lat)
            document.querySelector('#longitude').setAttribute('value',long)
            calculateDistanceBetweenTwoPoints(circle_lng,circle_lat,long,lat)
        }

        function calculateDistanceBetweenTwoPoints(circle_lng,circle_lat,long,lat) {
            const THRESHOLD_DISTANCE = 300;
            let check;
            const pt1 = new Point({ x: circle_lng, y: circle_lat });
            const pt2 = new Point({ x: long, y: lat});

            const result = geodesicUtils.geodesicDistance(
                pt1,
                pt2,
                "meters"
            );

            console.log(result.distance);

            if (result.distance > THRESHOLD_DISTANCE) {
                check = false
                console.log("Outside the point");
                document.getElementById('checkin').disabled = true;
            } else {
                check = true
                console.log("Inside the point");
                document.getElementById('checkin').disabled = false;
            }
            document.querySelector('#check').setAttribute('value',check)
        }

        function onload() {
            getCoordinate()
        }

        onload()
    })
</script>
