<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sales Map</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <main>
        <div class="mx-auto">
            <ol>
                @foreach($lists as $list)
                <li>
                    <div  class="bg-green-400 rounded-md mb-4 w-32">
                        <img src="" alt="">
                        <p class="ml-0"> {{$list->company_name}} </p>
                        <p class="ml-0"> {{$list->address}} </p>
                        <div>
                            <button class="mr-0" type="button">Detail</button>
                            <form action="{{route('company_delete',['id'=>$list->id])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="mr-0" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ol>
            {{$lists->links()}}
        </div>
    </main>
</body>
</html>
