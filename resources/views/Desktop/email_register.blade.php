<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Email Register") }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 pb-16 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 justify-items-center">
                        <div class="text-center pb-2 font-semibold text-lg">
                            <p> Register An Email </p>
                        </div>
                        <div class="items-center">
                            <form action="{{route('add_email')}}" method="POST">
                                @csrf
                                <div class="pt-2 justify-center">
                                    <x-label class="font-semibold text-xl" for="email" :value="__('Email')"/>

                                    <x-input id="email" class="w-96" type="text"
                                             name="email" placeholder="Enter the Email" required
                                             autofocus/>
                                </div>

                                <div class="my-4">
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
