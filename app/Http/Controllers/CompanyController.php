<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\Employee;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Illuminate\Support\Facades\File;
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
        if (Auth::user()->role == 'admin') {
            $lists = Company::query()->orderBy('id','desc')->paginate(5);
            return view('Desktop.company.company_list',['lists'=>$lists]);
        } else {
            $lists = Company::query()->orderBy('id','desc')->paginate(7);
            return view('Test_Mobile.destination_list',['lists'=>$lists]);
//            return view('Mobile.company.destination_list',['lists'=>$lists]);
        }
    }

    public function company_detail($id){
        $details = Company::find($id);
        if (Auth::user()->role == 'admin') {
            return view('Desktop.company.company_detail',['details'=>$details]);
        } else {
            $user_id = Auth::user()->id;
            $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
            $count = Goal::query()->where('employee_id','=',$employee_id)
                ->where('company_id','=',$id)
                ->where('status','=','unfinished')
                ->count();
            return view('Mobile.company.destination_detail',['details'=>$details,'count'=>$count]);
            // return $count;
        }
    }

    public function company_form() {
        $businesses = BusinessCategory::all();
        return view('Desktop.company.company_form',['businesses'=>$businesses]);
    }

    public function company_delete($id){
        DB::table('companies')->where('id','=',$id)->delete();
        return redirect()->route('company_list');
    }

    public function edit_company($id){
        $details = Company::find($id);
        $businesses = BusinessCategory::all();
        return view('Desktop.company.edit_company',['details'=>$details,'businesses'=>$businesses]);
    }

    public function company_patch($id,Request $request){
        $validateCompany = $request->validate([
           'company_name' => 'required|string|max:255',
           'business-categories' => 'required',
           'address' => 'required|string|max:300',
           'email' => 'required|string|max:255',
           'coordinate' => 'required',
           'image' => 'nullable|image|mimes:jpeg,jpg,png',
           'description' => 'required|max:300'
        ]);

        $img_name = Company::query()->where('id','=',$id)->pluck('image');

        if ($request->hasFile('image')) {
            $folder = 'company'.$id;
            if(File::exists('storage/company/'.$folder)){
                File::cleanDirectory('storage/company/'.$folder);
            }

            $image_name = $request->file('image')->getClientOriginalName();
            $new_image_name = 'company/'.$folder.'/'.$id.'-'.time().'-'.$image_name;
            $img_name = $new_image_name;

            $request->image->storeAs('public',$img_name);
            asset('public/'.$new_image_name);
        }

        $split = explode(",", $request->coordinate);
        $latitude = $split[0];
        $longitude = $split[1];

        $company = new Company;
        $company->updateById($id, array(
                "company_name" => $validateCompany['company_name'],
                "business_id" => $validateCompany['business-categories'],
                "address" => $validateCompany['address'],
                "email" => $validateCompany['email'],
                "latitude" => $latitude,
                "longitude" => $longitude,
                "image" => $img_name,
                'description' => $validateCompany['description']
            )
        );
        return redirect()->route('company_detail',['id'=>$id]);
    }

    public function add_company(Request $request){
        $validateCompany = $request->validate([
            'company_name' => 'required|string|max:255',
            'business-categories' => 'required',
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
        $company->business_id = $validateCompany['business-categories'];
        $company->address = $validateCompany['address'];
        $company->email = $validateCompany['email'];
        $company->latitude = $latitude;
        $company->longitude = $longitude;
        $company->description = $validateCompany['description'];
        $company->save();

        return redirect()->route('company_list');
    }
}
