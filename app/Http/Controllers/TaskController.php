<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\Destination;
use App\Models\Goal;
use App\Models\Role;
use App\Models\Temp;
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
        $roles = Role::query()->orderBy('role_name')->get();
        $businesses = BusinessCategory::query()->orderBy('name')->get();
        $temps = Temp::all();
        return view('Desktop.tasks.create',["roles"=>$roles,"businesses"=>$businesses,"temps"=>$temps]);
    }

    /**
     *
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $count = Temp::all()->count();
        for ($id = 1; $id <= $count; $id++) {
            $tasks = Temp::first();
            $destinations = Destination::query()->firstwhere('id',$tasks->destination_id);

            $goal = new Goal();
            $goal->user_id = Auth::user()->id;
            $goal->destination_id = $tasks->destination_id;
            $goal->employee_id = $tasks->employee_id;
            $goal->save();

            Temp::destroy($tasks->id);
        }
        return redirect()->route('tasks.create');
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
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(Temp $temp): JsonResponse
    {
        $temp->delete();
        return response()->json(['success'=>'deleted record.']);
    }

    public function show_employee_by_role($id): JsonResponse
    {
        $data = DB::table('users')->join('employees', 'users.id', '=', 'employees.user_id')
            ->select('employees.id','users.name','users.image','employees.role_id')
            ->where('employees.role_id','=',$id)->orderBy('name')->get();
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
