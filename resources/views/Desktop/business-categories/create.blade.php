<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("New Business Category") }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="w-full">
                        <div class="items-center">
                            @can('store business-category')
                                <form action="{{route('business-categories.store')}}" method="POST">
                                    @method('POST')
                                    @csrf
                                    <div class="pt-2 justify-center">
                                        <x-label class="font-semibold text-xl w-full" for="email" :value="__('Enter New Business Category')"></x-label>

                                        <x-input id="name" class="w-full" type="text"
                                                 name="name" placeholder="Input New Category" required
                                                 autofocus></x-input>
                                    </div>

                                    <div class="my-4 flex items-center justify-end">
                                        <x-button>
                                            {{ __('Submit') }}
                                        </x-button>
                                    </div>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
