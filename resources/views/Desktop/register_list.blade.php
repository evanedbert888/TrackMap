<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register List') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="text-center pb-4 font-semibold text-lg">
                            <p> List of Registers </p>
                        </div>
                        <div class="flex container justify-center content-center text-center">
                            <table class="table-auto border border-collapse border border-green-500">
                                <thead>
                                    <th class="border border-green-700 px-4"> ID </th>
                                    <th class="border border-green-700 px-5"> Email </th>
                                    <th class="border border-green-700 px-3"> Status </th>
                                    <th class="border border-green-700 px-4"> Registered By </th>
                                    <th class="border border-green-700 px-4"> Registered At </th>
                                </thead>
                                <tbody>
                                    @foreach($registers as $register)
                                        <tr>
                                            <td class="border border-green-700 px-4"> {{$register->id}} </td>
                                            <td class="border border-green-700 px-5"> {{$register->email}} </td>
                                            <td class="border border-green-700 px-3"> {{$register->status}} </td>
                                            <td class="border border-green-700 px-4"> {{$register->user->name}} </td>
                                            <td class="border border-green-700 px-4"> {{$register->created_at}} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$registers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

