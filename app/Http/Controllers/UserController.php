<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function profile(){
        $id = Auth::user()->id;
        $details = User::query()->find($id);
        return view('Desktop.profile',['details'=>$details]);
//        if (Auth::user()->role == 'admin') {
//            return view('Desktop.profile',['details'=>$details]);
//        } elseif (Auth::user()->role == 'employee') {
//            return view('Test_Mobile.employee_profile',['details'=>$details]);
//        }
    }

    public function edit_profile($id){
        $details = DB::table('users')->where('id','=',$id)->get();
        return view('Desktop.edit_profile',['details'=>$details]);
    }

    public function profile_update(Request $request) {
        $id = Auth::id();
        $validateProfile = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|max:255',
           'sex' => 'required',
           'birth_date' => 'required',
           'address' => 'required|max:300|string'
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
        $user->updateById($id, array(
            "name" => $validateProfile['name'],
            "email" => $validateProfile['email'],
            'age' => $age,
            'sex' => $validateProfile['sex'],
            'birth_date' => Carbon::create($request->birth_date),
            'address' => $validateProfile['address']
        ));

        return redirect()->route('profile');
    }

    // User Manage
    public function show_user() {
        $uvdusers = User::query()->where('status','=','Unverified')->orderBy('created_at')->get();
        $vdusers = User::query()->where('status','=','Verified')->orderBy('updated_at')->get();
        $roles = DB::table('roles')->get();
        return view('Desktop.user_manage', ['uvdusers'=>$uvdusers, 'vdusers'=>$vdusers, 'roles'=>$roles]);
    }

    public function update_status_user(Request $request) {
        $ids = $request->ids;
        $roles = $request->roles;

        User::whereIn('id',$ids)->update(['status'=>'Verified']);
        for ($i=0; $i < count($roles); $i++) { 
            $id = $ids[$i];
            $role = $roles[$i];
            $query = Employee::where('user_id','=',$id)->update(['role_id'=>$role]);
        }
        return response()->json();
    }

    public function delete_user_manage($id,$employee_id) {
        User::destroy($id);
        Employee::destroy($employee_id);
        echo "A user has been deleted";
        return redirect()->route('show_user');
    }
}
