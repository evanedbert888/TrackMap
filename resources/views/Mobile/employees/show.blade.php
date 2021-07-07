<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $details->name.__(" Detail") }}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-40 w-full object-top bg-no-repeat flex md:h-60" style="background-image: url('{{ URL::to('/img/blue-copy-space-digital-background_23-2148821698.jpg') }}')">
                    <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 mx-auto md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url($details->image)}}">
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    <div class="mx-2 md:mx-0">
                        <div class="mt-16 md:ml-60 md:mt-0">
                            @can('mobile edit profile')
                                <a class="float-right mt-2 md:mt-0" href="{{route('mobile.users.edit',['employee'=>$details->employee->id])}}">
                                    <x-button type="submit">
                                        Edit
                                    </x-button>
                                </a>
                            @endcan
                            @if(session('update'))
                                <x-div-session class="bg-green-200">{{session('update')}}</x-div-session>
                            @endif
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
                        <div class="mt-3 md:mt-8">
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
    </div>
</x-app-layout>
