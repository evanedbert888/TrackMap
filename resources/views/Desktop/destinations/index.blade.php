<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Destination List') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="grid grid-cols-3 text-center pb-4 font-semibold text-lg">
                            <p class="col-start-2 col-end-3 justify-self-center self-center"> List of Destinations </p>
                            <a class="justify-self-end" href="{{route('destinations.create')}}">
                                <x-button>Add New Destination</x-button>
                            </a>
                        </div>
                        @foreach($lists as $list)
                            <div class="p-5 bg-green-300 border border-white-200 mb-5 sm:rounded-lg">
                                <ul>
                                    <li class="flex">
                                        @if($list->image == null)
                                            <img class="inline-block h-20 w-20 rounded-full ring-2 ring white object-cover" src="{{URL::to('/img/company.png')}}">
                                        @else
                                            <img class="inline-block h-20 w-20 rounded-full ring-2 ring white object-cover" src="{{url('storage/'.$list->image)}}">
                                        @endif
                                        <div class="w-full ml-5 mt-3">
                                            <div>
                                                <h6 class="font-bold text-2xl">{{ $list->destination_name }}</h6>
                                            </div>
                                            <div class="text-sm">
                                                <h2>{{ $list->address }}</h2>
                                            </div>
                                        </div>
                                        <div class="mt-6 ml-5">
                                            <a href="{{route('destinations.show',['destination'=>$list->id])}}">
                                                <x-button>Detail</x-button>
                                            </a>
                                        </div>
                                        <div class="mt-6 ml-5">
                                            <form action="{{route('destinations.destroy',['destination'=>$list->id])}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <x-delbutton type="button" onclick="showModal()">Delete</x-delbutton>
                                                <div class="fixed z-10 inset-0 overflow-y-auto invisible opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
                                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hiddenModal()"></div>

                                                        <!-- This element is to trick the browser into centering the modal contents. -->
                                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                            <div class="sm:flex sm:items-start">
                                                                <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                                    <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                                                                        Do you want to delete this destination ?
                                                                    </h3>
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
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                        {{$lists->links()}}
                    </div>
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

