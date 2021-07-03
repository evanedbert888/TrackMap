<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusinessCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware([
            'role:admin',
            'permission:business-category index|create business-category|store business-category|edit business-category|update business-category|destroy business-category'
        ]);
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validateCategory = $request->validate([
            'name' => 'required|string|unique:business_categories'
        ]);
        $category = new BusinessCategory;
        $category->name = $validateCategory['name'];
        $category->save();

        return redirect()->route('business-categories.index')->with('create',"New business category [$category->name] has been added");
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
     * @param BusinessCategory $businessCategory
     * @return Application|Factory|View
     */
    public function edit(BusinessCategory $businessCategory)
    {
        return view('Desktop.business-categories.edit',['category'=>$businessCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BusinessCategory $businessCategory
     * @return RedirectResponse
     */
    public function update(Request $request, BusinessCategory $businessCategory): RedirectResponse
    {
        $updatedName = $businessCategory->name;
        $businessCategory->update($request->all());

        return redirect()->route('business-categories.index')->with('update',"The business category [$updatedName] has been updated into [$request->name]");
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

        return redirect()->route('business-categories.index')->with('delete',"The business category [$businessCategory->name] has been deleted!");
    }
}
