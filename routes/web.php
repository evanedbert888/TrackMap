<?php

use App\Http\Controllers\BusinessCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RegisteredEmailController;
use App\Http\Controllers\TaskController;
use RealRashid\SweetAlert\Facades\Alert;

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

Route::get('/dashboardGetGoals', [UserController::class,'dashboard'])
    ->name('dashboard_goals');

require __DIR__.'/auth.php';

// Desktop
Route::prefix('/SalesMap')->group(function() {
    // Role CRUD without edit & update
    Route::get('/RoleList',[EmployeeController::class,'role_list'])->name('role_list');
    Route::post('/AddRole',[EmployeeController::class,'add_role'])->name('add_role');
    // Route::delete('/DeleteRole/{id}',[EmployeeController::class,'delete_role'])->name('delete_role');

    // User
    // Route::get('/UserVerify', [UserController::class, 'user_verify'])->name('user_verify');
    Route::post('/UpdateStatusUser', [UserController::class, 'update_status_user'])->name('update_status_user');

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/profile', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/', [UserController::class, 'update'])->name('update');
        Route::delete('/', [UserController::class, 'destroy'])->name('destroy');
    });

    // Tasks
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class,'index'])->name('index');
        Route::get('/create', [TaskController::class,'create'])->name('create');
        Route::post('/', [TaskController::class,'store'])->name('store');
        Route::delete('/{temp}', [TaskController::class,'destroy'])->name('destroy');

        Route::get('/TaskPairingShowEmployees/{id?}',[TaskController::class,'show_employee_by_role'])->name('show_employees');
        Route::get('/TaskPairingShowDestinations/{id?}',[TaskController::class,'show_destination_by_business'])->name('show_destinations');
        Route::get('/StoreTask/{employee?}/{destination?}',[TaskController::class,'store_task'])->name('store_task');
        Route::get('/ShowTask',[TaskController::class,'show_task'])->name('show_task');
    });

    Route::get('/employees/map/{employee}', [EmployeeController::class, 'map'])->name('map');

    // Employees
    Route::prefix('employees')->name('employees.')->group(function () {
       Route::get('/', [EmployeeController::class, 'index'])->name('index');
       Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
       Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
       Route::patch('/{employee}', [EmployeeController::class, 'update'])->name('update');
    });

    // Destinations
    Route::prefix('destinations')->name('destinations.')->group(function (){
        Route::get('', [DestinationController::class, 'index'])->name('index');
        Route::get('/create', [DestinationController::class, 'create'])->name('create');
        Route::post('',[DestinationController::class, 'store'])->name('store');
        Route::get('/{destination}', [DestinationController::class, 'show'])->name('show');
        Route::get('/{destination}/edit', [DestinationController::class, 'edit'])->name('edit');
        Route::patch('/{destination}', [DestinationController::class, 'update'])->name('update');
        Route::delete('/{destination}', [DestinationController::class, 'destroy'])->name('destroy');
    });

    // Registered-emails
    Route::prefix('registered-emails')->name('registered-emails.')->group(function () {
        Route::get('', [RegisteredEmailController::class, 'index'])->name('index');
        Route::get('/create',[RegisteredEmailController::class, 'create'])->name('create');
        Route::post('',[RegisteredEmailController::class, 'store'])->name('store');
    });

    // Business-categories
    Route::prefix('business-categories')->name('business-categories.')->group(function() {
        Route::get('', [BusinessCategoryController::class, 'index'])->name('index');
        Route::get('/create', [BusinessCategoryController::class, 'create'])->name('create');
        Route::post('', [BusinessCategoryController::class, 'store'])->name('store');
        Route::get('/{businessCategory}/edit', [BusinessCategoryController::class, 'edit'])->name('edit');
        Route::patch('/{businessCategory}', [BusinessCategoryController::class, 'update'])->name('update');
        Route::delete('/{businessCategory}', [BusinessCategoryController::class, 'destroy'])->name('destroy');
    });
});

// Mobile
Route::prefix('/SalesMap')->group(function (){
    // Users
    Route::prefix('mobile.users')->name('mobile.users.')->group(function (){
        Route::get('/profile', [UserController::class,'show'])->name('show');
        Route::get('/{employee}/edit', [EmployeeController::class,'edit'])->name('edit');
    });

    // Destinations
    Route::prefix('mobile.destinations')->name('mobile.destinations.')->group(function (){
        Route::get('',[DestinationController::class,'index'])->name('index');
        Route::get('/{destination}', [DestinationController::class, 'show'])->name('show');
    });

    // Goals
    Route::prefix('goals')->name('goals.')->group(function (){
        Route::get('/', [GoalController::class,'index'])->name('index');
        Route::patch('/', [GoalController::class,'update'])->name('update');
        Route::get('/history', [GoalController::class,'history'])->name('history');
    });
});
