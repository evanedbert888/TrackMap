<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\RegisteredEmail;
use App\Models\User;
use App\Models\Register;
use App\Models\Employee;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
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

        $email = RegisteredEmail::query()->where('email','=',$request->input('email'))
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
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $user = new User();
        $age = $user->findUserAge($request->input('birth_date'));

        $user = User::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'age' => $age,
            'sex' => $request->input('sex'),
            'birth_date' => Carbon::create($request->input('birth_date')),
            'address' => $request->input('address')
        ]);

        $email = RegisteredEmail::query()->where('email', '=',  $request->input('email'))->update(['status' => 'unavailable']);

        event(new Registered($user));

        $new_user = User::query()->orderBy('id','desc')->first();
        $employee = new Employee();
        $employee->user_id = $new_user->id;
        $employee->save();

        $user->assignRole('employee');

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
