@extends('layouts.mobile')
@section('title','Profile')

@section('content')
    <div class="p-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
        </svg>
        <div class="flex flex-col container items-center">
            <h2 class="text-3xl text-bold"> Profile </h2>
            <img class="rounded-full w-32" src="https://cdn.iconscout.com/icon/free/png-256/people-1659484-1410006.png" alt="">
            <form action="#" method="POST">
                @method('PATCH')
                @csrf

                <div class="my-3 space-y-0">
                    <x-label for="name" :value="__('Username')"/>

                    <x-input id="name" class="block mt-1 w-24" type="text"
                             name="name" :value={{$details[0]->name}} required
                             autofocus/>
                </div>
            </form>
        </div>
    </div>

@endsection
