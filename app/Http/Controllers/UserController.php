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
        return view('profile',['details'=>$details]);
    }

    public function profile_update() {

    }

    public function task_pairing() {
        $companies = DB::table('companies')->get();
        $employees = DB::table('employees')->get();
        $businesses = DB::table('companies')->pluck('business');
        $temps = DB::table('temps')->get();
        return view('task_pairing',["companies"=>$companies,"employees"=>$employees,"businesses"=>$businesses]);
    }
}
