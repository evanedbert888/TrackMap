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
                    <div class="bg-cover h-44 w-full object-top bg-no-repeat mb-3" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                        <img class="float-left rounded-full h-44 w-44 object-cover ml-28 mt-28 mr-3" src="https://images.bisnis-cdn.com/posts/2021/03/27/1373332/mihoyo.jpg" alt="">
                    </div>
                    <div>
                        <table>
                            <div>
                                <tr> {{$detail->company_name}} </tr>
                            </div>
                            <div>
                                <tr> {{__('Email')}} </tr>
                            </div>
                            <div>
                                <tr> {{$detail->address}} </tr>
                            </div>
                        </table>
                    </div>
                </div>
                <div class="py-8">
                    <div class="float-left m-5 w-full">
                        <span class="text-2xl"> Detail </span>
                        <button class="float-right mr-10" type="submit">
                             Save
                        </button>
                        <hr class="border border-5 border-black border-solid">
                        <div class="overflow-scroll">
                            {{$detail->description}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
