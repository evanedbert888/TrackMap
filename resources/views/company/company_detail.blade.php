<x-app-layout>
    @foreach($details as $detail)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$detail->company_name}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <img class="object-cover h-44 w-full object-top" src="https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg" alt="">
                <div>
                    <table>
                        <tr>
                            <span class="flex">
                                <td>
                                    <img class="rounded-full h-44 w-44 object-cover mx-10" src="https://images.bisnis-cdn.com/posts/2021/03/27/1373332/mihoyo.jpg" alt="">
                                </td>
                            </span>
                            <span>
                                <td>
                                    <p> {{$detail->company_name}} </p>
                                    <p> {{__('Email')}} </p>
                                    <p> {{$detail->address}} </p>
                                </td>
                            </span>
                        </tr>
                    </table>

                </div>
                <div class="bg-white border-b border-gray-200">
                    <table>
                        <tr>
                            <td class="font-semibold text-xl">
                                <p> Detail </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="container bg-blue-500 h-32">

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
