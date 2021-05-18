<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Task Pairing")}}
        </h2>
    </x-slot>
    <script>
        // Employees
        function showEmployees(){
            var role = document.getElementById('role').value;
            document.getElementById('employee').disabled = false;
            getEmployeeByRole(role);
        }

        function getEmployeeByRole(role){
            $.ajax({
                url:'{{ route('show_employees') }}'+"/"+role,
                method:"get",
                success:function(data){
                    setEmployeeDataToEmployeeOptions(data);
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function setEmployeeDataToEmployeeOptions(employees){
            var data = ""
            data = data + "<option class='hidden'></option>";
            $.each(employees, function(key, value){
                data = data + "<option class='bg-gray-200' value='"+value.id+"'>"+value.name+"</option>"
            })
            $('#employee').html(data);
        }

        // Companies
        function showCompanies(){
            var business = document.getElementById('business').value;
            document.getElementById('company').disabled = false;
            getCompanyByRole(business);
        }

        function getCompanyByRole(business){
            $.ajax({
                url:'{{ route('show_companies') }}'+"/"+business,
                method:"get",
                success:function(data){
                    setCompanyDataToCompanyOptions(data);
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function setCompanyDataToCompanyOptions(company){
            var data = ""
            data = data + "<option class='hidden'></option>";
            $.each(company, function(key, value){
                data = data + "<option class='bg-gray-200' value='"+value.id+"'>"+value.company_name+"</option>"
            })
            $('#company').html(data);
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
                                        @foreach ($roles as $role)
                                            <option class="bg-gray-200" value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Company's Business </p>
                                <select name="business" id="business" class="w-80 block mt-1 rounded-md" onchange="showCompanies()">
                                    <option class="hidden"></option>
                                    @foreach ($businesses as $business)
                                        <option class="bg-gray-200" value="{{ $business->id }}">{{ $business->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Employee's Name </p>
                                <select name="employee" id="employee" class="w-80 block mt-1 rounded-md" disabled></select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Company's Name </p>
                                <select name="company" id="company" class="w-80 block mt-1 rounded-md" disabled></select>
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
                                    <tbody class="text-center">
                                        @foreach($temps as $temp)
                                            <tr>
                                                <td class="border border-black border-3">{{$temp->id}}</td>
                                                <td class="border border-black border-3">{{$temp->employee->user->name}}</td>
                                                <td class="border border-black border-3">{{$temp->company->company_name}}</td>
                                                <td class="border border-black border-3">
                                                    <form action="#" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <x-delbutton>Delete</x-delbutton>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
