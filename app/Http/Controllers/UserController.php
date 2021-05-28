<?php

namespace App\Http\Controllers;

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
        $details = DB::table('users')->where('id','=',$id)->get();
        return view('Desktop.profile',['details'=>$details]);
    }

    public function edit_profile(){
        $id = Auth::user()->id;
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
        $uvdusers = DB::table('users')->where('status','=','Unverified')
                    ->orderBy('created_at')->get();
        $vdusers = DB::table('users')->where('status','=','Verified')
                    ->orderBy('updated_at')->get();
        return view('Desktop.user_manage', ['uvdusers'=>$uvdusers, 'vdusers'=>$vdusers]);
    }

    public function update_status_user(Request $request) {
        $ids = $request->ids;
        User::whereIn('id',$ids)->update(['status'=>'Verified']);
        return response()->json($ids);
    }
}
