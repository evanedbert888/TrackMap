<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $goals = Goal::query()->where('employee_id','=',$employee_id)
            ->where('status','=','unfinished')
            ->paginate(5);
        $count = Goal::query()->where('employee_id','=',$employee_id)
            ->where('status','=','unfinished')
            ->count();
        return view('Mobile.goals.index',['goals'=>$goals,'count'=>$count]);
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $goal_id = Goal::query()->where('employee_id','=',$employee_id)
            ->where('destination_id','=',$request->id)
            ->where('status','=','unfinished')
            ->pluck('id');

        $goal = new Goal();
        $goal->updateById($goal_id, array(
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
            "status" => 'finished',
            "updated_at" => date(now()),
        ));

        return redirect()->route('goals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function history()
    {
        $user_id = Auth::user()->id;
        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $histories = Goal::query()->where('status','=','finished')
            ->where('employee_id','=',$employee_id)
            ->paginate(5);
        return view('Mobile.goals.history',['histories'=>$histories]);
    }
}
