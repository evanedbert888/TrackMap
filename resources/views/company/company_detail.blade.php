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
                <div class="container">
                    <div class="bg-cover h-44 w-full object-top bg-no-repeat mb-2" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                        <img class="float-left rounded-full h-40 w-40 object-cover ml-20 mt-28 mr-3" src="https://images.bisnis-cdn.com/posts/2021/03/27/1373332/mihoyo.jpg" alt="">
                    </div>
                    <div>
                        <x-button class="float-right mr-5" type="submit">
                             edit
                        </x-button>
                        <table>
                            <tr> <td>{{$detail->company_name}}</td> </tr>
                            <tr> <td>{{__('Email')}}</td> </tr>
                            <tr> <td>{{$detail->address}}</td> </tr>
                        </table>
                    </div>
                </div>
                <div class="py-2">
                    <div class="float-left m-5 mr-10 mb-10 w-full">
                        <span class="text-2xl"> Detail </span>
                        <hr class="border border-5 border-black border-solid mr-10">
                        <div class="overflow-x-scroll mr-10">
                            {{$detail->description}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
