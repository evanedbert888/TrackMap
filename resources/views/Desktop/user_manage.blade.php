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

    </script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="rounded-lg mt-3 p-3">
                        <div class="w-full">
                        <div class="unverify">
                            <div class="flex justify-end">
                                <x-button>Add Role</x-button>
                            </div>
                            <h1 class="text-2xl font-bold">Unverified</h1>
                            <div class="border border-black border-5 rounded rounded-full h-1 bg-black"></div>
                            <div class="flex mx-auto justify-center">
                                <table class="w-full table-auto mt-4">
                                    <thead>
                                        <tr class="text-center text-base">
                                            <th><input type="checkbox" id="chkbxAll" class="rounded border-black text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></th>
                                            <th> Name </th>
                                            <th> Birth Date </th>
                                            <th> Sex </th>
                                            <th> Address </th>
                                            <th> Email </th>
                                            <th> Role </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="unverified" name="unverified">
                                        @foreach($uvdusers as $user)
                                        <tr class="bg-red-100 border border-black border-b-2 border-t-0 border-r-0 border-l-0">
                                            <td>
                                                <input value="{{ $user->id }}" type="checkbox" name="ids" id="chkbx{{ $user->id }}" class="chkbx rounded border-black text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->birth_date }}</td>
                                            <td>{{ $user->sex }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <select name="role" id="role{{$user->id}}" class="rounded-md role" disabled>
                                                    <option class="hidden"></option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
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
                            <h1 class="text-2xl font-bold mt-8">Verified</h1>
                            <div class="border border-black border-5 border-b rounded rounded-full h-1 bg-black"></div>
                            <div class="flex mx-auto justify-center">
                                <table class="w-full table-auto mt-4">
                                    <thead>
                                        <tr class="text-center text-base">
                                            <th> No </th>
                                            <th> Name </th>
                                            <th> Birth Date </th>
                                            <th> Sex </th>
                                            <th> Address </th>
                                            <th> Email </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="verified" name="verified">
                                        <?php $i = 1; ?>
                                        @foreach($vdusers as $user)
                                            <tr class="bg-yellow-100">
                                                <td>{{ $i }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->birth_date }}</td>
                                                <td>{{ $user->sex }}</td>
                                                <td>{{ $user->address }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <x-button value="{{ $user->id }}">Edit</x-button>
                                                    
                                                    <x-delbutton value="{{ $user->id }}">Delete</x-delbutton>
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
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
