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
<link rel="stylesheet" href="https://js.arcgis.com/4.19/esri/themes/light/main.css">
<script src="https://js.arcgis.com/4.19/"></script>
<script>
    {
        "places": [
            {
                "id": 1,
                "address": "200 N Spring St, Los Angeles, CA 90012",
                "longitude": -118.24354,
                "latitude": 34.05389
            },
            {
                "id": 2,
                "address": "419 N Fairfax Ave, Los Angeles, CA 90036",
                "longitude": -118.31966,
                "latitude": 34.13375
            }
        ]
    }
    
    require([
        "esri/config",
        "esri/Map",
        "esri/views/MapView",
    
        "esri/tasks/Locator",
        "esri/Graphic",
        "esri/layers/GraphicsLayer"
    
    ], function(esriConfig,Map, MapView, FeatureLayer, Graphic, GraphicsLayer) {                                
        esriConfig.apiKey = "AAPK05b0d7c5ec0d4ae1927e0bbcfd70d2a4gWIVK3qxuiuX3_O59_EWgQA1ztAKxDTETQeKQ7JoLB0XLhlE6uYCfnTLxyHe0XPM";
        const map = new Map({
        basemap: "streets-navigation-vector" //Basemap layer service
        });
        
        
        const view = new MapView({
            container: "map",
            map: map,
            center: [ -118.31966,  34.13375],
            zoom: 15
        });
        var graphics = places.map(function (place) {
            return new Graphic({
                attributes: {
                ObjectId: place.id,
                address: place.address
                },
                geometry: {
                longitude: place.longitude,
                latitude: place.latitude
                }
            });
        });
        var featureLayer = new FeatureLayer({
            source: graphics,
            renderer: {
                type: "simple",                    // autocasts as new SimpleRenderer()
                symbol: {                          // autocasts as new SimpleMarkerSymbol()
                type: "simple-marker",
                color: "#102A44",
                outline: {                       // autocasts as new SimpleLineSymbol()
                    color: "#598DD8",
                    width: 2
                }
                }
            },
            popupTemplate: {                     // autocasts as new PopupTemplate()
                title: "Places in Los Angeles",
                content: [{
                type: "fields",
                fieldInfos: [
                    {
                    fieldName: "address",
                    label: "Address",
                    visible: true
                    }
                ]
                }]
            },
            objectIdField: "ObjectID",           // This must be defined when creating a layer from `Graphic` objects
            fields: [
                {
                name: "ObjectID",
                alias: "ObjectID",
                type: "oid"
                },
                {
                name: "address",
                alias: "address",
                type: "string"
                }
            ]
            });

            map.layers.add(featureLayer);
    });
</script>
