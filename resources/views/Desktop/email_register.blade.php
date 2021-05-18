<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Email Register") }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="text-center pb-4 font-semibold text-lg">
                            <p> Register An Email </p>
                        </div>
                        <div class="container mx-auto">
                            <form action="{{route('add_email')}}" method="POST">
                                @csrf
                                <div class="my-4 justify-center">
                                    <x-label for="email" :value="__('Email')"/>

                                    <x-input id="email" class="block mt-1 w-96" type="text"
                                             name="email" placeholder="Enter the Email" required
                                             autofocus/>
                                </div>

                                <div class="my-4 float-right">
                                    <x-button>
                                        {{ __('Submit') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
