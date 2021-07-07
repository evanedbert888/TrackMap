<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\Section;
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
    public function __construct() {
        $this->middleware('auth');
        $this->middleware([
           'role:admin|employee',
           'permission:employee index|show employee|edit employee|update employee|mobile edit profile|mobile update profile'
        ]);
    }

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
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return Application|Factory|View
     */
    public function show(Employee $employee)
    {
        return view('Desktop.employees.show',['details'=>$employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     * @return Application|Factory|View
     */
    public function edit(Employee $employee)
    {
        if (Auth::user()->hasPermissionTo('edit employee')) {
            return view('Desktop.employees.edit',['details'=>$employee]);
        } elseif (Auth::user()->hasPermissionTo('mobile edit profile')) {
            $details = Employee::query()->where('id','=',$employee->getAttributeValue('id'))->first();
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
        $employee_id = $employee->getAttributeValue('id');
        $user_id = Employee::query()->where('id','=',$employee_id)->value('user_id');
        $img_name = User::query()->where('id','=',$user_id)->value('image');

        $validateEmployee = $request->validate([
            'name' => 'string|required|max:255',
            'motto' => 'string|required|max:255',
            'email' => 'string|required|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'birth_date' => 'required',
            'sex' => 'required',
            'address' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $folder = 'employee'.$employee_id;
            if(File::exists('storage/employee/'.$folder)){
                File::cleanDirectory('storage/employee/'.$folder);
            }

            $image_name = $request->file('image')->getClientOriginalName();
            $new_image_name = 'employee/'.$folder.'/'.$employee_id.'-'.time().'-'.$image_name;
            $img_name = 'storage/'.$new_image_name;

            $validateEmployee['image']->storeAs('public/',$new_image_name);
        }

        $user = new User();
        $age = $user->findUserAge($request->input('birth_date'));

        $user->updateById($user_id, array(
            "name" => $validateEmployee['name'],
            "email" => $validateEmployee['email'],
            'age' => $age,
            'sex' => $validateEmployee['sex'],
            'birth_date' => Carbon::create($request->input('birth_date')),
            'address' => $validateEmployee['address'],
            'image' => $img_name
        ));

        $worker = new Employee();
        $worker->updateById($employee_id, array(
            "motto" => $validateEmployee['motto'],
        ));

        if (Auth::user()->hasPermissionTo('show employee')) {
            return redirect()->route('employees.show',['employee'=>$employee])->with('update','This employee detail has been updated!');
        } elseif (Auth::user()->hasPermissionTo('mobile profile')) {
            return redirect()->route('mobile.users.show')->with('update','Your profile update is success!');
        }
    }

    public function add_role(Request $request) {
        $new_role = $request->newRole;
        $section = new Section;
        $section->section_name = $new_role;
        $section->save();
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
