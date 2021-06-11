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
                    <div style="height: 500px" class="mx-2 mt-5 flex content-center md:mx-5 bordered border-2 border-black">
                        <div style="padding: 0; margin: 0; height: 100%; width: 100%;" id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
