<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanyController extends Controller
{
    public function company_list(){
        $lists = DB::table('companies')->orderBy('id','desc')->paginate(5);
        return view('company.company_list',['lists'=>$lists]);
    }

    public function company_detail($id){
        $details = DB::table('companies')->where('id','=',$id)->get();
        return view('company.company_detail',['details'=>$details]);
    }

    public function company_form() {
        return view('company.company_form');
    }

    public function company_delete($id){
        DB::table('companies')->where('id','=',$id)->delete();
        return redirect()->route('company_list');
    }

    public function edit_company($id){
        $details = DB::table('companies')->where('id','=',$id)->get();
        return view('company.edit_company',['details'=>$details]);
    }

    public function company_patch($id,Request $request){
        $validateCompany = $request->validate([
           'company_name' => 'required|string|max:255',
           'business' => 'required|string|max:30',
           'address' => 'required|string|max:300',
           'coordinate' => 'required',
           'description' => 'required|max:300'
        ]);

        $split = explode(",", $request->coordinate);
        $latitude = $split[0];
        $longitude = $split[1];

        $company = new Company();
        $company->company_name = $validateCompany['company_name'];
        $company->business = $validateCompany['business'];
        $company->address = $validateCompany['address'];
        $company->email = $validateCompany['email'];
        $company->latitude = $latitude;
        $company->longitude = $longitude;
        $company->description = $validateCompany['description'];
        $company->update();

        return redirect()->route('company_detail',['id'=>$validateCompany['id']]);
    }

    public function add_company(Request $request){
        $validateCompany = $request->validate([
            'company_name' => 'required|string|max:255',
            'business' => 'required|string|max:30',
            'address' => 'required|string|max:300',
            'email' => 'required|string|max:255',
            'coordinate' => 'required',
            'description' => 'required|max:300'
        ]);

        $split = explode(",", $request->coordinate);
        $latitude = $split[0];
        $longitude = $split[1];

        $company = new Company();
        $company->company_name = $validateCompany['company_name'];
        $company->business = $validateCompany['business'];
        $company->address = $validateCompany['address'];
        $company->email = $validateCompany['email'];
        $company->latitude = $latitude;
        $company->longitude = $longitude;
        $company->description = $validateCompany['description'];
        $company->save();

        return redirect()->route('company_list');
    }

}
