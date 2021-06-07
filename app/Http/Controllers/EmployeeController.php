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
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    public function employee_list(){
        $lists = Employee::query()->orderBy('id','desc')->paginate(5);
        return view('Desktop.employee.employee_list',['lists'=>$lists]);
    }

    public function employee_detail($id){
        $details = Employee::query()->find($id);
        return view('Desktop.employee.employee_detail',['details'=>$details]);
    }

    public function edit_employee($id){
        if (Auth::user()->role == 'admin') {
            $details = Employee::query()->find($id);
            return view('Desktop.employee.edit_employee',['details'=>$details]);
        } elseif (Auth::user()->role == 'employee') {
            $user_id = Auth::user()->id;
            $details = Employee::query()->where('user_id','=',$user_id)->first();
            return view('Mobile.employee.edit_employee_profile',['details'=>$details]);
        }
    }

    public function employee_patch($id, Request $request){
        $user_id = Employee::query()->where('id','=',$id)->pluck('user_id');
        $img_name = User::query()->where('id','=',$user_id)->pluck('image');

        $validateEmployee = $request->validate([
           'name' => 'string|required|max:255',
           'motto' => 'string|required|max:255',
           'email' => 'string|required|max:255',
           'birth_date' => 'required',
           'sex' => 'required',
           'address' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $folder = 'employee'.$id;
            if(File::exists('storage/employee/'.$folder)){
                File::cleanDirectory('storage/employee/'.$folder);
            }

            $image_name = $request->file('image')->getClientOriginalName();
            $new_image_name = 'employee/'.$folder.'/'.$id.'-'.time().'-'.$image_name;
            $img_name = $new_image_name;

            $request->image->storeAs('public',$img_name);
            asset('public/'.$new_image_name);
        }

        $date = $request->birth_date;
        function formatDate($input,$date) {
            return date($input,strtotime($date));
        }

        $birth_year = formatDate("Y",$date);
        $curr_year = formatDate("Y","now");
        $age = $curr_year - $birth_year;

        $birth_month = formatDate("M",$date);
        $birth_day = formatDate("D",$date);

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
            'address' => $validateEmployee['address'],
            'image' => $img_name
        ));

        $employee = new Employee();
        $employee->updateById($id, array(
            "motto" => $validateEmployee['motto'],
        ));

        if (Auth::user()->role == 'admin') {
            return redirect()->route('employee_detail',['id'=>$id]);
        } elseif (Auth::user()->role == 'employee') {
            return redirect()->route('profile');
        }
    }

    public function employee_delete($id){
        $employee = DB::table('employees')->where('id','=',$id)->get();
        $user_id = $employee[0]->user_id;
        DB::table('employees')->where('id','=',$id)->delete();
        DB::table('users')->where('id','=',$user_id)->delete();

        $folder = 'employee'.$id;
        if(File::exists('storage/employee/'.$folder)){
            File::cleanDirectory('storage/employee/'.$folder);
            File::deleteDirectory('storage/employee/'.$folder);
        }

        return redirect()->route('show_user');
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
