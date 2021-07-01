<?php

namespace App\Http\Controllers;

use App\Models\RegisteredEmail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisteredEmailController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware([
           'role:admin',
           'permission:registered-email index|create registered-email|store registered-email'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        $registers = RegisteredEmail::query()->paginate('10');
        return view('Desktop.registered-emails.index',['registers'=>$registers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('Desktop.registered-emails.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $id = Auth::id();
        $validateRegister = $request->validate([
            'email' => 'required|string|max:255'
        ]);

        $register = new RegisteredEmail();
        $register->email = $validateRegister['email'];
        $register->user_id = $id;
        $register->save();

        return redirect()->route('registered-emails.index')->with('Success','A New Email Has Been Registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
