<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;

class BusinessCategoryController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth');
        $this->middleware('can:business-categories.index')->only('index');
        $this->middleware('can:business-categories.show')->only('show');
        $this->middleware('can:business-categories.create')->only('create');
        $this->middleware('can:business-categories.store')->only('store');
        $this->middleware('can:business-categories.edit')->only('edit');
        $this->middleware('can:business-categories.update')->only('update');
        $this->middleware('can:business-categories.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = BusinessCategory::query()->paginate(10);
        return view('Desktop.business-categories.index',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('Desktop.business-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validateCategory = $request->validate([
            'name' => 'required|string'
        ]);
        $category = new BusinessCategory;
        $category->name = $validateCategory['name'];
        $category->save();

        return redirect()->route('business-categories.index')->withMessage('New business category has been added');
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
     * @return Application|Factory|View|Response
     */
    public function edit(BusinessCategory $businessCategory)
    {
        return view('Desktop.business-categories.edit',['category'=>$businessCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, BusinessCategory $businessCategory)
    {
        $businessCategory->update($request->all());

        return redirect()->route('business-categories.index', $businessCategory)
            ->withMessage('BusinessCategory category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BusinessCategory $businessCategory
     * @return RedirectResponse
     */
    public function destroy(BusinessCategory $businessCategory): RedirectResponse
    {
        $businessCategory->delete();

        return redirect()->route('business-categories.index');
    }
}
