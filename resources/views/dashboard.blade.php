<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
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
                data : {select: 'Today'},
                success:function(data){
                    pushArray(data);
                },
                error:function(err){
                    console.log(err);
                }
            });
        })

    var places = [];
    function pushArray(data) {
        $.each(data, function(key,value) {
            var time = value.updated_at.split('.');
            var updated_at = time[0].split('T');
            places.push({
                id: value.id,
                address: value.destination.address,
                company: value.destination.destination_name,
                employee: value.employee.user.name,
                longitude: value.longitude,
                latitude: value.latitude,
                updated_at: updated_at[1]+" "+updated_at[0]
            });
        })
        loadmap();
    }
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
    function loadmap(){
        var role = '{{ Auth::user()->job }}';

        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",

            "esri/Graphic",
            "esri/layers/GraphicsLayer",
            "esri/tasks/Locator",
            "esri/layers/FeatureLayer"


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
            showFeature();

            // Create a UI with the filter expressions
            const sqlExpressions = ["Today", "This Week", "This Month", "This Year", "All"];

            // UI
            const selectFilter = document.createElement("select");
            selectFilter.setAttribute("class", "esri-widget esri-select");
            selectFilter.setAttribute("style", "width: 275px; font-family: Avenir Next W00; font-size: 1em;");

            sqlExpressions.forEach(function(sql){
                let option = document.createElement("option");
                option.value = sql;
                option.innerHTML = sql;
                selectFilter.appendChild(option);
            });

            view.ui.add(selectFilter, "top-right");

            // Server-side filter
            function setFeatureLayerFilter(expression) {
                $.ajax({
                    url : '{{ route('dashboard_goals') }}',
                    type : 'GET',
                    data : {select: expression},
                    success:function(data){
                        pushArrayMap(data);
                    },
                    error:function(err){
                        console.log(err);
                    }
                });
            }

            // Event listener
            selectFilter.addEventListener('change', (event) => {
                view.popup.close();
                map.layers.removeAll();
                setFeatureLayerFilter(event.target.value);
            });
            
            function pushArrayMap(data) {
                places = [];
                $.each(data, function(key,value) {
                    var time = value.updated_at.split('.');
                    var updated_at = time[0].split('T');
                    places.push({
                        id: value.id,
                        address: value.destination.address,
                        company: value.destination.destination_name,
                        employee: value.employee.user.name,
                        longitude: value.longitude,
                        latitude: value.latitude,
                        updated_at: updated_at[1]+" "+updated_at[0]
                    });
                })
                showFeature();
            }

            function showFeature(){
                var graphics = places.map(function (place) {
                    return new Graphic({
                        attributes: {
                            ObjectId: place.id,
                            address: place.address,
                            company: place.company,
                            employee: place.employee,
                            finished: place.updated_at
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
                            symbol: {
                                type: "picture-marker",
                                url: "https://cdn.iconscout.com/icon/premium/png-256-thumb/place-marker-3-599570.png",
                                height: "30px",
                                width: "30px"
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
                                    },
                                    {
                                        fieldName: "finished",
                                        label: "Finished At",
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
                            },
                            {
                                name: "finished",
                                alias: "finished",
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
                            symbol: {
                                type: "picture-marker",
                                url: "https://cdn.iconscout.com/icon/premium/png-256-thumb/place-marker-3-599570.png",
                                height: "30px",
                                width: "30px"
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
                map.layers.remove(featureLayer);
                }
                map.layers.add(featureLayer);
            }
        });
    }
</script>
