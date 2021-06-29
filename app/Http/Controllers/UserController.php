<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $uvdusers = User::query()->where('status','=','Unverified')->where('role','=','employee')->orderBy('created_at')->get();
        $vdusers = User::query()->where('status','=','Verified')->orderBy('updated_at')->get();
        $roles = Role::all();
        return view('Desktop.users.index', ['uvdusers'=>$uvdusers, 'vdusers'=>$vdusers, 'roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show()
    {
        $id = Auth::user()->id;
        $details = User::query()->find($id);
        if (Auth::user()->role == 'admin') {
            return view('Desktop.users.show',['details'=>$details]);
        } elseif (Auth::user()->role == 'employee') {
            return view('Mobile.employees.show',['details'=>$details]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view('Desktop.users.edit',['details'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
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
        } else {
            $img_name = null;
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

        return redirect()->route('users.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */

    // temporary, data tidak akan delete cuma status unavailable aja
    public function destroy($id,$employee_id)
    {
        User::destroy($id);
        Employee::destroy($employee_id);

        $folder = 'employee'.$employee_id;
        if(File::exists('storage/employee/'.$folder)){
            File::cleanDirectory('storage/employee/'.$folder);
            File::deleteDirectory('storage/employee/'.$folder);
        }
        echo "A user has been deleted";
        return redirect()->route('users.index');
    }

    public function dashboard() {
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
        if ($role == "admin"){
            $goals = Goal::query()
                ->join('employees', 'goals.employee_id', '=', 'employees.id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->join('destinations', 'goals.destination_id', '=', 'destinations.id')
                ->select('goals.*', 'users.name as employee_name', 'destinations.destination_name', 'destinations.address')
                ->where('goals.status','=','finished')
                ->where('goals.user_id','=',$user_id)
                ->get();
        }
        else if ($role == "employee"){
            $employee = Employee::query()->where('user_id', '=', $user_id)->get();
            $goals = Goal::query()
                ->join('employees', 'goals.employee_id', '=', 'employees.id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->join('destinations', 'goals.destination_id', '=', 'destinations.id')
                ->select('goals.*', 'users.name as employee_name', 'destinations.destination_name', 'destinations.address')
                ->where('goals.status','=','finished')
                ->where('goals.employee_id','=', $employee[0]->id)
                ->get();
        }
        return response()->json($goals);
    }

    public function update_status_user(Request $request): JsonResponse
    {
        $ids = $request->ids;
        $roles = $request->roles;

        User::query()->whereIn('id',$ids)->update(['status'=>'Verified']);
        for ($i=0; $i < count($roles); $i++) {
            $id = $ids[$i];
            $role = $roles[$i];
            $query = Employee::query()->where('user_id','=',$id)->update(['role_id'=>$role]);
        }
        return response()->json();
    }
}
