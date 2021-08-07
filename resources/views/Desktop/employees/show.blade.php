<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $details->user->name.__(" Detail") }}
        </h2>
    </x-slot>

    <script>
        var url = '{{ route("map", ["employee"=>$details->id]) }}'
        $(document).ready(function() {
            $.ajax({
                url : url,
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


    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-40 w-full object-top bg-no-repeat flex md:h-60" style="background-image: url('{{ URL::to('/img/blue-copy-space-digital-background_23-2148821698.jpg') }}')">
                    <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 mx-auto md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url($details->user->image)}}">
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    <div class="mx-2 md:mx-0">
                        <div class="mt-16 md:ml-60 md:mt-0">
                            @can('edit employee')
                                <a class="float-right" href="{{route('employees.edit',['employee'=>$details->id])}}">
                                    <x-button type="submit">
                                        edit
                                    </x-button>
                                </a>
                            @endcan
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->user->name }}</h6>
                            </div>
                            <div class="text-md">
                                <h2>{{ $details->motto }}</h2>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->user->email }}</h2>
                            </div>

                            @if(session('update'))
                                <x-div-session class="bg-green-200" id="div-session">
                                    {{session('update')}}
                                    <x-close-button id="hideModal"></x-close-button>
                                </x-div-session>
                            @endif

                        </div>
                        <div class="mt-3">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
                                <tr>
                                    <td>Birth Date</td>
                                    <td>{{ __(": ").$details->user->birth_date }}</td>
                                </tr>
                                <tr>
                                    <td>Sex</td>
                                    <td>{{ __(": ").$details->user->sex }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ __(": ").$details->user->address }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="mt-5">
                            <span class="flex container justify-center">
                                <div id="viewMap" style="height: 420px"></div>
                            </span>
                        </div>
                    </div>
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
                address: value.destination.address,
                company: value.destination.destination_name,
                employee: value.employee.employee_name,
                longitude: value.longitude,
                latitude: value.latitude
            });
        })

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

            map.layers.add(featureLayer);
        });
    }
</script>

<script>
    $(document).ready(function(){
        $("#hideModal").click(function(){
            $("#div-session").hide();
        });
    });
</script>
