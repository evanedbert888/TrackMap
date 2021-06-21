<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $details->name.__(" Detail") }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('{{ URL::to('/img/blue-copy-space-digital-background_23-2148821698.jpg') }}')">
                    <div class="flex container justify-center items-start">
                        @if($details->image == '/img/Profile.png')
                            <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32" src="{{URL::to($details->image)}}">
                        @else
                            <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32" src="{{url('storage/'.$details->image)}}">
                        @endif
                    </div>
                </div>
                <div class="px-6 pt-3 bg-white border-b border-gray-200 mt-24">
                    <div class="flex container items-center justify-between">
                        <div class="mx-5">
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->name }}</h6>
                            </div>
                            <div class="text-md">
                                <h2>{{ $details->employee->motto }}</h2>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->email }}</h2>
                            </div>
                        </div>
                        <a class="float-right mr-5" href="{{route('employees.edit',['employee'=>$details->id])}}">
                            <x-button type="submit">
                                Edit
                            </x-button>
                        </a>
                    </div>
                    <div class="mx-5 mt-3 pb-10 pt-2">
                        <p class="font-bold text-xl">Detail</p>
                        <hr class="border border-5 border-black border-solid">
                        <table class="mt-3">
                            <tr>
                                <td>Birth Date</td>
                                <td>{{ __(": ").$details->birth_date }}</td>
                            </tr>
                            <tr>
                                <td>Sex</td>
                                <td>{{ __(": ").$details->sex }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ __(": ").$details->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
