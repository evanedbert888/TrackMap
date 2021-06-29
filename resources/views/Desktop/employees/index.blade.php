<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach ($lists as $list)
                        <div class="p-5 bg-blue-300 border border-white-200 mb-5 sm:rounded-lg">
                            <ul>
                                <li class="flex items-center">
                                    @if($list->user->image == null)
                                        <img class="inline-block h-20 w-20 rounded-full ring-2 ring white object-cover" src="{{URL::to('/img/Profile.png')}}">
                                    @else
                                        <img class="inline-block h-20 w-20 rounded-full ring-2 ring white object-cover" src="{{url('storage/'.$list->user->image)}}">
                                    @endif
                                    <div class="w-full ml-5">
                                        <div>
                                            <h6 class="font-bold text-2xl">{{ $list->user->name }}</h6>
                                        </div>
                                        <div class="text-md">
                                            <h3>{{ $list->role->role_name }}</h3>
                                        </div>
                                        <div class="text-sm">
                                            <h2>{{ $list->user->address }}</h2>
                                        </div>
                                    </div>
                                    <div class="ml-5">
                                        <a href="{{ route('employees.show',['employee'=>$list->id]) }}">
                                            <x-button>Detail</x-button>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                    {{ $lists->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
