<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="flex container justify-center">
                        <div id="viewMap"></div>
                        @foreach($goals as $goal)
                            <input type="hidden" id="latitude" value="{{$goal->latitude}}"/>
                            <input type="hidden" id="longitude" value="{{$goal->longitude}}"/>
                            <input type="hidden" id="employee_name" value="{{$goal->employee->user->name}}"/>
                            <input type="hidden" id="destination_name" value="{{$goal->company->company_name}}"/>
                            <input type="hidden" id="user_name" value="{{$goal->user->name}}"/>
                        @endforeach
                    </span>
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
        ],
            function(esriConfig, Map, MapView, Graphic, GraphicsLayer) {

            esriConfig.apiKey = "AAPK3b583452b37548898ee56ef34a6ac70c8D9oQpRakOG5ZEnv5UySaM8NXnJNjuC5TScW4rTgoe-Lxp7ANLXwa0btm44QL0oa";

            const map = new Map({
                basemap: "osm-standard-relief" //Basemap layer service
            });

            const view = new MapView({
                map: map,
                center: [109.342506,-0.026330], //Longitude, latitude
                zoom: 13,
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
                height: "20px",
                width: "20px"
            };

            const pointGraphic = new Graphic({
                geometry: point,
                symbol: pictureMarkerSymbol
            });
            graphicsLayer.add(pointGraphic);
        });
    </script>
</x-app-layout>
