<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script>
        $(document).ready(function() {
            $.ajax({
                url : '{{ route('dashboard_goals') }}',
                type : 'GET',
                success:function(data){
                    pushArray(data);
                },
                error:function(err){
                    console.log(err);
                }
            });
        })
    </script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="flex container justify-center">
                        <div id="viewMap"></div>
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<link rel="stylesheet" href="https://js.arcgis.com/4.19/esri/themes/light/main.css">
<script>
    var places = [];

    function pushArray(data) {
        $.each(data, function(key,value) {    
            places.push({ 
                id: value.id,
                address: value.address,
                company: value.destination_name,
                employee: value.employee_name,
                longitude: value.longitude,
                latitude: value.latitude
            });
        })

        var role = '{{ Auth::user()->role }}';

        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",

            "esri/Graphic",
            "esri/layers/GraphicsLayer",
            "esri/tasks/Locator",
            "esri/layers/FeatureLayer",


        ], function(esriConfig, Map, MapView, Graphic, GraphicsLayer, Locator, FeatureLayer, ) {
            esriConfig.apiKey = "AAPKd14f6a7025a441bca958cfe373e9a0708Me2zOHz9-4bPzujZd2ZZkQ6W4n-UL8AB29QcugYNzzOh82WKuWHo1_Znivm110D";
            const map = new Map({
                basemap: "streets-navigation-vector" //Basemap layer service
            });

            const view = new MapView({
                map: map,
                center: [ 109.3425,  -0.0383],
                zoom: 12,
                container: "viewMap"
            });

            var graphics = places.map(function (place) {
                return new Graphic({
                    attributes: {
                        ObjectId: place.id,
                        address: place.address,
                        company: place.company,
                        employee: place.employee
                    },
                    geometry: {
                        longitude: place.longitude,
                        latitude: place.latitude,
                        type : "point"
                    }
                });
            });

            if (role == 'admin') {
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
                        title: "Finished Place",    //belum dapat menampilan nama company
                        content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "company",
                                    label: "Company Name",
                                    visible: true
                                },
                                {
                                    fieldName: "address",
                                    label: "Company Address",
                                    visible: true
                                },
                                {
                                    fieldName: "employee",
                                    label: "Employee Name",
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
                        },
                        {
                            name: "employee",
                            alias: "employee",
                            type: "string"
                        },
                        {
                            name: "company",
                            alias: "company",
                            type: "string"
                        }
                    ]
                });
            }
            else if (role == 'employee') {
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
                        title: "Finished Place",    //belum dapat menampilan nama company
                        content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "company",
                                    label: "Company Name",
                                    visible: true
                                },
                                {
                                    fieldName: "address",
                                    label: "Company Address",
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
                        },
                        {
                            name: "company",
                            alias: "company",
                            type: "string"
                        }
                    ]
                });
            }
            map.layers.add(featureLayer); 
        });
    }
</script>