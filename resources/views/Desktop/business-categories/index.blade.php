<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Categories') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="w-full">
                        <h1 class="text-2xl font-bold">Business Categories</h1>
                        <div class="border border-black border-5 rounded rounded-full h-1 bg-black"></div>
                        <div class="flex mx-auto justify-center">
                            <table class="w-full table-auto mt-4">
                                <thead>
                                <tr class="text-center text-lg">
                                    <th> No </th>
                                    <th class="text-left"> Name </th>
                                    <th colspan="2"> Action </th>
                                </tr>
                                </thead>
                                <tbody class="text-center text-lg">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($categories as $category)
                                    <tr class="bg-red-100 border border-white border-b-4 border-t-0 border-r-0 border-l-0">
                                        <td> {{ $i++ }} </td>
                                        <td class="text-left"> {{$category->name}} </td>
                                        <td>
                                            <a href="{{route('business-categories.edit',[$category->id])}}">
                                                <x-button type="button"> Edit </x-button>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{route('business-categories.destroy',['businessCategory'=>$category->id])}}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                    <x-button type="submit"> Delete </x-button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$categories->links()}}
                    </div>
                    <div class="flex justify-end my-2">
                        <a href="{{route('business-categories.create')}}">
                            <x-button type="button">Create new category</x-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

