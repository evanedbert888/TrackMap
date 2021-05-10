<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Destination
        </h2>
    </x-slot>

    <?php
        if (isset($_POST["search"])) {
            $address = $_POST["address"];
            ?>
                <iframe width="100%" height="500" src="https://maps.google.com/maps?q=<?php echo $address;
                ?>&output=embed"></iframe>
            <?php
        }
    ?>

    <div class="py-8">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-5 bg-white border-b border-gray-200">
                    <table class="w-full">
                        <tr>
                            <td>
                                <span class="flex container">
                                    <form action="{{route('add_company')}}" method="POST">
                                    @csrf
                                    <!-- Company Name -->
                                        <div class="my-4">
                                            <x-label for="company_name" :value="__('Company Name')"/>

                                            <x-input id="company_name" class="block mt-1 w-96" type="text"
                                                     name="company_name" :value="old('company_name')" required
                                                     autofocus/>
                                        </div>

                                        <!-- Business -->
                                        <div class="my-4">
                                            <x-label for="business" :value="__('Business')"/>

                                            <x-input id="business" class="block mt-1 w-96" type="text" name="business"
                                                     :value="old('business')" required autofocus/>
                                        </div>

                                        <!-- Address -->
                                        <div class="my-4">
                                            <x-label for="address" :value="__('Address')"/>

                                            <textarea class="block mt-1 rounded-md " name="address" id="address"
                                                      cols="40" rows="2"></textarea>
                                            <x-button id="search" type="button" name="search">search</x-button>
                                        </div>

                                        <!-- Email -->
                                        <div class="my-4">
                                            <x-label for="email" :value="__('Email')" />

                                            <x-input id="email" class="block mt-1 w-96" type="text" name="email" :value="old('email')" required />
                                        </div>

                                        <!-- Coordinate -->
                                        <div class="my-4">
                                            <div>
                                                <x-label for="coordinate" :value="__('Coordinate')"/>

                                                <x-input id="coordinate" class="block mt-1 w-96" type="text" name="coordinate" :value="old('coordinate')" required />
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="my-4">
                                            <x-label for="description" :value="__('Description')"/>

                                            <textarea class="block mt-1 rounded-md " name="description" id="description"
                                                      cols="40" rows="3"></textarea>
                                        </div>

                                        <div class="my-4 float-right">
                                           <x-button>
                                                {{ __('Submit') }}
                                            </x-button>
                                        </div>
                                    </form>
                                </span>
                            </td>
                            <td>
                                <span class="flex container border border-5 border-red">
                                    <div class="mx-5 mt-5 bg-blue-400 h-96 flex flex-wrap content-center">
                                        <div class="w-full">
                                            <p class="text-center">SHOW MAP</p>
                                        </div>
                                    </div>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script !src="">
        var btnSearch = document.querySelector("#search")
        btnSearch.addEventListener("click", () => {
            var address = document.querySelector("#address").value
            console.log(address)
            getCoordinateOfAddress(address)
        })

        function getCoordinateOfAddress(address) {
            fetch('http://127.0.0.1:8000/api/GeoSearch?address=' + address, {
                method: "get"
            })
                .then(response => response.json())
                .then(responseJson => {
                    console.log(responseJson)
                    setCoordinate(responseJson)
                })
            .catch(error =>{
                console.log(error)
            })
        }

        function setCoordinate(coordinate) {
            document.querySelector("#coordinate").value = `${coordinate.x},${coordinate.y}`
        }
    </script>
</x-app-layout>
