<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanyController extends Controller
{
    public function company_list(){
        $lists = DB::table('companies')->paginate(5);
        return view('company.company_list',['lists'=>$lists]);
    }

    public function company_detail($name){
        $details = DB::table('companies')->where('company_name','=',$name)->get();
        return view('company.company_detail',['details'=>$details]);
    }

    public function company_delete($id){
        DB::table('companies')->where('id','=',$id)->delete();
        return redirect()->route('company_list');
    }

    public function

}
