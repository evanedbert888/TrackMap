<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("Task Pairing")}}
        </h2>
    </x-slot>
    <script>
        // Employees
        function showEmployees() {
            var role = document.getElementById('role').value;
            document.getElementById('employee').disabled = false;
            getEmployeeByRole(role);
        }

        function getEmployeeByRole(role) {
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

        function setEmployeeDataToEmployeeOptions(employees) {
            var data = ""
            data = data + "<option class='hidden'></option>";
            $.each(employees, function(key, value){
                data = data + "<option class='bg-gray-200' value='"+value.id+","+value.name+"'>"+value.name+"</option>"
            })
            $('#employee').html(data);
        }

        // Companies
        function showCompanies() {
            var business = document.getElementById('business').value;
            document.getElementById('company').disabled = false;
            getCompanyByRole(business);
        }

        function getCompanyByRole(business) {
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

        function setCompanyDataToCompanyOptions(company) {
            var data = ""
            data = data + "<option class='hidden'></option>";
            $.each(company, function(key, value){
                data = data + "<option class='bg-gray-200' value='"+value.id+","+value.company_name+"'>"+value.company_name+"</option>"
            })
            $('#company').html(data);
        }

        function checkToEnableAddButton() {
            if(document.getElementById('employee').value != "" && document.getElementById('company').value != ""){
                document.getElementById('butadd').disabled = false;
            }
        }

        function selectedEmployee() {
            document.getElementById('showEmployee').classList.remove("invisible");
            var employee = document.getElementById('employee').value;
            var splitedEmployee = employee.split(",");
            document.getElementById('employeeName').textContent = splitedEmployee[1];
            checkToEnableAddButton();
        }

        function selectedCompany() {
            document.getElementById('showCompany').classList.remove("invisible");
            var company = document.getElementById('company').value;
            var splitedCompany = company.split(",");
            document.getElementById('companyName').textContent = splitedCompany[1];
            checkToEnableAddButton();
        }

        function addNewColumn(task) { // add table !error
            var i = 0;
            var data = ""
            $.each(task, function(key, value){
                data = data + "<tr>";
                data = data + "<td class='border border-black border-3'>"+(i+1)+"</td>";
                data = data + "<td class='border border-black border-3'>" + "</td>";
                data = data + "<td class='border border-black border-3'>" + "</td>" + {{$temps->company->company_name}};
                data = data + "<td class='border border-black border-3'>"+"<form action='{{route('temp_delete',['id'=>$temps["+i+"]->id])}}' method='POST'>@method('DELETE')@csrf<x-delbutton>Delete</x-delbutton></form></td>";
                data = data + "</tr>";
                i++;
            })
            $('#tableTask').html(data);
        }

        function showTask() {
            $.ajax({
                url:'{{ route('show_task') }}',
                method:'get',
                success:function(data){
                    addNewColumn(data);
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function storeTask(employee, company) {
            $.ajax({
                url:'{{ route('store_task') }}'+'/'+employee+'/'+company,
                method:"get",
                success:function(data){
                    showTask();
                },
                error:function(err){
                    console.log(employee+','+company);
                }
            })
        }

        function addTask() {
            var employee = document.getElementById('employee').value;
            var splitedEmployee = employee.split(",");
            var company = document.getElementById('company').value;
            var splitedCompany = company.split(",");
            storeTask(splitedEmployee[0],splitedCompany[0]);

            document.getElementById('showCompany').classList.add("invisible");
            document.getElementById('showEmployee').classList.add("invisible");
            document.getElementById('employee').disabled = true;
            document.getElementById('company').disabled = true;
            document.getElementById('butadd').disabled = true;
            document.getElementById('role').value = "";
            document.getElementById('business').value = "";
            document.getElementById('employee').value = "";
            document.getElementById('company').value = "";
        }

    </script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
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
                                <select name="employee" id="employee" class="w-80 block mt-1 rounded-md" onchange="selectedEmployee()" disabled></select>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p> Company's Name </p>
                                <select name="company" id="company" class="w-80 block mt-1 rounded-md" onchange="selectedCompany()" disabled></select>
                            </div>
                            <div class="container p-3 mx-auto w-80 rounded-md bg-blue-300 invisible" id="showEmployee">
                                <div class="flex justify-center items-center p-0">
                                    <img class="inline-block h-16 w-16" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                    <div>
                                        <p class="ml-4" id="employeeName"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="container p-3 mx-auto w-80 rounded-md bg-blue-300 invisible" id="showCompany">
                                <div class="flex justify-center items-center p-0">
                                    <img class="inline-block h-16 w-16" src="http://localhost/Project/TrackMap/resources/views/components/img/jasa_pembuatan_desain_logo_perusahaan_murah_tidak_murahan_1157447_1429123045.jpg" alt="">
                                    <div>
                                        <p class="ml-4" id="companyName"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0 ml-auto mr-32 col-span-2">
                                <x-button onclick="addTask()" id="butadd" name="butadd" disabled>
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
                                    <tbody class="text-center" id="tableTask"></tbody>
                                </table>
                            </div>
                            <div class="mt-2 flex justify-end">
                                <form action="{{route('task_insert')}}" method="POST">
                                    @csrf
                                    <x-button id="save">
                                        {{__("Save")}}
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
