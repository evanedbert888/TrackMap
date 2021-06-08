<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register List') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="text-center pb-2 font-semibold text-lg">
                            <p> List of Registers </p>
                        </div>
                        <div class="flex container justify-center text-center">
                            <table class="table-auto border-4 border-collapse">
                                <thead>
                                    <th class="border-4 border-green-400 px-4"> ID </th>
                                    <th class="border-4 border-green-400 px-5"> Email </th>
                                    <th class="border-4 border-green-400 px-3"> Status </th>
                                    <th class="border-4 border-green-400 px-4"> Registered By </th>
                                    <th class="border-4 border-green-400 px-4"> Registered At </th>
                                </thead>
                                <tbody>
                                    @foreach($registers as $register)
                                        <tr>
                                            <td class="border-4 border-green-400 px-4"> {{$register->id}} </td>
                                            <td class="border-4 border-green-400 px-5"> {{$register->email}} </td>
                                            <td class="border-4 border-green-400 px-3"> {{$register->status}} </td>
                                            <td class="border-4 border-green-400 px-4"> {{$register->user->name}} </td>
                                            <td class="border-4 border-green-400 px-4"> {{$register->created_at}} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$registers->links()}}
                    </div>
                    <div class="flex justify-end my-2">
                        <a href="{{route('email_register')}}" class="">
                            <x-button type="button">Register new Email</x-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

