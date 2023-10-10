<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Student;



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

Route::get('/home', [AuthController::class, 'home'])->name('home');

//login 
Route::post('/studentlogin/post', [UserController::class, 'studentlogin'])->name('studentlogin.post');
Route::get('/studentlogin/get', [AuthController::class, 'showStudentLoginForm'])->name('studentlogin.get');

Route::post('/stafflogin/post', [UserController::class, 'stafflogin'])->name('stafflogin.post');
Route::get('/stafflogin/get', [AuthController::class, 'showStaffLoginForm'])->name('stafflogin.get');

//register
Route::post('/studentregister/post', [UserController::class, 'studentregister'])->name('studentregister.post');
Route::get('/studentregister/get', [AuthController::class, 'showStudentRegisterForm'])->name('studentregister.get');

Route::post('/staffregister/post', [UserController::class, 'staffregister'])->name('staffregister.post');
Route::get('/staffregister/get', [AuthController::class, 'showStaffRegisterForm'])->name('staffregister.get');

// //home
Route::get('/staffhome', [AuthController::class, 'staffhome'])->name('staffhome');
Route::get('/studenthome', [AuthController::class, 'studenthome'])->name('studenthome');

//search student
Route::get('/staffhome/get', [UserController::class, 'search'])->name('staffhome.get');

Route::controller(UserController::class)->group(function () {
    Route::get('/staffhome', 'index')->name('staffhome');
    Route::get('/staffhome/export', 'export')->name('staffhome.export');
    Route::post('/staffhome/import', 'import')->name('staffhome.import');
});

//delete
Route::post('/staffhome/delete', [UserController::class, 'delete'])->name('staffhome.delete');
