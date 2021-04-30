<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Destination
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="flex container">
                        <form action="{{route('add_company')}}" method="POST">
                        @csrf
                            <!-- Company Name -->
                            <div class="my-4">
                                <x-label for="company_name" :value="__('Company Name')" />

                                <x-input id="company_name" class="block mt-1 w-96" type="text" name="company_name" :value="old('company_name')" required autofocus />
                            </div>

                                <!-- Business -->
                            <div class="my-4">
                                <x-label for="business" :value="__('Business')" />

                                <x-input id="business" class="block mt-1 w-96" type="text" name="business" :value="old('business')" required autofocus />
                            </div>

                                <!-- Address -->
                            <div class="my-4">
                                <x-label for="address" :value="__('Address')" />

                                <textarea class="block mt-1 rounded-md " name="address" id="address" cols="40" rows="2"></textarea>
                            </div>

                                <!-- Coordinate -->
                            <div class="my-4">
                                <div>
                                    <x-label for="coordinate" :value="__('Coordinate')" />

                                    <x-input id="coordinate" class="block mt-1 w-96" type="text" name="coordinate" :value="old('coordinate')" required autofocus />
                                </div>
                            </div>

                                <!-- Description -->
                            <div class="my-4">
                                <x-label for="description" :value="__('Description')" />

                                <textarea class="block mt-1 rounded-md " name="description" id="description" cols="40" rows="3"></textarea>
                            </div>

                            <div class="my-4">
                               <x-button>
                                    {{ __('Submit') }}
                                </x-button>
                            </div>
                        </form>
                    </span>
                    <span class="flex container">

                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
