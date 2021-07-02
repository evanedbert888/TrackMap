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
                    <img class="inline-block h-52 w-52 rounded-full ring-2 ring white object-cover mt-32 ml-10" src="{{url($details->image)}}">
                </div>
                <div class="p-6 pt-1 bg-white border-b border-gray-200 ">
                    @can('update user')
                        <form method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="float-right mr-5 mt-5">
                                <x-savebutton type="button" onclick="showModal()">
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
                            <div class="fixed z-10 inset-0 overflow-y-auto invisible opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hiddenModal()"></div>

                                    <!-- This element is to trick the browser into centering the modal contents. -->
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                            <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                                                                Do you want to update your profile ?
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-400 text-base font-medium text-black hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Yes
                                                    </button>
                                                    <button type="button" onclick="hiddenModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        No
                                                    </button>
                                                </div>
                                            </div>
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

<script>
    function showModal() {
        document.getElementById('modal').classList.remove('invisible');
        document.getElementById('modal').classList.remove('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
        document.getElementById('modal').style.transitionTimingFunction = "ease-out";
        document.getElementById('modal').style.transitionDuration = "300ms";
        document.getElementById('modal').classList.add('opacity-100','translate-y-0','sm:scale-100');
    }
    function hiddenModal() {
        document.getElementById('modal').classList.remove('opacity-100','translate-y-0','sm:scale-100');
        document.getElementById('modal').style.transitionTimingFunction = "ease-in";
        document.getElementById('modal').style.transitionDuration = "200ms";
        document.getElementById('modal').classList.add('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
        document.getElementById('modal').classList.add('invisible');
    }
</script>
