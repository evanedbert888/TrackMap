<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\Destination;
use App\Models\Employee;
use App\Models\Goal;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Temp;
use Hamcrest\Core\HasToString;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware([
            'role:admin',
            'permission:task index|create task|store task|destroy task|show employee role|show destination business-category'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $goals = Goal::query()->paginate(12);
        return view('Desktop.tasks.index',['goals'=>$goals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $sections = Section::query()->orderBy('section_name')->get();
        $businesses = BusinessCategory::query()->orderBy('name')->get();
        $salesmans = DB::table('users')->join('employees', 'users.id', '=', 'employees.user_id')
            ->select('employees.id','users.name')
            ->where('employees.section_id','=', 1)->orderBy('name')->get();
        $temps = Temp::all();
        return view('Desktop.tasks.create',[
            "sections"=>$sections,
            "businesses"=>$businesses,
            "temps"=>$temps,
            "salesmans"=>$salesmans
        ]);
    }

    /**
     *
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $count = Temp::all()->count();
        for ($id = 1; $id <= $count; $id++) {
            $tasks = Temp::query()->first();
            $destinations = Destination::query()->firstwhere('id',$tasks->destination_id);

            $goal = new Goal();
            $goal->user_id = Auth::id();
            $goal->destination_id = $tasks->destination_id;
            $goal->employee_id = $tasks->employee_id;
            $goal->save();

            Temp::destroy($tasks->id);
        }
        return redirect()->route('tasks.create')->with('success','Tasks has been successfully sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $temp
     * @return JsonResponse
     */
    public function destroy($temp): JsonResponse
    {
        Temp::destroy($temp);
        return response()->json(['success'=>'deleted record.']);
    }

    public function show_employee_by_role($id): JsonResponse
    {
        $data = DB::table('users')->join('employees', 'users.id', '=', 'employees.user_id')
            ->select('employees.id','users.name','users.image','employees.section_id')
            ->where('employees.section_id','=',$id)->orderBy('name')->get();
        return response()->json($data);
    }

    public function show_destination_by_business($id): JsonResponse
    {
        $data = DB::table('destinations')->where('business_id','=',$id)->orderBy('destination_name')->get();
        return response()->json($data);
    }

    public function store_task($employee, $destination): JsonResponse
    {
        $temp = new Temp;
        $temp->employee_id = $employee;
        $temp->destination_id = $destination;
        $temp->save();

        return response()->json(['success'=>'Added new records.']);
    }

    public function show_task(): JsonResponse
    {
        $tasks = DB::table('temps')
            ->join('employees','temps.employee_id', '=', 'employees.id')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->join('destinations','temps.destination_id', '=', 'destinations.id')
            ->select('temps.*','users.name as employee_name','destinations.destination_name')->get();
        return response()->json($tasks);
    }
}
