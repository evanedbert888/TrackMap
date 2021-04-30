<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::prefix('/SalesMap')->group(function() {
    Route::get('/Profile',[UserController::class,'profile'])->name('profile');
    Route::patch('/Profile_Update',[UserController::class,'profile_update'])->name('profile_update');

    // Company
    Route::get('/CompanyList',[CompanyController::class,'company_list'])->name('company_list');
    Route::get('/CompanyDetail/{name}',[CompanyController::class,'company_detail'])->name('company_detail');
    Route::delete('/CompanyDelete/{id}',[CompanyController::class,'company_delete'])->name('company_delete');

    // Update Company
    Route::patch('/CompanyPatch/{name}',[CompanyController::class,'company_patch'])->name('company_patch');

    // Add New Company
    Route::view('/CompanyForm','company_form')->name('company_form');
    Route::post('/AddCompany',[CompanyController::class,'add_company'])->name('add_company');

    // Employee
    Route::get('/EmployeeList',[EmployeeController::class,'employee_list'])->name('employee_list');
    Route::get('/EmployeeDetail/{id}',[EmployeeController::class,'employee_detail'])->name('employee_detail');
    Route::delete('/EmployeeDelete/{id}',[EmployeeController::class,'employee_delete'])->name('employee_delete');

});
