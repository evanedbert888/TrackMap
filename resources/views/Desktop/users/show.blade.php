<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $details->name.__(" Detail") }}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-40 w-full object-top bg-no-repeat md:h-60" style="background-image: url('{{ URL::to('/img/blue-copy-space-digital-background_23-2148821698.jpg') }}')">
                    @if($details->image == null)
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{URL::to('/img/Profile.png')}}">
                    @else
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{url('storage/'.$details->image)}}">
                    @endif
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    @can('edit user')
                        <a class="float-right mr-2 mt-2 md:mt-0 md:mr-5" href="{{ route('users.edit',['user'=>$details->id]) }}">
                            <x-button type="submit">
                                edit
                            </x-button>
                        </a>
                    @endcan
                    <div>
                        <div class="mx-2 mt-16 md:ml-60 md:mx-5 md:mt-0">
                            <div>
                                <h6 class="font-bold text-2xl">{{ $details->name }}</h6>
                            </div>
                            <div class="text-sm">
                                <h2>{{ $details->email }}</h2>
                            </div>
                            {{-- <div class="text-sm">
                                <h2>{{ $details[0]->motto }}</h2>
                            </div> --}}
                        </div>
                        <div class="mx-2 mt-3 md:mt-8 md:mx-5">
                            <p class="font-bold text-xl">Detail</p>
                            <hr class="border border-5 border-black border-solid">
                            <table class="mt-3">
                                <tr class="align-top">
                                    <td>Birth Date</td>
                                    <td>:</td>
                                    <td>{{ $details->birth_date }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Sex</td>
                                    <td>:</td>
                                    <td>{{ $details->sex }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Address</td>
                                    <td>:</td>
                                    <td>{{ $details->address }}</td>
                                </tr>
                                <tr class="align-top">
                                    <td>Join At</td>
                                    <td>:</td>
                                    @php
                                        $time = explode(' ',$details->created_at);
                                    @endphp
                                    <td>{{ $time[0] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
