<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function email_register() {
        return view('Desktop.email_register');
    }

    public function add_email(Request $request) {
        $id = Auth::id();
        $validateRegister = $request->validate([
            'email' => 'required|string|max:255'
        ]);

        $register = new Register();
        $register->email = $validateRegister['email'];
        $register->user_id = $id;
        $register->save();

        return redirect()->route('register_list');
    }

    public function register_list() {
        $registers = Register::query()->paginate(10);
        return view('Desktop.register_list',['registers'=>$registers]);
    }

//    public function register_delete($id) {
//        Register::destroy($id);
//        return redirect()->route('register_list');
//    }
}
