<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function dashboard() {
        $user_id = Auth::user()->id;
        $goals = Goal::query()->where('status','=','finished')
            ->where('user_id','=',$user_id)->get();
        return view('dashboard',['goals'=>$goals]);
    }

    public function profile(){
        $id = Auth::user()->id;
        $details = User::query()->find($id);
        if (Auth::user()->role == 'admin') {
            return view('Desktop.user.profile',['details'=>$details]);
        } elseif (Auth::user()->role == 'employee') {
            return view('Mobile.employee.employee_profile',['details'=>$details]);
        }
    }

    public function edit_profile($id){
        $details = User::query()->find($id);
        return view('Desktop.user.edit_profile',['details'=>$details]);
    }

    public function profile_update(Request $request) {
        $id = Auth::id();
        $img_name = Auth::User()->image;
        $validateProfile = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|max:255',
           'sex' => 'required',
           'birth_date' => 'required',
           'address' => 'required|max:300|string',
           'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        if ($request->hasFile('image')) {
            $folder = 'admin'.$id;
            if(File::exists('storage/admin/'.$folder)){
                File::cleanDirectory('storage/admin/'.$folder);
            }

            $image_name = $request->file('image')->getClientOriginalName();
            $new_image_name = 'admin/'.$folder.'/'.$id.'-'.time().'-'.$image_name;
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
        $user->updateById($id, array(
           "name" => $validateProfile['name'],
           "email" => $validateProfile['email'],
           'age' => $age,
           'sex' => $validateProfile['sex'],
           'birth_date' => Carbon::create($request->birth_date),
           'address' => $validateProfile['address'],
           'image' => $img_name
        ));

        return redirect()->route('profile');
    }

    // User Manage
    public function show_user() {
        $uvdusers = User::query()->where('status','=','Unverified')->where('role','=','employee')->orderBy('created_at')->get();
        $vdusers = User::query()->where('status','=','Verified')->orderBy('updated_at')->get();
        $roles = Role::all();
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
