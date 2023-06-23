<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Product\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Home',function(){
    return view('AdminLayout');
});

Route::get('Dashboard',[DashboardController::class,'Dashboard'])->name('Dashboard');
Route::get('Student',[StudentController::class,'Student'])->name('Student');
Route::get('StudentShow',[StudentController::class,'StudentShow'])->name('StudentShow');
Route::post('StudentStore',[StudentController::class,'StudentStore'])->name('StudentStore');

Route::get('Product',[ProductController::class,'Product'])->name('Product');
Route::get('AddProduct',[ProductController::class,'AddProduct'])->name('AddProduct');
Route::post('ProductStore',[ProductController::class,'ProductStore'])->name('ProductStore');
Route::post('AttributeStore',[ProductController::class,'AttributeStore'])->name('AttributeStore');
Route::get('ProductShow',[ProductController::class,'ProductShow'])->name('ProductShow');

// routes/web.php
