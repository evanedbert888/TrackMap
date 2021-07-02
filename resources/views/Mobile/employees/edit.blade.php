<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->user->name}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-60 w-full object-top bg-no-repeat" style="background-image: url('https://statik.tempo.co/data/2020/12/04/id_985339/985339_720.jpg')">
                    <div class="flex container justify-center items-start">
                        <img class="inline-block h-48 w-48 rounded-full ring-2 ring white object-cover mt-32" src="{{url($details->user->image)}}">
                    </div>
                </div>
                <div class="px-6 pt-5 bg-white border-b border-gray-200 mt-20">
                    @can('mobile update profile')
                        <form method="POST" action="{{ route('mobile.users.update',['employee'=>$details->id]) }}" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="flex container justify-between">
                                <div class="mx-5">
                                    <div>
                                        <x-editinput name="name" id="name" class="font-semibold text-xl" type="text" value="{{ $details->user->name }}"/>
                                    </div>
                                    <div class="text-sm mt-1 space-y-2">
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
                                <div class="float-right mr-5 self-start">
                                    <x-savebutton type="submit" class="mt-5">
                                        Update
                                    </x-savebutton>
                                </div>
                            </div>
                            <div class="mx-5 mt-3 pb-10">
                                <p class="font-bold text-xl leading-none">Detail</p>
                                <hr class="border border-5 border-black border-solid">
                                <div class="mt-1 space-y-1.5">
                                    <div class="grid grid-cols-1">
                                        <p class="text-lg">Birth Date</p>
                                        <x-editinput name="birth_date" id="birth_date" type="date" value="{{ $details->user->birth_date }}"></x-editinput>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <p class="text-lg">Sex</p>
                                        <x-editinput name="sex" id="sex" type="text" value="{{ $details->user->sex }}"></x-editinput>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <p class="text-lg">Address</p>
                                        <textarea class="rounded-lg" name="address" id="address" cols="30" rows="2">{{$details->user->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
