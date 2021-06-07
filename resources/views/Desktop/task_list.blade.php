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
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-center text-base">
                                <th> No </th>
                                <th> Employee Name </th>
                                <th> Company Name </th>
                                <th> Tasked By </th>
                                <th> Status </th>
                                <th> Tasked Date </th>
                                <th> Finished Date </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($goals as $goal)
                                <tr>
                                    <td> {{ $i++ }} </td>
                                    <td> {{ $goal->employee->user->name }} </td>
                                    <td> {{ $goal->company->company_name }} </td>
                                    <td> {{ $goal->user->name }} </td>
                                    <td> {{ $goal->status }} </td>
                                    @php
                                        $created = explode(' ',$goal->created_at);
                                        $updated = explode(' ',$goal->updated_at);
                                    @endphp
                                        <td>{{ $created[0] }}</td>
                                    @if ($created == $updated)
                                        <td>{{ __("-") }}</td>
                                    @else
                                        <td>{{ $updated[0] }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
