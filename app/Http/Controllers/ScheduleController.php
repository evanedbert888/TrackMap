<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Schedule;
use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware([
           'role:admin',
           'permission:schedule index|store schedule|destroy schedule'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $id = Auth::user()->getAuthIdentifier();
        $schedules = Schedule::where('user_id', '=', $id)->get()
            ->load(['employee.user'])->load('destination');
        return response()->json($schedules);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $salesman
     * @param $destination
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($salesman, $destination): \Illuminate\Http\JsonResponse
    {
        $schedule = new Schedule;
        $schedule->user_id  = Auth::id();
        $schedule->employee_id = $salesman;
        $schedule->destination_id = $destination;
        $schedule->save();

        return response()->json(['success'=>'Added new records.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Schedule $schedule
     * @return Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Schedule $schedule
     * @return Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Schedule $schedule
     * @return Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Schedule $schedule
     * @return JsonResponse
     */
    public function destroy($schedule): JsonResponse
    {
        Schedule::destroy($schedule);
        return response()->json(['success'=>'deleted record.']);
    }

    public function search(Request $request): JsonResponse
    {
        $destinations = Destination::query()
            ->where('destination_name','like','%'.$request->search.'%')
            ->orWhere('address','like','%'.$request->search.'%')
            ->select('id','destination_name')
            ->get();
        return response()->json($destinations);
    }

    public function use(): JsonResponse
    {
        $aschedules = Schedule::all()->toArray();
        $n = count($aschedules);


        for($i=0; $i<$n; $i++) {
            $schedules = json_decode(json_encode(array_shift($aschedules)));

            $temp = new Temp;
            $temp->employee_id = $schedules->employee_id;
            $temp->destination_id = $schedules->destination_id;
            $temp->save();
        }

        return response()->json($schedules);
    }
}
