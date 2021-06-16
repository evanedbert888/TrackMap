<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
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

use function GuzzleHttp\Promise\task;

class TaskController extends Controller
{
    public function task_view(){
        $goals = Goal::query()->paginate(12);
        return view('Desktop.task_list',['goals'=>$goals]);
    }

    public function task_pairing() {
        $roles = DB::table('roles')->OrderBy('role_name')->get();
        $businesses = BusinessCategory::query()->orderBy('name')->get();
        $temps = Temp::all();
        return view('Desktop.task_pairing',["roles"=>$roles,"businesses"=>$businesses,"temps"=>$temps]);
    }

    public function show_employee_by_role($id) {
        $data = DB::table('users')->join('employees', 'users.id', '=', 'employees.user_id')
            ->select('employees.id','users.name','users.image','employees.role_id')
            ->where('employees.role_id','=',$id)->orderBy('name')->get();
        return response()->json($data);
    }

    public function show_company_by_business($id) {
        $data = DB::table('companies')->where('business_id','=',$id)->orderBy('company_name')->get();
        return response()->json($data);
    }

    public function store_task($employee, $company) {
        $temp = new Temp;
        $temp->employee_id = $employee;
        $temp->company_id = $company;
        $temp->save();

        return response()->json(['success'=>'Added new records.']);
    }

    public function show_task() {
        $tasks = DB::table('temps')
                    ->join('employees','temps.employee_id', '=', 'employees.id')
                    ->join('users', 'employees.user_id', '=', 'users.id')
                    ->join('companies','temps.company_id', '=', 'companies.id')
                    ->select('temps.*','users.name as employee_name','companies.company_name')->get();
        return response()->json($tasks);
    }

    public function goals_insert() {
        $count = Temp::all()->count();
        for ($id = 1; $id <= $count; $id++) {
            $tasks = Temp::first();
            $companys = Company::firstwhere('id',$tasks->company_id);

            $goal = new Goal();
            $goal->user_id = Auth::user()->id;
            $goal->company_id = $tasks->company_id;
            $goal->employee_id = $tasks->employee_id;
            $goal->latitude = $companys->latitude;
            $goal->longitude = $companys->longitude;
            $goal->save();

            Temp::destroy($tasks->id);
        }
        return redirect()->route('task_pairing');
    }

    public function temp_delete($id) {
        Temp::destroy($id);
        return response()->json(['success'=>'deleted record.']);
    }
}
