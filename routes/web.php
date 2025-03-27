<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Seller\SellerAuthController;
use App\Http\Controllers\Seller\CityController;
use App\Models\Brand;

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
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::get('/dashboard', [UserAuthController::class, 'UserDashboard'])->name('dashboard');

Route::post('/user/profile/store', [UserAuthController::class, 'UserProfileStore'])->name('user.profile.store');

Route::get('/user/logout', [UserAuthController::class, 'UserLogout'])->name('user.logout');

Route::post('/user/update/password', [UserAuthController::class, 'UserUpdatePassword'])->name('user.update.password');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.index');
        })->name('admin.dashboard');
    });

    Route::get('/index', [LogController::class, 'index'])->name('admin.logs');
    Route::get('/logs/view/{file}', [LogController::class, 'view'])->name('logs.view');
    Route::get('/download/{file}', [LogController::class, 'download'])->name('logs.download');
    Route::delete('/delete/{file}', [LogController::class, 'delete'])->name('logs.delete');

    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/profile', [AdminAuthController::class, 'showProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminAuthController::class, 'storeProfile'])->name('admin.profile.store');
    Route::get('/change/password',[AdminAuthController::class, 'changePassword'])->name('admin.changePassword');
    Route::post('/update/password',[AdminAuthController::class, 'updatePassword'])->name('admin.updatePassword');

     //Students Routes
     Route::get('/student/create',[StudentController::class,'create'])->name('student.create');
     Route::get('/student/list',[StudentController::class,'list'])->name('student.list');
     Route::post('/student/store',[StudentController::class, 'store'])->name('student.store');
     Route::get('/student/edit/{id}',[StudentController::class,'edit'])->name('student.edit');
     Route::put('/student/update/{id}',[StudentController::class,'update'])->name('student.update');
     Route::get('/student/delete/{id}', [StudentController::class, 'delete'])->name('student.delete');


     //Customer Routes
     Route::get('/customer/create',[CustomerController::class,'create'])->name('customer.create');
     Route::get('/customer/list',[CustomerController::class,'list'])->name('customer.list');
     Route::post('/customer/store',[CustomerController::class, 'store'])->name('customer.store');
     Route::get('/customer/edit/{id}',[CustomerController::class,'edit'])->name('customer.edit');
     Route::put('/customer/update/{id}',[CustomerController::class,'update'])->name('customer.update');
     Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

     //Employee Routes
     Route::get('/employee/create',[EmployeeController::class,'create'])->name('employee.create');
     Route::get('/employee/list',[EmployeeController::class,'list'])->name('employee.list');
     Route::post('/employee/store',[EmployeeController::class, 'store'])->name('employee.store');
     Route::get('/employee/edit/{id}',[EmployeeController::class,'edit'])->name('employee.edit');
     Route::put('/employee/update/{id}',[EmployeeController::class,'update'])->name('employee.update');
     Route::get('/employee/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');


     Route::get('/brand/create',[BrandController::class,'create'])->name('brand.create');
     Route::get('/brand/list',[BrandController::class,'list'])->name('brand.list');
     Route::post('/brand/store',[BrandController::class, 'store'])->name('brand.store');
     Route::get('/brand/edit/{id}',[BrandController::class,'edit'])->name('brand.edit');
     Route::put('/brand/update/{id}',[BrandController::class,'update'])->name('brand.update');
     Route::get('/brand/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');
});

// Seller Routes
Route::prefix('seller')->group(function () {
    Route::middleware('auth:seller')->group(function () {
        Route::get('/dashboard', function () {
            return view('seller.index');
        })->name('seller.dashboard');
    });

    Route::get('/login', [SellerAuthController::class, 'showLoginForm'])->name('seller.login');
    Route::post('/login', [SellerAuthController::class, 'login']);
    Route::post('/logout', [SellerAuthController::class, 'logout'])->name('seller.logout');
    Route::get('/profile', [SellerAuthController::class, 'showProfile'])->name('seller.profile');
    Route::post('/profile/store', [SellerAuthController::class, 'storeProfile'])->name('seller.profile.store');
    Route::get('/change/password',[SellerAuthController::class, 'changePassword'])->name('seller.changePassword');
    Route::post('/update/password+',[SellerAuthController::class, 'updatePassword'])->name('seller.updatePassword');


     //cities Routes
     Route::get('/city/create',[CityController::class,'create'])->name('city.create');
     Route::get('/city/list',[CityController::class,'list'])->name('city.list');
     Route::post('/city/store',[CityController::class, 'store'])->name('city.store');
     Route::get('/city/edit/{id}',[CityController::class,'edit'])->name('city.edit');
     Route::put('/city/update/{id}',[CityController::class,'update'])->name('city.update');
     Route::get('/city/delete/{id}', [CityController::class, 'delete'])->name('city.delete');
});
