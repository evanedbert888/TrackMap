<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("User")}}
        </h2>
    </x-slot>

    <script>
        var checked;
        $(function(e) {
            $("#chkbxAll").click(function() {
                $(".chkbx").prop('checked' ,$(this).prop('checked'));

                if ($('.chkbx:checked').length > 0) {
                    $(".role").prop('disabled', false);
                    $('#butverify').prop('disabled',false);
                }
                else {
                    $('#butverify').prop('disabled',true);
                    $(".role").prop('disabled', true);
                    $(".role").val('');
                }
            })
        });

        $(document).on('click', '.chkbx', function() {
            var id = $(this).attr('value');

            if ($('.chkbx').length === $('.chkbx:checked').length) {
                $('#chkbxAll').prop('checked', true);
            }
            else {
                $('#chkbxAll').prop('checked', false);
            }

            var checkBox = document.getElementById("chkbx"+id);
            if (checkBox.checked == true){
                $("#role"+id).prop('disabled', false);
            }
            else {
                $("#role"+id).prop('disabled', true);
                $("#role"+id).val('');
            }

            if ($('.chkbx:checked').length > 0) {
                $('#butverify').prop('disabled',false);
            }
            else {
                $('#butverify').prop('disabled',true);
            }
        })

        function verifyUser() {
            var listId = [];
            var listRole = [];
            var checked = 0;
            $.each($("input:checkbox[name=ids]:checked"),function(){
                var user_id = $(this).val();
                var role = document.getElementById('role'+user_id).value;
                if (role != ""){
                    listId.push(user_id);
                    listRole.push(role);
                }
                checked++;
            });

            if (listId.length > checked-1) {
                $.ajax({
                    url : '{{ route('update_status_user') }}',
                    type : 'POST',
                    data : {
                        _token:$("input[name=_token]").val(),
                        ids : listId,
                        roles : listRole
                    },
                    success:function(data){
                        location.reload();
                    },
                    error:function(err){
                        console.log(err);
                    }
                });
            }
            else {
                alert("Please Insert All Selection");
            }
        }

        function showModal() {
            document.getElementById('newRole').value = "";
            document.getElementById('modal').classList.remove('invisible');
            document.getElementById('modal').classList.remove('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal').style.transitionTimingFunction = "ease-out";
            document.getElementById('modal').style.transitionDuration = "300ms";
            document.getElementById('modal').classList.add('opacity-100','translate-y-0','sm:scale-100');
        }

        function hiddenModal() {
            document.getElementById('modal').classList.remove('opacity-100','translate-y-0','sm:scale-100');
            document.getElementById('modal').style.transitionTimingFunction = "ease-in";
            document.getElementById('modal').style.transitionDuration = "200ms";
            document.getElementById('modal').classList.add('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal').classList.add('invisible');
        }

        function showdelModal(id) {
            document.getElementById('modal'+id).classList.remove('invisible');
            document.getElementById('modal'+id).classList.remove('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal'+id).style.transitionTimingFunction = "ease-out";
            document.getElementById('modal'+id).style.transitionDuration = "300ms";
            document.getElementById('modal'+id).classList.add('opacity-100','translate-y-0','sm:scale-100');
        }

        function hiddendelModal(id) {
            document.getElementById('modal'+id).classList.remove('opacity-100','translate-y-0','sm:scale-100');
            document.getElementById('modal'+id).style.transitionTimingFunction = "ease-in";
            document.getElementById('modal'+id).style.transitionDuration = "200ms";
            document.getElementById('modal'+id).classList.add('opacity-0','translate-y-4','sm:translate-y-0','sm:scale-95');
            document.getElementById('modal'+id).classList.add('invisible');
        }
        
    </script>

    <div class="md:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="w-full">
                        @if (count($vdusers) == 0 && count($uvdusers) == 0)
                            <p class="font-bold text-center text-2xl">Employees are empty</p>
                        @endif
                        <div class="flex justify-end">
                            <x-button onclick="showModal()">Add Role</x-button>
                        </div>
                        @if (count($uvdusers) > 0)
                            <div class="unverify mb-8">
                                <h1 class="text-2xl font-bold">Unverified</h1>
                                <div class="border border-black border-5 rounded rounded-full h-1 bg-black"></div>
                                <div class="flex mx-auto justify-center">
                                    <table class="w-full table-auto mt-4">
                                        <thead>
                                        <tr class="text-center text-lg">
                                            <th><input type="checkbox" id="chkbxAll" class="rounded border-black text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></th>
                                            <th class="text-left"> Name </th>
                                            <th class="text-left hidden md:table"> Address </th>
                                            <th class="text-left"> Email </th>
                                            <th class="hidden md:table"> Birth Date </th>
                                            <th> Sex </th>
                                            <th> Role </th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center" id="unverified" name="unverified">
                                        @foreach($uvdusers as $user)
                                            <tr class="bg-red-100 text-lg border border-white border-b-4 border-t-0 border-r-0 border-l-0">
                                                <td>
                                                    <input value="{{ $user->id }}" type="checkbox" name="ids" id="chkbx{{ $user->id }}" class="chkbx rounded border-black text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                </td>
                                                <td class="text-left">{{ $user->name }}</td>
                                                <td class="text-left hidden md:table">{{ $user->address }}</td>
                                                <td class="text-left">{{ $user->email }}</td>
                                                <td class="hidden md:table">{{ $user->birth_date }}</td>
                                                <td>{{ $user->sex }}</td>
                                                <td>
                                                    <select name="role" id="role{{$user->id}}" class="rounded-md role" disabled>
                                                        <option class="hidden"></option>
                                                        <option value="admin">admin</option>
                                                        @foreach ($sections as $section)
                                                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex mt-2 item-center justify-end">
                                    <x-savebutton class="font-bold" id="butverify" onclick="verifyUser()" disabled>Verify</x-savebutton>
                                </div>
                            </div>
                        @else

                        @endif
                        @if (count($vdusers) > 0)
                            <div class="verified">
                                <h1 class="text-2xl font-bold">Verified</h1>
                                <div class="border border-black border-5 border-b rounded rounded-full h-1 bg-black"></div>
                                <div class="flex mx-auto justify-center">
                                    <table class="w-full table-auto mt-4">
                                        <thead>
                                        <tr class="text-center text-lg">
                                            <th> No </th>
                                            <th class="text-left"> Name </th>
                                            <th class="text-left hidden md:table"> Address </th>
                                            <th class="text-left"> Email </th>
                                            <th class="text-left hidden md:table"> Birth Date </th>
                                            <th> Sex </th>
                                            <th colspan="2"> Action </th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center" id="verified" name="verified">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($vdusers as $user)
                                            <tr class="bg-yellow-100 text-lg border border-white border-b-4 border-t-0 border-r-0 border-l-0">
                                                <td>{{ $i }}</td>
                                                <td class="text-left">{{ $user->name }}</td>
                                                <td class="text-left hidden md:table">{{ $user->address }}</td>
                                                <td class="text-left">{{ $user->email }}</td>
                                                <td class="text-left hidden md:table">{{ $user->birth_date }}</td>
                                                <td>{{ $user->sex }}</td>
                                                <td>
                                                    <a href="{{route('employees.edit',['employee'=>$user->employee->id])}}">
                                                        <x-button>Edit</x-button>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{route('users.destroy',['user'=>$user->id,'employee'=>$user->employee->id])}}" method="POST">
                                                        @csrf
                                                        @method("DELETE")
                                                        <x-delbutton value="{{ $user->id }}" onclick="showdelModal(this.value)" type="button">Delete</x-delbutton>
                                                        <div class="fixed z-10 inset-0 overflow-y-auto invisible opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal{{ $user->id }}">
                                                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hiddendelModal('{{$user->id}}')"></div>
        
                                                                <!-- This element is to trick the browser into centering the modal contents. -->
                                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
                                                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                    <div class="sm:flex sm:items-start">
                                                                        <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                                <div class="sm:flex sm:items-start">
                                                                                    <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                                                                        <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                                                                                            Do you want to delete this user?
                                                                                        </h3>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-400 text-base font-medium text-black hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                    Yes
                                                                                </button>
                                                                                <button value="{{ $user->id }}" type="button" onclick="hiddendelModal(this.value)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                    No
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                                $i ++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else

                        @endif
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

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" action="{{ route('add_role') }}">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center w-full sm:mt-0 sm:my-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Add New Role
                                    </h3>
                                    <div class="mt-2 w-full">
                                        <x-input id="newRole" class="block mt-1 w-full" type="text" name="newRole"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" onclick="saveNewRole()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-400 text-base font-medium text-black hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Save
                            </button>
                            <button type="button" onclick="hiddenModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
