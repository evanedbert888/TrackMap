<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function token() {
        $url = "https://www.arcgis.com/sharing/oauth2/token?client_id=FAvQ2yQYsmb4D8Rk&grant_type=client_credentials&client_secret=05e56276f99f46fda1b066b8b7e4eb4a&f=pjson";
        $response = Http::get($url);

        return $response["access_token"];
    }

    public function getAddress($address) {
        $response = $this->token();
        $url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?singleLine=".$address."&forStorage=true
        &token=".$response."&f=pjson";

        $response = Http::get($url);
        $candidates = $response["candidates"];
        $array = $candidates[0];
        $location = $array["location"];
        $x = strval($location["x"]);
        $y = strval($location["y"]);
        return [
            "x"=>$x,
            "y"=>$y
        ];
    }

    public function company_list(){
        $lists = DB::table('companies')->orderBy('id','desc')->paginate(5);
        return view('Desktop.company.company_list',['lists'=>$lists]);
    }

    public function company_detail($id){
        $details = Company::find($id);
        return view('Desktop.company.company_detail',['details'=>$details]);
    }

    public function company_form() {
        return view('Desktop.company.company_form');
    }

    public function company_delete($id){
        DB::table('companies')->where('id','=',$id)->delete();
        return redirect()->route('company_list');
    }

    public function edit_company($id){
        $details = Company::find($id);
        $businesses = Business::all();
        return view('Desktop.company.edit_company',['details'=>$details,'businesses'=>$businesses]);
    }

    public function company_patch($id,Request $request){
        $validateCompany = $request->validate([
           'company_name' => 'required|string|max:255',
           'business' => 'required',
           'address' => 'required|string|max:300',
           'email' => 'required|string|max:255',
           'coordinate' => 'required',
           'description' => 'required|max:300'
        ]);

        $split = explode(",", $request->coordinate);
        $latitude = $split[0];
        $longitude = $split[1];

        $company = new Company;
        $company->updateById($id, array(
                "company_name" => $validateCompany['company_name'],
                "business_id" => $validateCompany['business'],
                "address" => $validateCompany['address'],
                "email" => $validateCompany['email'],
                "latitude" => $latitude,
                "longitude" => $longitude,
                'description' => $validateCompany['description']
            )
        );
        return redirect()->route('company_detail',['id'=>$id]);
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
