<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Goal;
use App\Models\Temp;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function task_pairing() {
        $roles = DB::table('roles')->OrderBy('role_name')->get();
        $businesses = DB::table('businesses')->OrderBy('name')->get();
        $temps = Temp::all();
        return view('Desktop.task_pairing',["roles"=>$roles,"businesses"=>$businesses,"temps"=>$temps]);
    }

    public function show_employee_by_role($id) {
        $data = DB::table('users')->join('employees', 'users.id', '=', 'employees.user_id')
            ->select('users.id','users.name','users.image','employees.role_id')
            ->where('employees.role_id','=',$id)->orderBy('name')->get();
        return response()->json($data);
    }

    public function show_company_by_business($id) {
        $data = DB::table('companies')->where('business_id','=',$id)->orderBy('company_name')->get();
        return response()->json($data);
    }

    public function store_task($employee, $company) {
        $temp = new Temp;
        $user_id = Auth::user()->id;
        $temp->user_id = $user_id;
        $temp->employee_id = $employee;
        $temp->company_id = $company;
        $temp->save();

        return response()->json(['success'=>'Added new records.']);
    }

    public function show_task() {
        $tasks = Temp::all();
        return response()->json($tasks);
    }

    public function goals_insert() {
        $count = Temp::all()->count();
        for ($id = 1; $id <= $count; $id++) {
            $tasks = Temp::query()->find($id);

            $goal = new Goal();
            $goal->employee_id = $tasks->employee_id;
            $goal->company_id = $tasks->company_id;
            $goal->save();

            Temp::destroy($id);
        }
        return redirect()->route('task_pairing');
    }

    public function history() {
        $user_id = Auth::user()->id;
        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $histories = Goal::query()->where('status','=','finished')
            ->where('employee_id','=',$employee_id)
            ->paginate(5);
//        return view('Mobile.company.goal_history',['histories'=>$histories]);
        return view('Test_Mobile.history',['histories'=>$histories]);
    }

    public function temp_delete($id) {
        Temp::destroy($id);
        return redirect()->route('task_pairing');
    }

    public function task_list() {
        $user_id = Auth::user()->id;
        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $goals = Goal::query()->where('employee_id','=',$employee_id)
            ->where('status','=','unfinished')
            ->paginate(5);
        $count = Goal::query()->where('employee_id','=',$employee_id)
            ->where('status','=','unfinished')
            ->count();
        return view('Test_Mobile.task_list',['goals'=>$goals,'count'=>$count]);
//        return view('Mobile.company.task_list',['goals'=>$goals]);
    }

    public function task_checkIn(Request $request) {
        $user_id = Auth::user()->id;
        $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
        $goal_id = Goal::query()->where('employee_id','=',$employee_id)
            ->where('company_id','=',$request->id)
            ->where('status','=','unfinished')
            ->pluck('id');

        $goal = new Goal();
        $goal->updateById($goal_id, array(
           "latitude" => $request->latitude,
           "longitude" => $request->longitude,
           "status" => 'finished',
           "updated_at" => date(now()),
        ));

        return redirect()->route('task_list');
    }
}