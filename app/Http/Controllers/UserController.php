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

    public function edit_profile(){
        $id = Auth::user()->id;
        $details = DB::table('users')->where('id','=',$id)->get();
        return view('edit_profile',['details'=>$details]);
    }

    public function profile_update() {

    }
}
