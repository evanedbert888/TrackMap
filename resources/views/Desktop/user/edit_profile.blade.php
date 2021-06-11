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
                    @if($details->user->image == '/img/Profile.png')
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{URL::to($details->user->image)}}">
                    @else
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{url('storage/'.$details->user->image)}}">
                    @endif
                </div>
                <div class="p-6 pt-1 bg-white border-b border-gray-200 ">
                    <form method="POST" action="{{ route('profile_update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="float-right mr-5 mt-5">
                            <x-savebutton type="submit">
                                Update
                            </x-savebutton>
                        </div>
                        <div>
                            <div class="ml-60 mx-5">
                                <div>
                                    <x-editinput id="name" name="name" class="font-bold text-2xl" type="text" value="{{ $details->name }}"/>
                                </div>
                                <div class="text-sm mt-1">
                                    <x-editinput id="email" name="email" type="text" value="{{ $details->email }}"/>
                                </div>
                                <div class="text-sm mt-1">
                                    <x-editinput id="image" name="image" type="file"/>
                                </div>
                            </div>
                            <div class="mx-5 mt-3">
                                <p class="font-bold text-lg">Detail</p>
                                <hr class="border border-5 border-black border-solid mb-3">
                                <table>
                                    <tr>
                                        <td>Birth Date</td>
                                        <td>:</td>
                                        <td><x-editinput id="birth_date" name="birth_date" type="date" value="{{ $details->birth_date }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Sex</td>
                                        <td>:</td>
                                        <td><x-editinput id="sex" name="sex" type="text" value="{{ $details->sex }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>:</td>
                                        <td>
                                            <textarea class="rounded-lg" name="address" id="address" cols="40" rows="2">{{$details->address }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Join At</td>
                                        <td>:</td>
                                        @php
                                            $time = explode(' ',$details->created_at);
                                        @endphp
                                        <td>{{  $time[0] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
