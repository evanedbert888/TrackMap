<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $details[0]->name.__(" Detail") }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('http://localhost/Project/TrackMap/resources/views/components/img/blue-copy-space-digital-background_23-2148821698.jpg')">
                    <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80">
                </div>
                <div class="p-6 pt-1 bg-white border-b border-gray-200 ">
                    <form method="POST" action="{{ route('profile_update') }}">
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
                                    <x-editinput id="name" name="name" class="font-bold text-2xl" type="text" value="{{ $details[0]->name }}"/>
                                </div>
                                <div class="text-sm mt-1">
                                    <x-editinput id="email" name="email" type="text" value="{{ $details[0]->email }}"/>
                                </div>
                                {{-- <div class="text-sm">
                                    <h2>{{ $details[0]->motto }}</h2>
                                </div> --}}
                            </div>
                            <div class="mx-5 mt-3">
                                <p class="font-bold text-lg">Detail</p>
                                <hr class="border border-5 border-black border-solid mb-3">
                                <table>
                                    <tr class="mb-4">
                                        <td>Birth Date</td>
                                        <td>:</td>
                                        <td><x-editinput id="birth_date" name="birth_date" type="date" value="{{ $details[0]->birth_date }}"/></td>
                                    </tr>
                                    <tr class="mb-4">
                                        <td>Sex</td>
                                        <td>:</td>
                                        <td><x-editinput id="sex" name="sex" type="text" value="{{ $details[0]->sex }}"/></td>
                                    </tr>
                                    <tr class="mb-4">
                                        <td>Address</td>
                                        <td>:</td>
                                        <td>
                                            <textarea class="rounded-lg" name="address" id="address" cols="40" rows="2">{{$details[0]->address }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="mb-4">
                                        <td>Join At</td>
                                        <td>:</td>
                                        @php
                                            $time = explode(' ',$details[0]->created_at);
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
