<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $lists = Employee::query()->orderBy('id','desc')->paginate(5);
        return view('Desktop.employees.index',['lists'=>$lists]);
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show(Employee $employee)
    {
        return view('Desktop.employees.show',['details'=>$employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit(Employee $employee)
    {
        if (Auth::user()->role == 'admin') {
            return view('Desktop.employees.edit',['details'=>$employee]);
        } elseif (Auth::user()->role == 'employee') {
            $details = Employee::query()->where('id','=',$employee->id)->first();
            return view('Mobile.employees.edit',['details'=>$details]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Employee $employee
     * @return RedirectResponse
     */
    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $user_id = Employee::query()->where('id','=',$employee->id)->pluck('user_id');
        $img_name = User::query()->where('id','=',$user_id)->pluck('image');

        $validateEmployee = $request->validate([
            'name' => 'string|required|max:255',
            'motto' => 'string|required|max:255',
            'email' => 'string|required|max:255',
            'birth_date' => 'required',
            'sex' => 'required',
            'address' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $folder = 'employee'.$employee->id;
            if(File::exists('storage/employee/'.$folder)){
                File::cleanDirectory('storage/employee/'.$folder);
            }

            $image_name = $request->file('image')->getClientOriginalName();
            $new_image_name = 'employee/'.$folder.'/'.$employee->id.'-'.time().'-'.$image_name;
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
        $user->updateById($user_id, array(
            "name" => $validateEmployee['name'],
            "email" => $validateEmployee['email'],
            'age' => $age,
            'sex' => $validateEmployee['sex'],
            'birth_date' => Carbon::create($request->birth_date),
            'address' => $validateEmployee['address'],
            'image' => $img_name
        ));

        $worker = new Employee();
        $worker->updateById($employee->id, array(
            "motto" => $validateEmployee['motto'],
        ));

        if (Auth::user()->role == 'admin') {
            return redirect()->route('employees.show',['employee'=>$employee]);
        } elseif (Auth::user()->role == 'employee') {
            return redirect()->route('mobile.users.show');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }

    public function add_role(Request $request) {
        $new_role = $request->newRole;
        $role = new Role;
        $role->role_name = $new_role;
        $role->save();
        return redirect()->route('users.index');
    }

//    public function delete_role($id) {
//
//    }

    public function map(Request $request) {
        $employee_id = $request->employee;
        $goals = Goal::query()
                ->join('employees', 'goals.employee_id', '=', 'employees.id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->join('destinations', 'goals.destination_id', '=', 'destinations.id')
                ->select('goals.*', 'users.name as employee_name', 'destinations.destination_name', 'destinations.address')
                ->where('goals.status','=','finished')
                ->where('goals.employee_id','=', $employee_id)
                ->get();
        return response()->json($goals);
    }
}
