<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function employee_list(){
        return view('Desktop.employee.employee_list');
    }

    public function employee_detail($id){
        $details = DB::table('employees')->where('id','=',$id)->get();
        return view('Desktop.employee.employee_detail',['details'=>$details]);
    }

    public function employee_delete($id){
        DB::table('employees')->where('id','=',$id)->delete();
        return redirect()->route('employee_list');
    }

    public function employee_update($id,Request $request){

    }
}
