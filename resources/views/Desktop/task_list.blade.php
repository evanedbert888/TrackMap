<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Task List")}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    @if (count($goals) > 0)
                    <h1 class="text-2xl font-bold">Tasked Status</h1>
                    <div class="border border-black border-5 rounded rounded-full h-1 bg-black"></div>
                    <div class="flex mx-auto justify-center">
                        <table class="w-full table-auto mt-4">
                            <thead>
                                <tr class="text-center text-lg">
                                    <th> No </th>
                                    <th class="text-left"> Employee Name </th>
                                    <th class="text-left"> Company Name </th>
                                    <th class="text-left"> Tasked By </th>
                                    <th> Status </th>
                                    <th> Tasked Date </th>
                                    <th> Finished Date </th>
                                </tr>
                            </thead>
                            <tbody class="text-center text-lg">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($goals as $goal)
                                    <tr class="bg-red-100 border border-white border-b-4 border-t-0 border-r-0 border-l-0">
                                        <td> {{ $i++ }} </td>
                                        <td class="text-left"> {{ $goal->employee->user->name }} </td>
                                        <td class="text-left"> {{ $goal->company->company_name }} </td>
                                        <td class="text-left"> {{ $goal->user->name }} </td>
                                        <td> {{ $goal->status }} </td>
                                            <td>{{ $goal->created_at }}</td>
                                        @if ($goal->created_at == $goal->updated_at)
                                            <td>{{ __("-") }}</td>
                                        @else
                                            <td>{{ $goal->updated_at }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$goals->links()}}
                    @else
                        <p class="font-bold text-lg">Nothing Tasked</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
