<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Auth;

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

    public function profile_update() {

    }

    public function task_pairing() {
        $roles = DB::table('roles')->OrderBy('role_name')->get();
        $businesses = DB::table('businesses')->OrderBy('name')->get();
        return view('Desktop.task_pairing',["roles"=>$roles,"businesses"=>$businesses]);
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
}
