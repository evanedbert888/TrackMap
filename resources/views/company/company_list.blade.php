<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company List') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="text-center pb-4 font-semibold text-lg">
                            <p> List of Destinations </p>
                        </div>
                            @foreach($lists as $list)
                                    <div class="container mx-auto bg-green-400 rounded-lg mb-4 p-4 w-3/5 h-2/3">
                                        <table>
                                            <tr>
                                                <span class="flex">
                                                    <td class = "ml-0 pr-20">
                                                        <p class="p-1"> {{$list->company_name}} </p>
                                                        <div class="w-96">
                                                            <p class="p-1 text-justify"> {{$list->address}} </p>
                                                        </div>
                                                    </td>
                                                </span>
                                                <span>
                                                    <td class="p-4">
                                                        <a href="{{route('company_detail',['name'=>$list->company_name])}}">
                                                            <button class="bg-yellow-500 p-3 my-2 rounded-lg hover:bg-yellow-400" type="button">Detail</button>
                                                        </a>
                                                    </td>
                                                    <td class="p-4">
                                                        <form action="{{route('company_delete',['id'=>$list->id])}}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="bg-red-500 p-3 my-2 rounded-lg hover:bg-red-400" type="submit">Delete</button>
                                                        </form>
                                                    </td>
                                                </span>
                                            </tr>
                                        </table>
                                    </div>
                            @endforeach
                        {{$lists->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

