<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Categories') }}
        </h2>
    </x-slot>

    <div class="py-0 md:py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">

                    @if(session('message'))
                        <x-div-session class="bg-green-200" id="div-session">
                            <p>{{session('message')}}</p>
                            <x-close-button id="hideModal"></x-close-button>
                        </x-div-session>
                    @endif

                    <div class="w-full">
                        <h1 class="text-2xl font-bold">Business Categories</h1>
                        <div class="border border-black border-5 rounded rounded-full h-1 bg-black"></div>
                        <div class="flex mx-auto justify-center">
                            <table class="w-full table-auto mt-4">
                                <thead>
                                <tr class="text-center text-lg">
                                    <th> No </th>
                                    <th class="text-left"> Name </th>
                                    <th colspan="2"> Action </th>
                                </tr>
                                </thead>
                                <tbody class="text-center text-lg">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($categories as $category)
                                    <tr class="bg-red-100 border border-white border-b-4 border-t-0 border-r-0 border-l-0">
                                        <td> {{ $i++ }} </td>
                                        <td class="text-left"> {{$category->name}} </td>
                                        <td>
                                            @can('edit business-category')
                                                <a href="{{route('business-categories.edit',[$category->id])}}">
                                                    <x-button type="button"> Edit </x-button>
                                                </a>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('destroy business-category')
                                                <form action="{{route('business-categories.destroy',['businessCategory'=>$category->id])}}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <div>
                                                        <x-delbutton value="{{ $category->id }}" onclick="showModal(this.value)"> Delete </x-delbutton>
                                                    </div>
                                                    <div class="fixed z-10 inset-0 overflow-y-auto invisible opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal{{ $category->id }}">
                                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hiddenModal('{{ $category->id }}')"></div>

                                                            <!-- This element is to trick the browser into centering the modal contents. -->
                                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                <div class="sm:flex sm:items-start">
                                                                    <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                            <div class="sm:flex sm:items-start">
                                                                                <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                                                    <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                                                                                        Do you want to delete this category ?
                                                                                    </h3>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-400 text-base font-medium text-black hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                Yes
                                                                            </button>
                                                                            <button type="button" onclick="hiddenModal('{{ $category->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$categories->links()}}
                    </div>
                    @can('create business-category')
                        <div class="flex justify-end my-2">
                            <a href="{{route('business-categories.create')}}">
                                <x-button type="button">Create new category</x-button>
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function showModal(id) {
        document.getElementById('modal'+id).classList.remove('invisible');
        document.getElementById('modal'+id).classList.remove('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
        document.getElementById('modal'+id).style.transitionTimingFunction = "ease-out";
        document.getElementById('modal'+id).style.transitionDuration = "300ms";
        document.getElementById('modal'+id).classList.add('opacity-100','translate-y-0','sm:scale-100');
    }
    function hiddenModal(id) {
        document.getElementById('modal'+id).classList.remove('opacity-100','translate-y-0','sm:scale-100');
        document.getElementById('modal'+id).style.transitionTimingFunction = "ease-in";
        document.getElementById('modal'+id).style.transitionDuration = "200ms";
        document.getElementById('modal'+id).classList.add('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
        document.getElementById('modal'+id).classList.add('invisible');
    }

    $(document).ready(function(){
        $("#hideModal").click(function(){
            $("#div-session").hide();
        });
    });
</script>
