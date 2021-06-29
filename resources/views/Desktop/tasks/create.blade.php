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
                        document.getElementById('save').disabled = false;
                    }
                    else {
                        document.getElementById('task').classList.add('hidden');
                        document.getElementById('save').disabled = true;
                    }
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function deleteTask(temp){
            var url = '{{ route('tasks.destroy') }}'+'/'+temp;
            $.ajax({
                url:url,
                method:"delete",
                data:{
                    "_token": "{{ csrf_token() }}"
                },
                success:function(data){
                    console.log(data.success);
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
                data = data + "<tr class='text-lg bg-red-100 border border-white border-b-4 border-t-0 border-r-0 border-l-0'>";
                data = data + "<td>"+(i+1)+"</td>";
                data = data + "<td class='text-left'>"+value.employee_name+"</td>";
                data = data + "<td class='text-left'>"+value.destination_name+"</td>";
                data = data + "<td>";
                data = data + "<button type='submit' value='"+value.id+"' onclick='deleteTask(this.value)' class='inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150'>DELETE</button>";
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
                    console.log(err);
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
    
        function showModal() {
            schedule();
            searchDestination(' ');
            document.getElementById('search').value = "";
            document.getElementById('scheduleSalesman').value = "";
            document.getElementById('addSchedule').disabled = true;
            document.getElementById('modal').classList.remove('invisible');
            document.getElementById('modal').classList.remove('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal').style.transitionTimingFunction = "ease-out";
            document.getElementById('modal').style.transitionDuration = "200ms";
            document.getElementById('modal').classList.add('opacity-100','translate-y-0','sm:scale-100');
        }

        function hiddenModal() {
            document.getElementById('modal').classList.remove('opacity-100','translate-y-0','sm:scale-100');
            document.getElementById('modal').style.transitionTimingFunction = "ease-in";
            document.getElementById('modal').style.transitionDuration = "100ms";
            document.getElementById('modal').classList.add('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal').classList.add('invisible');
        }

        function schedule() {
            $.ajax({
                url:'{{ route('schedule.index') }}',
                method:'get',
                success:function(data){
                    scheduletable(data);
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function scheduletable(schedule) {
            var i = 0;
            var data = ""
            $.each(schedule, function(key, value){
                data = data + "<tr class='border border-white border-b-4 border-t-0 border-r-0 border-l-0'>";
                data = data + "<td>"+(i+1)+"</td>";
                data = data + "<td class='text-left'>"+value.employee_name+"</td>";
                data = data + "<td class='text-left'>"+value.destination_name+"</td>";
                data = data + "<td>";
                data = data + "<button type='submit' value='"+value.id+"' onclick='deleteSchedule(this.value)' class='inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150'>DELETE</button>";
                data = data + "</td>";
                data = data + "</tr>";
                i++;
            })
            $('#tablesearch').html(data);
        }

        function searchDestination(word) {
            $.ajax({
                url:'{{ route('schedule.search') }}',
                method:"get",
                data: {"search":word},
                success:function(data){
                    addNewOption(data);
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function addNewOption(destination) {
            var data = ""
            if(destination.length <= 0) {
                document.getElementById('scheduleDestination').disabled = true;
                data = data + "<option hidden>Destination Not Found</option>";
            }
            else {
                data = data + "<option hidden></option>";
                document.getElementById('scheduleDestination').disabled = false;
                $.each(destination, function(key, value) {
                    data = data + "<option value='"+value.id+"'>"+value.destination_name+"</option>";
                })
            }
            $('#scheduleDestination').html(data);
        }

        function checkschedule() {
            var sales = document.getElementById('scheduleSalesman').value;
            var destination = document.getElementById('scheduleDestination').value;

            if(sales != "" && destination != ""){
                document.getElementById('addSchedule').disabled = false;
            }
        }

        function salesman() {
            checkschedule();
        }
        
        function destination() {
            checkschedule();
        }

        function addSchedule() {
            var salesman = document.getElementById('scheduleSalesman').value;
            var destination = document.getElementById('scheduleDestination').value;

            $.ajax({
                url:"{{ route('schedule.store') }}"+"/"+salesman+"/"+destination,
                method:"post",
                data : {
                    "_token": "{{ csrf_token() }}"
                },
                success:function(data) {
                    schedule();
                    document.getElementById('search').value = "";
                    searchDestination(' ');
                    document.getElementById('scheduleSalesman').value = "";
                    document.getElementById('addSchedule').disabled = true;
                },
                error:function(err) {
                    console.log(err);
                }
            })
        }

        function deleteSchedule(id) {
            $.ajax({
                url:'{{ route('schedule.destroy') }}'+"/"+id,
                method:"delete",
                data : {
                    "_token": "{{ csrf_token() }}"
                },
                success:function(data){
                    console.log(data.success);
                    schedule();
                },
                error:function(err){
                    console.log(err);
                }
            })
        }

        function useSchedule() {
            $.ajax({
                url:'{{ route('schedule.use') }}',
                method:'get',
                success:function(data){
                    check();
                    showTask();
                },
                error:function(err){
                    console.log(err);
                }
            })
        }
    </script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="w-full">
                        <div class="w-full flex justify-end">
                            <x-editbutton onclick="showModal()">Schedule</x-editbutton>
                        </div>
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
                            <x-savebutton onclick="" class="mr-5" onclick="useSchedule()">Use Schedule</x-savebutton>
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
    <div class="fixed z-10 inset-0 overflow-y-auto invisible opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hiddenModal()"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-y shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-0 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                            <div class="mt-3 w-full inline-flex items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 w-1/2" id="modal-title">
                                    Schedule
                                </h3>
                                <div class="w-full flex justify-end">
                                    <x-input-search id="search" onkeyup="searchDestination(this.value)" class="search block w-1/2" name="search"/>
                                </div>
                            </div>
                            <div class="mt-3 w-full inline-flex items-center">
                                <div class="w-full mr-1">
                                    <select name="scheduleSalesman" id="scheduleSalesman" onchange="salesman()" class="w-full block rounded-md">
                                        <option class="hidden" value=""></option>
                                        @foreach ($salesmans as $salesman)
                                            <option value="{{ $salesman->id }}">{{ $salesman->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full ml-1">
                                    <select name="scheduleDestination" id="scheduleDestination" onchange="destination()" class="w-full block rounded-md" disabled></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end w-full">
                        <x-button id="addSchedule" name="addSchedule" onclick="addSchedule()" disabled>
                            {{__("Add")}}
                        </x-button>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex">
                    <table class="w-full table-auto text-center">
                        <thead>
                            <th>No</th>
                            <th class="text-left">Salesman</th>
                            <th class="text-left">Destination</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="tablesearch">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
