<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\Destination;
use App\Models\Employee;
use App\Models\Goal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $lists = Destination::query()->orderBy('id','desc')->paginate(5);
            return view('Desktop.destinations.index',['lists'=>$lists]);
        } else if (Auth::user()->role == 'employee') {
            $lists = Destination::query()->orderBy('id','desc')->paginate(7);
            return view('Mobile.destinations.index',['lists'=>$lists]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $businesses = BusinessCategory::all();
        return view('Desktop.destinations.create',['businesses'=>$businesses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validateDestination = $request->validate([
            'destination_name' => 'required|string|max:255',
            'business' => 'required',
            'address' => 'required|string|max:300',
            'email' => 'required|string|max:255',
            'coordinate' => 'required',
            'description' => 'required|max:300'
        ]);

        $split = explode(",", $request->coordinate);
        $longitude = $split[0];
        $latitude = $split[1];

        $destination = new Destination();
        $destination->destination_name = $validateDestination['destination_name'];
        $destination->business_id = $validateDestination['business'];
        $destination->address = $validateDestination['address'];
        $destination->email = $validateDestination['email'];
        $destination->latitude = $latitude;
        $destination->longitude = $longitude;
        $destination->description = $validateDestination['description'];
        $destination->save();

        return redirect()->route('destinations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show(Destination $destination)
    {
        if (Auth::user()->role == 'admin') {
            return view('Desktop.destinations.show',['details'=>$destination]);
        } else {
            $user_id = Auth::user()->id;
            $employee_id = Employee::query()->where('user_id','=',$user_id)->pluck('id');
            $count = Goal::query()->where('employee_id','=',$employee_id)
                ->where('destination_id','=',$destination->id)
                ->where('status','=','unfinished')
                ->count();
            return view('Mobile.destinations.show',['details'=>$destination,'count'=>$count]);
            // return $count;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit(Destination $destination)
    {
        $businesses = BusinessCategory::all();
        return view('Desktop.destinations.edit',['details'=>$destination,'businesses'=>$businesses]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, Destination $destination)
    {
        $validateDestination = $request->validate([
            'destination_name' => 'required|string|max:255',
            'business' => 'required',
            'address' => 'required|string|max:300',
            'email' => 'required|string|max:255',
            'coordinate' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'description' => 'required|max:300'
        ]);

        $img_name = Destination::query()->where('id','=',$destination->id)->pluck('image');

        if ($request->hasFile('image')) {
            $folder = 'destinations'.$destination->id;
            if(File::exists('storage/destinations/'.$folder)){
                File::cleanDirectory('storage/destinations/'.$folder);
            }

            $image_name = $request->file('image')->getClientOriginalName();
            $new_image_name = 'destinations/'.$folder.'/'.$destination->id.'-'.time().'-'.$image_name;
            $img_name = $new_image_name;

            $request->image->storeAs('public',$img_name);
            asset('public/'.$new_image_name);
        }

        $split = explode(",", $request->coordinate);
        $latitude = $split[0];
        $longitude = $split[1];

        $place = new Destination;
        $place->updateById($destination->id, array(
                "destination_name" => $validateDestination['destination_name'],
                "business_id" => $validateDestination['business'],
                "address" => $validateDestination['address'],
                "email" => $validateDestination['email'],
                "latitude" => $latitude,
                "longitude" => $longitude,
                "image" => $img_name,
                'description' => $validateDestination['description']
            )
        );
        return redirect()->route('destinations.show',['destination'=>$destination]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(Destination $destination): RedirectResponse
    {
        $destination->delete();
        return redirect()->route('destinations.index');
    }
}
