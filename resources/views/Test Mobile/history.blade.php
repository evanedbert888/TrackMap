@extends('layouts.mobile')
@section('title','History')

@section('content')
    <div>
        <div class="grid grid-cols-3 container mt-5 py-2 justify-items-stretch items-center">
            <a href="#" class="ml-5 mt-2">
                <button class="bg-gray-100 border border-gray-400" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                </button>
            </a>
            <h3 class="font-semibold text-xl text-center">
                {{__('History')}}
            </h3>
        </div>
        <section>
            @foreach($histories as $history)
                <div class="grid grid-cols-3 items-center gap-y-3 justify-self-center">
                    <div class="col-span-2 col-start-1">
                        <span class="flex container mx-4 my-2 space-x-4 self-center">
                            <img class="rounded-full border border-blue-200 w-12 h-12 self-center" src="https://pbs.twimg.com/media/EwoOsbVXIAEou8m.jpg" alt="{{ $history->company->company_name }}">
                            <div class="flex leading-tight text-sm self-center">
                                <div>
                                    {{ $history->company->company_name }} <br>
                                    {{ $history->company->business->name }} <br>
                                    {{$history->updated_at}}
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 self-center" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            @endforeach
        </section>
        {{$histories->links()}}
    </div>
@endsection
