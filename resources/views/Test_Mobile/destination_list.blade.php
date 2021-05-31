@extends('layouts.mobile')
@section('title','Destinations')

@section('content')
    <div>
        <div class="grid grid-cols-3 p-4 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
            <div class="text-semibold text-xl text-center">
                <h2>Destinations</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-y-4 bg-blue-400">
            @foreach($lists as $list)
                <div class="grid grid-cols-3 justify-center items-center">
                    <img class="rounded-full w-16 mx-auto" src="https://cdn.iconscout.com/icon/free/png-256/people-1659484-1410006.png" alt="image">
                    <div class="text-sm text-semibold text-gray-800 text-left">
                        <p>{{$list->company_name}}</p>
                        <p>{{$list->business->name}}</p>
                    </div>
                    <div class="flex justify-start items-center">
                        <a href="{{route('destination_detail',['id'=>$list->id])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        {{$lists->links()}}
    </div>
@endsection