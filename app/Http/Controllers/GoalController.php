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
    public function __construct() {
        $this->middleware('auth');
        $this->middleware([
           'role:employee',
           'permission:mobile goal index|mobile update goal|mobile goal history'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $user_id = Auth::user()->getAuthIdentifier();
        $employee_id = Employee::query()->where('user_id','=',$user_id)->value('id');
        $goals = Goal::with(['destination'])->where('employee_id','=',$employee_id)
            ->where('status','=','unfinished')
            ->paginate(5);
        return view('Mobile.goals.index',['goals'=>$goals]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $user_id = Auth::user()->getAuthIdentifier();

        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $goal_id = Goal::query()->where('employee_id','=',$employee_id)
            ->where('destination_id','=',$request->input('id'))
            ->where('status','=','unfinished')
            ->pluck('id');

        $goal = new Goal();
        $goal->updateById($goal_id, array(
            "latitude" => $request->input('latitude'),
            "longitude" => $request->input('longitude'),
            "status" => 'finished',
            "updated_at" => date(now()),
        ));
        return redirect()->route('goals.index')->with('success','You have finished a task!');
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
        $user_id = Auth::user()->getAuthIdentifier();
        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $histories = Goal::with(['destination'])->where('status','=','finished')
            ->where('employee_id','=',$employee_id)
            ->paginate(5);
        return view('Mobile.goals.history',['histories'=>$histories]);
    }
}
