<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Goal;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware([
           'role:admin|employee',
           'permission:user index|show user|edit user|update user|destroy user|mobile profile'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // $uvdusers = User::query()->where('status','=','Unverified')->orderBy('created_at')->get();
        $uvdusers = User::query()->where('status','=','Unverified')->orderBy('created_at')->get();
        $vdusers = User::query()->where('status','=','Verified')->where('job','=','employee')->orderBy('updated_at')->get();
        $sections = Section::all();
        return view('Desktop.users.index', ['uvdusers'=>$uvdusers, 'vdusers'=>$vdusers, 'sections'=>$sections]);
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show()
    {
        $id = Auth::id();
        $details = User::query()->find($id);
        if (Auth::user()->hasPermissionTo('show user')) {
            return view('Desktop.users.show',['details'=>$details]);
        } elseif (Auth::user()->hasPermissionTo('mobile profile')) {
            return view('Mobile.employees.show',['details'=>$details]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view('Desktop.users.edit',['details'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $id = Auth::id();
        $img_name = User::query()->where('id','=',$id)->value('image');

        if ($request->hasFile('image')) {
            $folder = 'admin'.$id;
            if(File::exists('storage/admin/'.$folder)){
                File::cleanDirectory('storage/admin/'.$folder);
            }

            $image_name = $request->file('image')->getClientOriginalName();
            $new_image_name = 'admin/'.$folder.'/'.$id.'-'.time().'-'.$image_name;
            $img_name = 'storage/'.$new_image_name;

            $request->file('image')->storeAs('public/',$new_image_name);
        }

        $user = new User();
        $age = $user->findUserAge($request->input('birth_date'));

        $user->updateById($id, array(
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            'age' => $age,
            'sex' => $request->input('sex'),
            'birth_date' => Carbon::create($request->input('birth_date')),
            'address' => $request->input('address'),
            'image' => $img_name
        ));

        return redirect()->route('users.show')->with('update','Your profile update is success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param $employee_id
     * @return RedirectResponse
     */

    // temporary, data tidak akan delete cuma status unavailable aja
    public function destroy(int $id, $employee_id): RedirectResponse
    {
        User::destroy($id);
        Employee::destroy($employee_id);

        $folder = 'employee'.$employee_id;
        if(File::exists('storage/employee/'.$folder)){
            File::cleanDirectory('storage/employee/'.$folder);
            File::deleteDirectory('storage/employee/'.$folder);
        }
        return redirect()->route('users.index')->with('delete',"A user has been deleted!");
    }

    public function dashboard(Request $request): JsonResponse
    {
        $select = $request->select;
        $user_id = Auth::id();
        $job = Auth::user()->job;
        $time = strval(now());
        $date = explode(" ", $time);
        $partDate = explode("-", $date[0]);

        //Admin
        if ($job == "admin") {
            if ($select == "Today") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.user_id','=',$user_id)
                    ->where('goals.updated_at','like', $date[0].'%')
                    ->get()->load(['employee.user'])->load('destination');
            }
            else if ($select == "This Week") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.user_id','=',$user_id)
                    ->where(DB::raw('yearweek(goals.updated_at)'),'=', DB::raw('yearweek(curdate())'))
                    ->get()->load(['employee.user'])->load('destination');
            }
            else if ($select == "This Month") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.user_id','=',$user_id)
                    ->where('goals.updated_at','like', $partDate[0].'-'.$partDate[1].'-%')
                    ->get()->load(['employee.user'])->load('destination');
            }
            else if ($select == "This Year") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.user_id','=',$user_id)
                    ->where('goals.updated_at','like', $partDate[0].'%')
                    ->get()->load(['employee.user'])->load('destination');
            }
            else {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.user_id','=',$user_id)
                    ->get()->load(['employee.user'])->load('destination');
            }
        }

        //Employee
        else if ($job == "employee"){
            $employee = Employee::query()->where('user_id', '=', $user_id)->get();
            if ($select == "Today") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.employee_id','=', $employee[0]->id)
                    ->where('goals.updated_at','like', $date[0].'%')
                    ->get()->load(['employee.user'])->load('destination');
            }
            else if ($select == "This Week") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.employee_id','=', $employee[0]->id)
                    ->where(DB::raw('yearweek(goals.updated_at)'),'=', DB::raw('yearweek(curdate())'))
                    ->get()->load(['employee.user'])->load('destination');
            }
            else if ($select == "This Month") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.employee_id','=', $employee[0]->id)
                    ->where('goals.updated_at','like', $partDate[0].'-'.$partDate[1].'-%')
                    ->get()->load(['employee.user'])->load('destination');
            }
            else if ($select == "This Year") {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.employee_id','=', $employee[0]->id)
                    ->where('goals.updated_at','like', $partDate[0].'%')
                    ->get()->load(['employee.user'])->load('destination');
            }
            else {
                $goals = Goal::where('goals.status','=','finished')
                    ->where('goals.employee_id','=', $employee[0]->id)
                    ->get()->load(['employee.user'])->load('destination');
            }
        }
        return response()->json($goals);
    }

    public function update_status_user(Request $request): JsonResponse
    {
        $ids = $request->ids;
        $jobs = $request->roles;

        User::query()->whereIn('id',$ids)->update(['status'=>'Verified']);
        for ($i=0; $i < count($jobs); $i++) {
            $id = $ids[$i];
            $job = $jobs[$i];
            if ($job == "admin"){
                User::query()->where('id','=',$id)->update(['job'=>'admin']);
                Employee::query()->where('user_id','=',$id)->delete();
                user::query()->find($id)->removeRole('employee');
                user::query()->find($id)->assignRole('admin');
            }
            else {
                Employee::query()->where('user_id','=',$id)->update(['section_id'=>$job]);
            }
        }
        return response()->json();
    }
}
