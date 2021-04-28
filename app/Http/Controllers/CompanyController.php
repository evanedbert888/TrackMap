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

    public function company_patch($name,Request $request){
        $validateCompany = $request->validate([
           'company_name' => 'required|string|max:255',
           ''
        ]);
        return redirect()->route('company_detail',[]);
    }

    public function company_form(){
        return view('company.company_form');
    }

    public function add_company(Request $request){
        $validateCompany = $request->validate([

        ]);
        return redirect()->route('company_list');
    }

}
