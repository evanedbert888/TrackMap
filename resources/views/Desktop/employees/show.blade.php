<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $details->user->name.__(" Detail") }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('{{ URL::to('/img/blue-copy-space-digital-background_23-2148821698.jpg') }}')">
                    @if($details->user->image == '/img/Profile.png')
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{URL::to($details->user->image)}}">
                    @else
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{url('storage/'.$details->user->image)}}">
                    @endif
                </div>
                <div class="p-6 bg-white border-b border-gray-200 ">
                    <a class="float-right mr-5" href="{{route('employees.edit',['employee'=>$details->id])}}">
                        <x-button type="submit">
                            edit
                        </x-button>
                    </a>
                    <div>
                        <div class="ml-60 mx-5">
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->user->name }}</h6>
                            </div>
                            <div class="text-md">
                                <h2>{{ $details->motto }}</h2>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->user->email }}</h2>
                            </div>
                        </div>
                        <div class="mx-5 mt-3">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
                                <tr>
                                    <td>Birth Date</td>
                                    <td>{{ __(": ").$details->user->birth_date }}</td>
                                </tr>
                                <tr>
                                    <td>Sex</td>
                                    <td>{{ __(": ").$details->user->sex }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ __(": ").$details->user->address }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="mx-5 mt-5 bg-blue-400 h-96 flex flex-wrap content-center">
                            <div class="w-full">
                                <p class="text-center">SHOW MAP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>