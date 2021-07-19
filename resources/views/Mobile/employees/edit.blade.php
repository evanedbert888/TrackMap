<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$details->user->name}}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="object-cover bg-cover h-40 w-full object-top bg-no-repeat flex md:h-60" style="background-image: url('{{ URL::to('/img/blue-copy-space-digital-background_23-2148821698.jpg') }}')">
                    <img class="inline-block h-32 w-32 rounded-full ring-2 ring white object-cover mt-24 mx-auto md:h-52 md:w-52 md:mt-32 md:ml-10" src="{{url($details->user->image)}}">
                </div>
                <div class="p-3 bg-white border-b border-gray-200 md:p-6">
                    @can('mobile update profile')
                        <form method="POST" action="{{ route('mobile.users.update',['employee'=>$details->id]) }}" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="mx-2">
                                <div class="md:mx-0">
                                    <div class="mt-16 md:ml-60 md:mt-0">
                                        <x-savebutton type="submit" class="float-right mt-2 md:mt-0">
                                            Update
                                        </x-savebutton>
                                    </div>
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
                                <div class="mt-3 pb-10">
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
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
