<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Register;
use App\Models\Employee;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\Null_;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.check-email');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255'
        ]);
        
        $email = Register::where('email','=',$request->email)
                            ->where('status','=','available')->get();

        if(count($email) == 0){
            echo "<script language='javascript' type='text/javascript'>alert('Email Tidak Ditemukan');  
                </script>";
            return view('auth.check-email');
        }
        else
            return view('auth.register', ['email'=>$email]);
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'sex' => 'required',
            'birth_date' => 'required',
            'address' => 'required|max:255',
            'password' => 'required|string|confirmed|min:8',
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $age,
            'sex' => $request->sex,
            'role' => 'employee',
            'birth_date' => Carbon::create($request->birth_date),
            'address' => $request->address
        ]);
        
        $email = Register::where('email', '=',  $request->email)->update(['status' => 'unavailable']);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
