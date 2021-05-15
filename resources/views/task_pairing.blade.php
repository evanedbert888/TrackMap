<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Task Pairing")}}
        </h2>
    </x-slot>
    <script>
        function showEmployees(){
            var role = document.getElementById('role').value;
            document.getElementById('employee').disabled = false;
            getEmployeebyRole(role)
        }

        function getEmployeebyRole(role){


            $.ajax({
                url:'{{ route('') }}',
                method:"get",
                success:function(data){
                        setEmployeeDataToEmployeeOptions(data)
                },
                error:function(err){

                }
            })
        }

        function setEmployeeDataToEmployeeOptions(employees){
                
        }
    </script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    {{-- <div class="text-center pb-2 font-semibold text-lg">
                        <p> Task Pairing </p>
                    </div> --}}
                    <div class="bg-green-200 p-3 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 mt-5">
                            <div class="mx-auto mb-2 font-bold">
                                <form>
                                    <p> Employee's Role </p>
                                    <select name="role" id="role" class="w-80 block mt-1 rounded-md" onchange="showEmployees()">
                                        <option class="hidden"></option>
                                        <option class="bg-gray-200" value="salesman">Salesman</option>
                                        <option class="bg-gray-200" value="courier">Courier</option>
                                    </select>
                                </form>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Company's Business </p>
                                <select name="business" id="business" class="w-80 block mt-1 rounded-md" onselect="">
                                    <option class="hidden"></option>
                                    <option class="bg-gray-200" value="Bank">Bank</option>
                                    <option class="bg-gray-200" value="Cafe">Cafe</option>
                                    <option class="bg-gray-200" value="Entertainment">Entertainment</option>
                                    <option class="bg-gray-200" value="Fashion">Fashion</option>
                                    <option class="bg-gray-200" value="Food">Food</option>
                                    <option class="bg-gray-200" value="Health">Health</option>
                                    <option class="bg-gray-200" value="Hotel">Hotel</option>
                                    <option class="bg-gray-200" value="Pastry">Pastry</option>
                                    <option class="bg-gray-200" value="Printing">Printing</option>
                                    <option class="bg-gray-200" value="Sports">Sports</option>
                                    <option class="bg-gray-200" value="Technology">Technology</option>
                                </select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Employee's Name </p>
                                <select name="employee" id="employee" class="w-80 block mt-1 rounded-md" disabled>
                                    <option class="hidden"></option>
                                    {{-- @foreach($employees as $employee)
                                        <option class="bg-gray-200" value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Company's Name </p>
                                <select name="company" id="company" class="w-80 block mt-1 rounded-md" disabled>
                                    <option class="hidden"></option>
                                    {{-- @foreach($companies as $company)
                                        <option class="bg-gray-200" value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="container p-3 mx-auto w-80 rounded-md bg-blue-300">
                                <div class="flex justify-center items-center p-0">
                                    {{-- <img class="inline-block h-16 w-16" src="https://static.wikia.nocookie.net/gensin-impact/images/4/47/Character_Traveler_%28Male%29_Portrait.png/revision/latest?cb=20200915142015" alt=""> --}}
                                    <div>
                                        <p class="ml-4"> Employee's Name </p>
                                    </div>
                                </div>
                            </div>
                            <div class="container p-3 mx-auto w-80 rounded-md bg-blue-300">
                                <div class="flex justify-center items-center p-0">
                                    {{-- <img class="inline-block h-16 w-16" src="https://static.wikia.nocookie.net/gensin-impact/images/4/47/Character_Traveler_%28Male%29_Portrait.png/revision/latest?cb=20200915142015" alt=""> --}}
                                    <div>
                                        <p class="ml-4"> Company's Name </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0 ml-auto mr-32 col-span-2">
                                <x-button>
                                    {{__("Add")}}
                                </x-button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-200 rounded-lg mt-3 p-3">
                        <div class="w-full">
                            <div class="flex mx-auto justify-center">
                                <table class="w-full table-auto border-separate border border-black border-3">
                                    <thead>
                                        <tr class="text-center text-base">
                                            <th class="border border-black border-3"> No </th>
                                            <th class="border border-black border-3"> Employee </th>
                                            <th class="border border-black border-3"> Company </th>
                                            <th class="border border-black border-3"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-black border-3"></td>
                                            <td class="border border-black border-3"></td>
                                            <td class="border border-black border-3"></td>
                                            <td class="border border-black border-3"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="mt-0 ml-auto mr-20">
                                <x-button>
                                    {{__("Save")}}
                                </x-button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
