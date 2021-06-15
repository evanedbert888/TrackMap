<?php

use App\Http\Controllers\BusinessCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TaskController;

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

Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');

Route::get('/dashboardgetgoals', [UserController::class,'dashboard'])
    ->name('dashboard_goals');

require __DIR__.'/auth.php';

// Desktop
Route::prefix('/SalesMap')->group(function() {
    Route::get('/Profile',[UserController::class,'profile'])->name('profile');
    Route::get('/EditProfile/{id}',[UserController::class,'edit_profile'])->name('edit_profile');
    Route::patch('/ProfileUpdate',[UserController::class,'profile_update'])->name('profile_update');

    // User
    Route::get('/User', [UserController::class, 'show_user'])->name('show_user');
    // Route::get('/UserVerify', [UserController::class, 'user_verify'])->name('user_verify');
    Route::post('/UpdateStatusUser', [UserController::class, 'update_status_user'])->name('update_status_user');
    Route::delete('/DeleteUser', [UserController::class, 'delete_user_manage'])->name('delete_user_manage');

    // Task Pairing
    Route::get('/TaskPairing',[TaskController::class, 'task_pairing'])->name('task_pairing');
    Route::get('/TaskPairingShowEmployees/{id?}',[TaskController::class,'show_employee_by_role'])->name('show_employees');
    Route::get('/TaskPairingShowCompanies/{id?}',[TaskController::class,'show_company_by_business'])->name('show_companies');
    Route::get('/StoreTask/{employee?}/{company?}',[TaskController::class,'store_task'])->name('store_task');
    Route::get('/ShowTask',[TaskController::class,'show_task'])->name('show_task');
    Route::get('TaskDelete/{id?}',[TaskController::class,'temp_delete'])->name('temp_delete');
    Route::post('/TaskInsert',[TaskController::class,'goals_insert'])->name('task_insert');
    Route::get('/TaskView',[TaskController::class, 'task_view'])->name('task_view');

    // Company
    Route::get('/CompanyList',[CompanyController::class,'company_list'])->name('company_list');
    Route::get('/CompanyDetail/{id}',[CompanyController::class,'company_detail'])->name('company_detail');
    Route::delete('/CompanyDelete/{id}',[CompanyController::class,'company_delete'])->name('company_delete');

    // Update Company
    Route::get('/EditCompany/{id}',[CompanyController::class,'edit_company'])->name('edit_company');
    Route::patch('/CompanyPatch/{id}',[CompanyController::class,'company_patch'])->name('company_patch');

    // Add New Company
    Route::get('/CompanyForm',[CompanyController::class,'company_form'])->name('company_form');
    Route::post('/AddCompany',[CompanyController::class,'add_company'])->name('add_company');
    Route::get('/CompanyLocation',[CompanyController::class,'getAddress'])->name('get_address');

    // Employee
    Route::get('/EmployeeList',[EmployeeController::class,'employee_list'])->name('employee_list');
    Route::get('/EmployeeDetail/{id}',[EmployeeController::class,'employee_detail'])->name('employee_detail');
    Route::delete('/EmployeeDelete/{id}',[EmployeeController::class,'employee_delete'])->name('employee_delete');

    // Update Employee
    Route::get('/EditEmployee/{id}',[EmployeeController::class,'edit_employee'])->name('edit_employee');
    Route::patch('/EmployeePatch/{id}',[EmployeeController::class,'employee_patch'])->name('employee_patch');

    // Role
    Route::get('/RoleList',[EmployeeController::class,'role_list'])->name('role_list');
    Route::post('/AddRole',[EmployeeController::class,'add_role'])->name('add_role');
    // Route::delete('/DeleteRole/{id}',[EmployeeController::class,'delete_role'])->name('delete_role');

    // Email Register
    Route::get('/EmailRegister',[RegisterController::class,"email_register"])->name('email_register');
    Route::post('/AddEmail',[RegisterController::class,'add_email'])->name('add_email');

    // Register List
    Route::get('/RegisterList',[RegisterController::class,'register_list'])->name('register_list');
    // Route::delete('/RegisterDelete',[RegisterController::class,'register_delete'])->name('register_delete');

//    // Users
//    Route::group(['prefix' => 'users', 'name' => 'users.'], function() {
//        Route::get('/', [UserController::class, 'index'])->name('index');
//        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
//        Route::patch('/', [UserController::class, 'update'])->name('update');
//    });

//    // Employees
//    Route::group(['prefix' => 'employees', 'name' => 'employees.'], function () {
//       Route::get('/', [EmployeeController::class, 'index'])->name('index');
//       Route::get('/{employee}', [EmployeeController::class, 'index/employee'])->name('index/employee');
//       Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
//       Route::patch('/{employee}', [EmployeeController::class, 'update'])->name('update');
//       Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
//    });

//    // Destinations
//    Route::group(['prefix' => 'destinations', 'name' => 'destinations.'], function (){
//        Route::get('/', [DestinationController::class, 'index'])->name('index');
//        Route::get('/{destination}', [DestinationController::class, 'index/destination'])->name('index/destination');
//        Route::get('/create', [DestinationController::class, 'create'])->name('create');
//        Route::post('/',[DestinationController::class, 'store'])->name('store');
//        Route::get('/{destination}/edit', [DestinationController::class, 'edit'])->name('edit');
//        Route::patch('/{destination}', [DestinationController::class, 'update'])->name('update');
//        Route::delete('/{destination}', [DestinationController::class, 'destroy'])->name('destroy');
//    });

//    // Registered-emails
//    Route::group(['prefix' => 'registered-emails', 'name' => 'registers.'], function (){
//        Route::get('/', [RegisterEmailController::class, 'index'])->name('index');
//        Route::get('/create', [RegisterEmailController::class, 'create'])->name('create');
//        Route::post('/', [RegisterEmailController::class, 'store'])->name('store');
//    });

    // Business-categories
    Route::group(['prefix' => 'business-categories', 'name' => 'businesses.'], function() {
        Route::get('/', [BusinessCategoryController::class, 'index'])->name('index');
        Route::get('/create', [BusinessCategoryController::class, 'create'])->name('create');
        Route::post('/', [BusinessCategoryController::class, 'store'])->name('store');
        Route::get('/{business-categories}/edit', [BusinessCategoryController::class, 'edit'])->name('edit');
        Route::put('/{business-categories}', [BusinessCategoryController::class, 'update'])->name('update');
        Route::delete('/{business-categories}', [BusinessCategoryController::class, 'destroy'])->name('destroy');
    });
});

// Mobile
Route::prefix('/SalesMap')->group(function (){
    // Destination
    Route::get('/DestinationList',[CompanyController::class,'company_list'])->name('destination_list');
    Route::get('/DestinationDetail/{id}',[CompanyController::class,'company_detail'])->name('destination_detail');

    // Task
    Route::get('/TaskList',[TaskController::class,'task_list'])->name('task_list');
    Route::patch('/TaskPatch',[TaskController::class,'task_checkIn'])->name('task_patch');

    // History
    Route::get('/History',[TaskController::class,'history'])->name('history');
});

// Test_Mobile View
Route::prefix('/SalesMap/Mobile')->group(function () {
    Route::get('/MobileView',function () {
       return view('layouts.mobile');
    });
    Route::get('/History',[TaskController::class,'history'])->name('mobile_history');
    Route::get('/Employee_Profile',[UserController::class,'profile'])->name('mobile_employee_profile');
    Route::get('/DestinationList',[CompanyController::class,'company_list'])->name('mobile_destination_list');
});
