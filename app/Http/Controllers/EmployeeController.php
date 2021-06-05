<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Role;

class EmployeeController extends Controller
{
    public function employee_list(){
        $lists = Employee::query()->orderBy('id','desc')->paginate(5);
        return view('Desktop.employee.employee_list',['lists'=>$lists]);
    }

    public function employee_detail($id){
        $details = Employee::query()->find($id);
        if (Auth::user()->role == 'admin') {
            return view('Desktop.employee.employee_detail',['details'=>$details]);
        } else {
            return view('Mobile.employee_profile',['details'=>$details]);
        }
    }

    public function edit_employee($id){
        $details = Employee::query()->where('user_id','=',$id)->first();
        return view('Desktop.employee.edit_employee',['details'=>$details]);
    }

    public function employee_patch($id, $user_id, Request $request){
        $validateEmployee = $request->validate([
           'name' => 'string|required|max:255',
           'motto' => 'string|required|max:255',
           'email' => 'string|required|max:255',
           'birth_date' => 'required',
           'sex' => 'required',
           'address' => 'required'
        ]);

        $birth_year = date("Y",strtotime($request->birth_date));
        $curr_year = date("Y",strtotime("now"));
        $age = $curr_year - $birth_year;

        $birth_month = date("M",strtotime($request->birth_date));
        $birth_day = date("D",strtotime($request->birth_date));

        $this_date = strtotime($birth_day.'-'.$birth_month.'-'.$curr_year);
        $now_date = strtotime("now");
        if ($now_date < $this_date) {
            $age = $age - 1;
        }

        $user = new User();
        $user->updateById($user_id, array(
            "name" => $validateEmployee['name'],
            "email" => $validateEmployee['email'],
            'age' => $age,
            'sex' => $validateEmployee['sex'],
            'birth_date' => Carbon::create($request->birth_date),
            'address' => $validateEmployee['address']
        ));

        $employee = new Employee();
        $employee->updateById($id, array(
            "motto" => $validateEmployee['motto'],
        ));

        return redirect()->route('employee_detail',['id'=>$id]);
    }

    public function employee_delete($id){
        $employee = DB::table('employees')->where('id','=',$id)->get();
        $user_id = $employee[0]->user_id;
        DB::table('employees')->where('id','=',$id)->delete();
        DB::table('users')->where('id','=',$user_id)->delete();
        return redirect()->route('employee_list');
    }

    public function role_list() {

    }

    public function add_role(Request $request) {
        $new_role = $request->newRole;
        $role = new Role();
        $role->role_name = $new_role;
        $role->save();
        return redirect()->route('show_user');
    }

    public function delete_role($id) {

    }
}
