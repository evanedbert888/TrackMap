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
            document.getElementById('divEmployee').classList.remove('hidden');
            getEmployeeByRole(role);
        }

        function getEmployeeByRole(role) {
            $.ajax({
                url:'{{ route('tasks.show_employees') }}'+"/"+role,
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
        function showDestinations() {
            var business = document.getElementById('business').value;
            document.getElementById('divDestination').classList.remove('hidden');
            getDestinationByRole(business);
        }

        function getDestinationByRole(business) {
            $.ajax({
                url:'{{ route('tasks.show_destinations') }}'+"/"+business,
                method:"get",
                success:function(data){
                    setDestinationDataToDestinationOptions(data);
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function setDestinationDataToDestinationOptions(destination) {
            var data = ""
            data = data + "<option class='hidden'></option>";
            $.each(destination, function(key, value){
                data = data + "<option class='bg-gray-200' value='"+value.id+","+value.destination_name+"'>"+value.destination_name+"</option>"
            })
            $('#destination').html(data);
        }

        function checkToEnableAddButton() {
            if(document.getElementById('employee').value != "" && document.getElementById('destination').value != ""){
                document.getElementById('butadd').disabled = false;
            }
        }

        function selectedEmployee() {
            document.getElementById('showEmployee').classList.remove("hidden");
            var employee = document.getElementById('employee').value;
            var splitedEmployee = employee.split(",");
            document.getElementById('employeeName').textContent = splitedEmployee[1];
            checkToEnableAddButton();
        }

        function selectedDestination() {
            document.getElementById('showDestination').classList.remove("hidden");
            var destination = document.getElementById('destination').value;
            var splitedDestination = destination.split(",");
            document.getElementById('destinationName').textContent = splitedDestination[1];
            checkToEnableAddButton();
        }

        function check() {
            $.ajax({
                url:'{{ route('tasks.show_task') }}',
                method:'get',
                success:function(data){
                    if(data.length > 0) {
                        document.getElementById('task').classList.remove('hidden');
                    }
                    else {
                        document.getElementById('task').classList.add('hidden');
                    }
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function deleteTask(temp){
            $.ajax({
                {{--url:'{{ route('tasks.destroy') }}'+"/"+{temp},--}}
                method:"get",
                success:function(data){
                    check();
                    showTask();
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function addNewColumn(task) {
            var i = 0;
            var data = ""
            $.each(task, function(key, value){
                data = data + "<tr class='text-lg bg-red-100 text-lg border border-white border-b-4 border-t-0 border-r-0 border-l-0'>";
                data = data + "<td>"+(i+1)+"</td>";
                data = data + "<td class='text-left'>"+value.employee_name+"</td>";
                data = data + "<td class='text-left'>"+value.destination_name+"</td>";
                data = data + "<td>";
                data = data + "<button type='submit' value='"+value+"' onclick='deleteTask(this.value)' class='inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150'>DELETE</button>";
                data = data + "</td>";
                data = data + "</tr>";
                i++;
            })
            $('#tableTask').html(data);
        }

        function showTask() {
            $.ajax({
                url:'{{ route('tasks.show_task') }}',
                method:'get',
                success:function(data){
                    addNewColumn(data);
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function storeTask(employee, destination) {
            $.ajax({
                url:'{{ route('tasks.store_task') }}'+'/'+employee+'/'+destination,
                method:"get",
                success:function(data){
                    check();
                    showTask();
                },
                error:function(err){
                    console.log(employee+','+destination);
                }
            })
        }

        function addTask() {
            var employee = document.getElementById('employee').value;
            var splitedEmployee = employee.split(",");
            var destination = document.getElementById('destination').value;
            var splitedDestination = destination.split(",");
            storeTask(splitedEmployee[0],splitedDestination[0]);

            document.getElementById('showDestination').classList.add("hidden");
            document.getElementById('showEmployee').classList.add("hidden");
            document.getElementById('divEmployee').classList.add("hidden");
            document.getElementById('divDestination').classList.add("hidden");
            document.getElementById('butadd').disabled = true;
            document.getElementById('save').disabled = false;
            document.getElementById('role').value = "";
            document.getElementById('business').value = "";
            document.getElementById('employee').value = "";
            document.getElementById('destination').value = "";
        }

        $(document).ready(function() {
            check();
            showTask();
        })

    </script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="w-full">
                        <h1 class="text-2xl font-bold">Employee & Destination</h1>
                        <div class="border border-black border-5 border-b rounded rounded-full h-1 bg-black"></div>
                        <div class="flex mx-auto justify-center mt-5">
                            <div class="mx-auto mb-2 font-bold">
                                <form>
                                    <p class="text-lg"> Employee's Role </p>
                                    <select name="role" id="role" class="w-80 block mt-1 rounded-md" onchange="showEmployees()">
                                        <option class="hidden"></option>
                                        @foreach ($roles as $role)
                                            <option class="bg-gray-200" value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="mx-auto mb-2 font-bold">
                                <p class="text-lg"> Destination's Business </p>
                                <select name="business" id="business" class="w-80 block mt-1 rounded-md" onchange="showDestinations()">
                                    <option class="hidden"></option>
                                    @foreach ($businesses as $business)
                                        <option class="bg-gray-200" value="{{ $business->id }}">{{ $business->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex w-full">
                            <div class="flex w-1/2 justify-center">
                                <div class="mx-auto mb-2 font-bold hidden" id="divEmployee">
                                    <p class="text-lg"> Employee's Name </p>
                                    <select name="employee" id="employee" class="w-80 block mt-1 rounded-md" onchange="selectedEmployee()"></select>
                                </div>
                            </div>
                            <div class="flex w-1/2 justify-center">
                                <div class="mx-auto mb-2 font-bold hidden" id="divDestination">
                                    <p class="text-lg"> Destination's Name </p>
                                    <select name="destination" id="destination" class="w-80 block mt-1 rounded-md" onchange="selectedDestination()"></select>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex">
                            <div class="flex w-1/2 justify-center">
                                <div class="container p-3 mx-auto w-80 hidden rounded-md bg-blue-50" id="showEmployee">
                                    <div class="flex justify-center items-center p-0">
                                        <img class="inline-block h-16 w-16" src="{{URL::to('/img/Profile.png')}}" alt="">
                                        <div>
                                            <p class="ml-4" id="employeeName"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex w-1/2 justify-center">
                                <div class="container p-3 mx-auto w-80 hidden rounded-md bg-blue-50" id="showDestination">
                                    <div class="flex justify-center items-center p-0">
                                        <img class="inline-block h-16 w-16" src="{{URL::to('/img/company.png')}}" alt="">
                                        <div>
                                            <p class="ml-4" id="destinationName"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex mx-32 px-1.5 justify-end mt-2">
                            <x-button onclick="addTask()" id="butadd" name="butadd" disabled>
                                {{__("Add")}}
                            </x-button>
                        </div>
                    </div>
                    <div class="w-full mt-3 hidden" id="task">
                        <h1 class="text-2xl font-bold">Task</h1>
                        <div class="border border-black border-5 border-b rounded rounded-full h-1 bg-black"></div>
                        <div class="flex mx-auto justify-center mt-5">
                            <table class="w-full table-auto">
                                <thead>
                                <tr class="text-center text-lg">
                                    <th> No </th>
                                    <th class="text-left"> Employee Name </th>
                                    <th class="text-left"> Destination Name </th>
                                    <th> Action </th>
                                </tr>
                                </thead>
                                <tbody class="text-center" id="tableTask"></tbody>
                            </table>
                        </div>
                        <div class="mt-2 flex justify-end">
                            <form action="{{route('tasks.store')}}" method="POST">
                                @csrf
                                <x-button id="save" disabled>
                                    {{__("Save")}}
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
