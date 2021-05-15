<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function employee_list(){
        $lists = DB::table('employees')->orderBy('id','desc')->paginate(5);
        return view('Desktop.employee.employee_list',['lists'=>$lists]);
    }

    public function employee_detail($id){
        $details = DB::table('employees')->where('id','=',$id)->get();
        return view('Desktop.employee.employee_detail',['details'=>$details]);
    }

    public function employee_delete($id){
        DB::table('employees')->where('id','=',$id)->delete();
        return redirect()->route('employee_list');
    }
}
