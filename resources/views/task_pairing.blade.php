<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Task Pairing")}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="text-center pb-2 font-semibold text-lg">
                        <p> Task Pairing </p>
                    </div>
                    <div class="bg-green-300 p-3 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mx-auto mb-2 font-bold">
                                <p> Employee's Role </p>
                                <select name="role" id="role" class="w-36">
                                    <option value="">none</option>
                                    <option value="salesman">Salesman</option>
                                    <option value="courier">Courier</option>
                                </select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Company's Business </p>
                                <select name="business" id="business" class="w-36">
                                    <option value="">none</option>
                                    @foreach($businesses as $business)
                                        <option value="{{$business}}">{{$business}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Employee's Name </p>
                                <select name="employee" id="employee" class="w-36">
                                    <option value="">none</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->name}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Company's Name </p>
                                <select name="company" id="company" class="w-36">
                                    <option value="">none</option>
                                    @foreach($companies as $company)
                                        <option class="truncate w-10" value="{{$company->company_name}}">{{$company->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="container p-3 mx-auto w-60 rounded-md bg-blue-300">
                                <div class="flex justify-center items-center p-0">
                                    <img class="inline-block h-16 w-16" src="https://static.wikia.nocookie.net/gensin-impact/images/4/47/Character_Traveler_%28Male%29_Portrait.png/revision/latest?cb=20200915142015" alt="">
                                    <div>
                                        <p class="ml-4"> Employee's Name </p>
                                    </div>
                                </div>
                            </div>
                            <div class="container p-3 mx-auto w-60 rounded-md bg-blue-300">
                                <div class="flex justify-center items-center p-0">
                                    <img class="inline-block h-16 w-16" src="https://static.wikia.nocookie.net/gensin-impact/images/4/47/Character_Traveler_%28Male%29_Portrait.png/revision/latest?cb=20200915142015" alt="">
                                    <div>
                                        <p class="ml-4"> Company's Name </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0 ml-auto mr-20 col-span-2">
                                <x-button>
                                    {{__("Add")}}
                                </x-button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-500 rounded-lg mt-3 p-3">
                        <div class="grid grid-cols-1">
                            <div class="flex mx-auto justify-center">
                                <table class="table-auto border-separate border border-black border-3">
                                    <caption class="font-semibold"> Pairing Table </caption>
                                    <thead>
                                        <tr class="text-center text-xl">
                                            <th class="border border-black border-3"> ID </th>
                                            <th class="border border-black border-3"> Employee </th>
                                            <th class="border border-black border-3"> Company </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-black border-3"></td>
                                            <td class="border border-black border-3"></td>
                                            <td class="border border-black border-3"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-0 ml-auto mr-20">
                                <x-button>
                                    {{__("Save")}}
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
