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
                            <ul class="">
                                <li class="flex">
                                    <img class="inline-block h-20 w-20 rounded-full ring-2 ring white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80">
                                    <div class="w-full ml-5 mt-3">
                                        <div class="">
                                            <h6 class="font-bold text-2xl">{{ $list->name }}</h6>
                                        </div>
                                        <div class="text-sm">
                                            <h2>{{ $list->address }}</h2>
                                        </div>
                                    </div>
                                    <div class="mt-6 ml-5">
                                        <a href="{{ route('employee_detail',['id'=>$list->id]) }}">
                                            <x-button>Detail</x-button>
                                        </a>
                                    </div>
                                    <div class="mt-6 ml-5">
                                        <form method="POST" action="{{ route('employee_delete',['id'=>$list->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <x-delbutton>Delete</x-delbutton>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
