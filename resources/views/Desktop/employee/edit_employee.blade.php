<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->user->name}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('{{ URL::to('/img/blue-copy-space-digital-background_23-2148821698.jpg') }}')">
                    @if($details->user->image == 'img/Profile.png')
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{URL::to('/'.$details->user->image)}}">
                    @else
                        <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{url('storage/'.$details->user->image)}}">
                    @endif
                </div>
                <div class="p-6 pt-1 bg-white border-b border-gray-200 ">
                    <form method="POST" action="{{ route('employee_patch',['id'=>$details->id]) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="float-right mr-5">
                            <x-savebutton type="submit" class="mt-5">
                                update
                            </x-savebutton>
                        </div>
                        <div>
                            <div class="ml-60 mx-5">
                                <div>
                                    <x-editinput name="name" id="name" class="font-bold text-2xl" type="text" value="{{ $details->user->name }}"/>
                                </div>
                                <div class="text-sm mt-1">
                                    <div>
                                        <x-editinput name="motto" id="motto" class="text-md" type="text" value="{{ $details->motto }}"/>
                                    </div>
                                    <div>
                                        <x-editinput name="email" id="email" class="text-md" type="text" value="{{ $details->user->email }}"/>
                                    </div>
                                    <div>
                                        <x-editinput name="image" id="image" class="text-md" type="file"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-5 mt-3">
                                <p class="font-bold text-xl">Detail</p>
                                <hr class="border border-5 border-black border-solid">
                                <table class="mt-3">
                                    <tr>
                                        <td>Birth Date</td>
                                        <td>:</td>
                                        <td><x-editinput name="birth_date" id="birth_date" type="date" value="{{ $details->user->birth_date }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Sex</td>
                                        <td>:</td>
                                        <td><x-editinput name="sex" id="sex" type="text" value="{{ $details->user->sex }}"/></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>:</td>
                                        <td>
                                            <textarea class="rounded-lg" name="address" id="address" cols="40" rows="2">{{$details->user->address }}</textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mx-5 mt-5 bg-blue-400 h-96 flex flex-wrap content-center">
                                <div class="w-full">
                                    <p class="text-center">SHOW MAP</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
