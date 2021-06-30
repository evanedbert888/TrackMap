<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;

class BusinessCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
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
     * @throws AuthorizationException
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
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
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
     * @param BusinessCategory $businessCategory
     * @return Application|Factory|View
     * @throws AuthorizationException
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
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, BusinessCategory $businessCategory): RedirectResponse
    {
        $businessCategory->update($request->all());

        return redirect()->route('business-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BusinessCategory $businessCategory
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(BusinessCategory $businessCategory): RedirectResponse
    {
        $businessCategory->delete();

        return redirect()->route('business-categories.index');
    }
}
