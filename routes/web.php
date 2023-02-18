<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\MainController;
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

/**
* @method: GET
* @params:  
* @returns: 
* @since: 18/02/2023
* Comment: Loading student view
*/
Route::get('/', [MainController::class, 'loadStudent']);

/**
* @method: GET
* @params:  
* @returns: 
* @since: 18/02/2023
* Comment: Loading add student view
*/
Route::get('/add', function () {
    return view('add');
});

/* 
* Student adding in database 
*/
Route::post('/add-update', [MainController::class, 'addRecord']);
/*
* Delete student using id
*/
Route::post('destroy', [MainController::class, 'destroy'])->name('destroy');
/*
* Load list student data
*/
Route::get('students/list', [MainController::class, 'studentsList'])->name('students.list');
/*
* Edit student data using id
*/
Route::get('/edit/{id}',[MainController::class, 'edit'])->name('edit');
/*
* Students deleting from database
*/
Route::get('/delete-student/{id}',[MainController::class, 'deleteStudent']);