<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__("User")}}
        </h2>
    </x-slot>
    <script>
        function showUser(){
            alert("yericho");
            // $.ajax({
            //     url:'{{ route('show_user') }}',
            //     method:"get",
            //     success:function(data){
            //         // setUserToTable(data);
            //         console.log(data)
            //     },
            //     error:function(err){
            //         console.log(err);
            //     }
            // })
        }

        // function setUserToTable(user){
        //     var data = ""
        //     $.each(user, function(key, value){
        //         data = data + "<tr"
        //         <tr class="bg-yellow-100">
        //         <td>
        //             <input id="remember_me" type="checkbox" class="rounded border-black text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="verify">
        //         </td>
        //         <td>Budi</td>
        //         <td>12 November 2000</td>
        //         <td>Male</td>
        //         <td>Jalan Kebangsaan</td>
        //         <td>budi@gmail.com</td>
        //         </tr>
        //     })
        //     $('#unverified').html(data);
        // }
    </script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 bg-white border-b border-gray-200">
                    <div class="rounded-lg mt-3 p-3">
                        <div class="w-full">
                            <h1 class="text-2xl font-bold">Unverified</h1>
                            <div class="border border-black border-5 rounded rounded-full h-1 bg-black"></div>
                            <div class="flex mx-auto justify-center">
                                <table class="w-full table-auto mt-4">
                                    <thead>
                                        <tr class="text-center text-base">
                                            <th></th>
                                            <th> Name </th>
                                            <th> Birth Date </th>
                                            <th> Sex </th>
                                            <th> Address </th>
                                            <th> Email </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="unverified" name="unverified">
                                        @foreach($uvdusers as $user)
                                        <tr class="bg-red-100 border border-black border-b-2 border-t-0 border-r-0 border-l-0">
                                            <td>
                                                <input value="{{ $user->id }}" id="verify" type="checkbox" class="rounded border-black text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="verify">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->birth_date }}</td>
                                            <td>{{ $user->sex }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex mt-2 item-center justify-end">
                                <x-savebutton class="font-bold">Verify</x-savebutton>
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
                                                <x-button>Edit</x-button>
                                                <x-delbutton>Delete</x-delbutton>
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
